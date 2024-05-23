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

/**
 * Summary of CompaniesController class
 * This class is responsible for handling the CRUD operations of the Companies resource.
 * @package App\Http\Controllers
 */
class CompaniesController extends Controller
{
    /**
     * Display a listing of the Companies resource with pagination and search.
     */
    public function index(Request $request)
    {
        try {

            $query = Companies::query();

            if ($request->has('query')) {
                $search = $request->input('query');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('website', 'like', "%$search%");
                });
            }

            if ($request->has('category')) {
                $category = $request->input('category');
                if ($category === 'active' || $category === 'inactive') {
                    $query->where('status', $category);
                }
            }

            $data = $query->withTrashed()->paginate(10);
            $result = $data->firstItem();

            return view('companies.companies', compact('data', 'result'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching the companies: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource in storage with validation rules.
     */
    public function create()
    {
        try {
            return view('companies.addcompanies');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while showing the create company form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\CompaniesRequest $request The request object
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function store(CompaniesRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $existingCompany = Companies::where(function ($query) use ($validatedData) {
                $query->where('name', $validatedData['name'])
                    ->orWhere('email', $validatedData['email']);
            })->first();

            if ($existingCompany) {
                $errorMsg = $existingCompany->name === $validatedData['name']
                    ? 'Company with the same name already exists.'
                    : 'Company with the same email already exists.';
                return redirect()->back()->withInput()->with('success', $errorMsg);
            }

            if ($request->hasFile('logo')) {
                $validatedData['logo'] = $this->storeLogo($request->file('logo'));
            }

            EmailNotification::dispatch([
                'email' => $validatedData['email'],
                'name' => $validatedData['name']
            ])->onQueue('emails');

            Companies::create($validatedData);

            return redirect()->route('companies.index')->with('success', 'Company added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while storing the company: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @param string $id The ID of the company to show.
     * @param \Illuminate\Http\Request $request The request object
     */
    public function show(string $id, Request $request)
    {

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
            return redirect()->back()->with('error', 'An error occurred while showing the company: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $id The ID of the company to edit.
     */
    public function edit(string $id)
    {
        try {
            $previousUrl = url()->previous();
            $currentUrl = url()->current();

            if ($previousUrl !== $currentUrl) {
                Session::put('previous_edit_url', $previousUrl);
            }
            $data = Companies::find($id);
            return view('companies.editcompanies', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while showing the edit company form: ' . $e->getMessage());
        }
    }


    /**
     * Summary of update
     * @param \App\Http\Requests\UpdateCompany $request The request object
     * @param string $id The ID of the company to delete.
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompany $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('logo')) {
                $validatedData['logo'] = $this->storeLogo($request->file('logo'));
            }

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

            Companies::findOrFail($id)->update($validatedData);

            return redirect(Session::get('previous_edit_url', route('companies.index')))->with('success', 'Company updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the company: ' . $e->getMessage());
        }
    }


    /**
     * Delete a company and its associated employees.
     *
     * @param string $id The ID of the company to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function destroy(string $id)
    {
        try {
            $company = Companies::findOrFail($id);

            $company->employees()->delete();
            $company->status = 'inactive';
            $company->save();
            $company->delete();

            return redirect()->back()->with('success', 'Company deleted successfully');
        } catch (\Exception $e) {
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
            $fileNameToStore = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/logo', $fileNameToStore);

            return $fileNameToStore;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Summary of restore
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(string $id)
    {
        try {
            $company = Companies::withTrashed()->findOrFail($id);
            $company->restore();
            $company->status = 'active';
            $company->save();
            return redirect()->back()->with('success', 'Company restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while restoring the company: ' . $e->getMessage());
        }
    }
}
