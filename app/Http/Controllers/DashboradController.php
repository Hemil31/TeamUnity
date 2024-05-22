<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Employee;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Maatwebsite\Excel\Excel;

/**
 * Summary of DashboradController class
 * This class is responsible for handling the dashboard operations.
 * @package App\Http\Controllers
 */
class DashboradController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = Companies::all();

        return view('dashboard', compact('data'));
    }

    /**
     * Summary of excelDowload
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function excelDowload(Request $request)
    {
        try {
            if ($request->has('id')) {
                $employees = Employee::where('company_id', $request->id)->get();
            } else {
                $employees = Employee::all();
            }

            $empgrp = $employees->groupBy('company_id');

            $csv = Writer::createFromString('');

            $csv->insertOne(['Company', 'ID', 'First Name', 'Last Name', 'Email', 'Phone']);

            foreach ($empgrp as $companyId => $employees) {
                $company = Companies::find($companyId);
                $companyName = $company ? $company->name : '';

                $csv->insertOne([$companyName]);

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
            $filename = 'employees.csv';
            return response()->streamDownload(function () use ($csv) {
                echo $csv->getContent();
            }, $filename, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while fetching the Excel: ' . $th->getMessage());
        }

    }
}
