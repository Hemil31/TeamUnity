<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Companies;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all companies
            $data = Employee::all();
            return view('employees.employee', compact('data'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while fetching the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Fetch all companies
            $data = Companies::all();
            return view('employees.addemployee', compact('data'));
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while fetching the Add Employee: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {

        try {
            // Validate the request
            $data = $request->validated();
            // Create a new employee
            Employee::create($data);

            // Redirect to the employee index page with a success message
            return redirect()->route('employee.index')->with('success', 'Employee created successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while creating the Employee: ' . $e->getMessage());
        }
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
        try {
            // Find the company by ID
            $data = Employee::find($id);
            return view('employees.editemployee', compact('data'));
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
            // Validate the request
            $data = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            // Find the employee by ID and update
            Employee::findOrFail($id)->update($data);

            // Redirect to the employee index page with a success message
            return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
