<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Employee;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Maatwebsite\Excel\Excel;

class DashboradController extends Controller
{
    public function index()
    {
        $data = Companies::all();
        return view('dashboard', compact('data'));
    }

    public function o(Request $request)
    {
        if ($request->has('id')) {
            // Retrieve only employees of a specific company if 'id' is provided
            $employees = Employee::where('company_id', $request->id)->get();
        } else {
            // Retrieve all employees
            $employees = Employee::all();
        }

        // Group employees by company
        $employeesByCompany = $employees->groupBy('company_id');

        // Create a CSV writer instance
        $csv = Writer::createFromString('');

        // Insert header row
        $csv->insertOne(['Company', 'ID', 'First Name', 'Last Name', 'Email', 'Phone']);

        // Loop through each company and its employees
        foreach ($employeesByCompany as $companyId => $employees) {
            // Retrieve the company name
            $company = Companies::find($companyId);
            $companyName = $company ? $company->name : '';

            // Insert company heading
            $csv->insertOne([$companyName]);

            // Insert employee data for each company
            foreach ($employees as $employee) {
                $csv->insertOne([
                    '', // Leave first column empty for company name
                    $employee->id,
                    $employee->first_name,
                    $employee->last_name,
                    $employee->email,
                    $employee->phone
                ]);
            }
        }
        // Set the filename for the CSV file
        $filename = 'employees.csv';
        // Return the CSV file as a response
        return response()->streamDownload(function () use ($csv) {
            echo $csv->getContent();
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
