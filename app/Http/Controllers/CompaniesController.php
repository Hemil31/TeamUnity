<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Companies::all();
        return view('companies', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompaniesRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function storeLogo($file)
    {
        // Generate a unique file name for the logo
        $fileNameToStore = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

        // Store the logo in the 'public/logo' directory
        $file->storeAs('public/logo', $fileNameToStore);

        return $fileNameToStore;
    }
}
