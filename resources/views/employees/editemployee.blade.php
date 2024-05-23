@extends('layouts.master')
@section('title', 'employee')
@section('page-title', 'Add Employee')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Employee Update Form</h4>
                        <form action="{{ route('employee.update', $data->id) }}" method="POST" id="employeeForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" id="formType" value="edit">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ $data->first_name }}">
                                <span class="text-danger" id="firstNameError"></span>
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ $data->last_name }}">
                                <span class="text-danger" id="lastNameError"></span>
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $data->email }}">
                                <span class="text-danger" id="emailError"></span>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ $data->phone }}">
                                <span class="text-danger" id="phoneError"></span>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('asset/js/employee.js') }}"></script>
@endsection
