@extends('layouts.master')
@section('title', 'employee')
@section('page-title', 'Employee Details')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3 d-flex">
                    <a href="{{ route('employee.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> <!-- Add Icon -->
                        Add Employee Detail
                    </a>
                </div>
                <div class="table">
                    <table class="table table-striped" id="employee-table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Here goes the table body content -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
