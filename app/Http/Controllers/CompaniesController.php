<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all companies
            $data = Companies::Paginate(10);
            return view('companies.companies', compact('data'));
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
    public function show(string $id)
    {
        // Fetch the company by ID and show it
        try {
            $company = Companies::find($id);
            $data = DB::table('companies')
                ->join('employee', 'companies.id', '=', 'employee.company_id')
                ->where('company_id', $id)
                ->select('employee.*')
                ->get();

            return view('companies.showcompanies', compact('data', 'company'));
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
            // Find the company by ID
            $data = Companies::find($id);
            Session::put('edit_update_url', url()->previous());
            return view('companies.editcompanies', compact('data'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while showing the edit company form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'website' => 'required'
            ]);

            // Check if logo file is present in the request
            if ($request->hasFile('logo')) {
                // Store the uploaded logo file and get the file name to store in the database
                $fileNameToStore = $this->storeLogo($request->file('logo'));
                // Add the file name to the validated data
                $validatedData['logo'] = $fileNameToStore;
            }

            // Update the company with the validated data
            Companies::findOrFail($id)->update($validatedData);
            // Redirect with success message
            return redirect(Session::pull('edit_update_url'))->with('success', 'Company updated successfully');
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
            // Find the company by ID and delete it
            $com = Companies::find($id);
            // $com->softDeleteEmployees();
            $com->delete();
            // Redirect with success message
            return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
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
    private function storeLogo($file)
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
}
