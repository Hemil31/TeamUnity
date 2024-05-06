<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Companies;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Fetch all employees
            $data = Employee::query();
            // Check if the request is AJAX and return the data in JSON format
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
            // Return the employee index view
            return view('employees.employee');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while fetching the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            if ($request->has('id')) {
                // Find the company by ID
                $data = Companies::find($request->id);
                // Return the Add Employee view with the company data
                return view('employees.addemployee', compact('data'));
            } else {
                // Fetch all companies
                $data = Companies::all();
                // Return the Add Employee view
                return view('employees.addemployee', compact('data'));
            }

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
            Session::put('edit_employee_url', url()->previous());
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
            return redirect(Session::pull('edit_employee_url'))->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            // Find the employee by ID and delete
            Employee::findOrFail($id)->delete();

            // Check the previous URL to determine the redirection
            $previousUrl = URL::previous();

            if (strpos($previousUrl, 'employee') !== false) {
                // If the previous URL contains 'employee', redirect to the employee index page with a success message
                return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
            } else {
                // Otherwise, redirect back with a success message
                return redirect()->back()->with('success', 'Employee deleted successfully');
            }
        } catch (\Exception $e) {
            // Handle the exception by redirecting back with an error message
            return redirect()->back()->with('error', 'An error occurred while deleting the Employee: ' . $e->getMessage());
        }
    }
}
