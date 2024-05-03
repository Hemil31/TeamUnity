@extends('layouts.master')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Content section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Companies</h5>
                    <p class="card-text">Manage Companies</p>
                    <a href="#" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Employees</h5>
                    <p class="card-text">Manage Employees</p>
                    <a href="#" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional features for managing employees -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Employee Management</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Add New Employee</h5>
                                    <p class="card-text">Add a new employee to the system.</p>
                                    <a href="#" class="btn btn-primary">Add Employee</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">View Employees</h5>
                                    <p class="card-text">View all employees and their details.</p>
                                    <a href="#" class="btn btn-primary">View Employees</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Departments</h5>
                                    <p class="card-text">Manage employee departments.</p>
                                    <a href="#" class="btn btn-primary">Manage Departments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
