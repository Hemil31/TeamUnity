<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployee;
use App\Models\Companies;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

/**
 * Summary of EmployeeController class
 * This class is responsible for handling the CRUD operations of the Employee resource.
 */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = Employee::latest()->get();
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addindexColumn()
                    ->addColumn('company', function ($row) {
                        return $row->company->name;
                    })
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
            return view('employees.employee');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $previousUrl = url()->previous();
            $currentUrl = url()->current();
            if ($request->has('id')) {
                $id = decrypt($request->id);
                if ($previousUrl === 'http://127.0.0.1:8000/companies/' . $id) {
                    Session::put('previous_add', 'http://127.0.0.1:8000/companies/' . $id);
                } else {
                    Session::put('previous_add', 'http://teamunity.com/companies/' . $id);
                }
            } elseif ($previousUrl !== $currentUrl) {
                Session::put('previous_add', $previousUrl);
            }
            if ($request->has('id')) {
                $data = Companies::find(decrypt($request->id));
            } else {
                $data = Companies::all();
            }
            return view('employees.addemployee', compact('data'));


        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching the Add Employee: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $data = $request->validated();

            $existingEmployee = Employee::where('email', $data['email'])->first();
            if ($existingEmployee) {
                return redirect()->back()->withInput()->with('success', 'Email already exists');
            }


            return redirect(session('previous_add', route('employee.index')))->with('success', 'Employee created successfully');
        } catch (\Exception $e) {
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
            $previousUrl = url()->previous();
            $currentUrl = url()->current();
            if ($previousUrl !== $currentUrl) {
                Session::put('previous_edit', $previousUrl);
            }
            $data = Employee::find($id);
            return view('employees.editemployee', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while showing the edit company form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployee $request, string $id)
    {
        try {
            $emp = Employee::findOrFail($id);
          
            $data = $request->validated();
            $existingEmployee = Employee::where('email', $data['email'])->where('id', '!=', $id)->first();
            if ($existingEmployee) {
                return redirect()->back()->withInput()->with('success', 'Email already exists');
            }
            $emp->update($data);
            return redirect(Session::get('previous_edit', route('employee.index')))->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the Employee: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            Employee::findOrFail($id)->delete();

            $previousUrl = URL::previous();

            if (strpos($previousUrl, 'employee') !== false) {
                return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
            } else {
                return redirect()->back()->with('success', 'Employee deleted successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the Employee: ' . $e->getMessage());
        }
    }
}
