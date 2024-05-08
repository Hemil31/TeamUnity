@extends('layouts.master')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Total Companies and Employees -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Companies Active</h5>
                    <p class="card-text">Registered Companies</p>
                    <h2>{{ $data->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Employees Active</h5>
                    <p class="card-text">Managed Employees</p>
                    <h2>@php
                        $totalEmployees = 0;
                        foreach ($data as $company) {
                            $totalEmployees += $company->employees->count();
                        }
                        echo $totalEmployees;
                    @endphp</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mt-4">
        <a href="{{ route('excel') }}" class="btn btn-success">Download Excel</a>
    </div>
    <!-- Table to display companies and their total employees -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Companies and Total Employees</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Total Employees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $company)
                                    <tr>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->employees->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
