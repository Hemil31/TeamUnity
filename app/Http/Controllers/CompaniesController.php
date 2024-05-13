<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Http\Requests\UpdateCompany;
use App\Jobs\EmailNotification;
use App\Mail\RegisterCompany;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use URL;
use Yajra\DataTables\DataTables;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            // Initialize the query
            $query = Companies::query();

            // Check if search query is provided
            if ($request->has('query')) {
                $search = $request->input('query');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('website', 'like', "%$search%");
                });
            }

            // Check if category filter is provided
            if ($request->has('category')) {
                $category = $request->input('category');
                if ($category === 'active' || $category === 'inactive') {
                    $query->where('status', $category);
                }
            }

            // Fetch all companies with pagination
            $data = $query->withTrashed()->paginate(10);
            $result = $data->firstItem();

            // Return the view with data
            return view('companies.companies', compact('data', 'result'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while fetching the companies: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Show the form for creating a new company
            return view('companies.addcompanies');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while showing the create company form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompaniesRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();

            // Check if a company with the same name or email already exists
            $company = Companies::where('name', $validatedData['name'])
                ->orWhere('email', $validatedData['email'])
                ->first();

            if ($company) {
                // If company already exists, redirect back with an error message
                return redirect()->back()->withInput()->with('error', 'The company with the given name or email is already registered.');
            }

            // Check if logo file is present in the request
            if ($request->hasFile('logo')) {
                // Store the uploaded logo file and get the file name to store in the database
                $fileNameToStore = $this->storeLogo($request->file('logo'));
                // Add the file name to the validated data
                $validatedData['logo'] = $fileNameToStore;
            }
            
            // Send email to the user
            EmailNotification::dispatch([
                'email' => $validatedData['email'],
                'name' => $validatedData['name']
            ])->onQueue('emails');

            // Create a new company with the validated data
            Companies::create($validatedData);

            // Redirect with success message
            return redirect()->route('companies.index')->with('success', 'Company added successfully');

        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while storing the company: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        // Fetch the company by ID and show it
        try {
            $company = Companies::find($id);

            $data = $company->employees;
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addindexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('employee.edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i>Edit</a>';
                        $btn .= '<form action="' . route('employee.destroy', $row->id) . '" method="POST" class="d-inline">
                                    ' . method_field('DELETE') . csrf_field() . '
                                    <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this employee?\')"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('companies.showcompanies', compact('company'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while showing the company: ' . $e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $previousUrl = url()->previous();
            $currentUrl = url()->current();

            // Check if previous and current URLs are different
            if ($previousUrl !== $currentUrl) {
                Session::put('previous_edit_url', $previousUrl);
            }
            // Find the company by ID
            $data = Companies::find($id);
            // Return the view with the company data
            return view('companies.editcompanies', compact('data'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while showing the edit company form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompany $request, string $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();

            // Check if logo file is present in the request
            if ($request->hasFile('logo')) {
                // Store the uploaded logo file and get the file name to store in the database
                $validatedData['logo'] = $this->storeLogo($request->file('logo'));
            }

            // Check if the name or email is being changed to one that already exists for another company
            $existingCompany = Companies::where('id', '!=', $id)
                ->where(function ($query) use ($validatedData) {
                    $query->where('name', $validatedData['name'])
                        ->orWhere('email', $validatedData['email']);
                })
                ->first();

            if ($existingCompany) {
                $errorMsg = $existingCompany->name === $validatedData['name']
                    ? 'Company with the same name already exists.'
                    : 'Company with the same email already exists.';
                return redirect()->back()->with('success', $errorMsg);
            }

            // Update the company with the validated data
            Companies::findOrFail($id)->update($validatedData);

            // Redirect with success message.
            return redirect(Session::get('previous_edit_url', route('companies.index')))->with('success', 'Company updated successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the company: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the company by ID
            $company = Companies::findOrFail($id);

            // Soft delete associated employees
            $company->employees()->delete();
            $company->status = 'inactive';
            $company->save();
            $company->delete();

            // Redirect with success message
            return redirect()->back()->with('success', 'Company deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while deleting the company: ' . $e->getMessage());
        }
    }

    /**
     * Summary of storeLogo
     * @param mixed $file
     * @return string|null
     */
    public function storeLogo($file)
    {
        try {
            // Generate a unique file name for the logo
            $fileNameToStore = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

            // Store the logo in the 'public/logo' directory
            $file->storeAs('public/logo', $fileNameToStore);

            return $fileNameToStore;
        } catch (\Exception $e) {
            // Handle the exception
            return null;
        }
    }

    public function restore(string $id)
    {
        try {
            // Find the company by ID
            $company = Companies::withTrashed()->findOrFail($id);
            // Restore the company
            $company->restore();
            // Update the status to active and save
            $company->status = 'active';
            $company->save();
            // Redirect with success message
            return redirect()->back()->with('success', 'Company restored successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while restoring the company: ' . $e->getMessage());
        }
    }

}
