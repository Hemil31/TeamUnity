@extends('layouts.master')
@section('title', 'employee')
@section('page-title', 'Add Employee')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Employee Form</h4>
                        <form action="{{ route('employee.store') }}" method="POST" id="employeeForm">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="formType" value="add">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}">
                                <span class="text-danger" id="firstNameError"></span>
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}">
                                <span class="text-danger" id="lastNameError"></span>
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company_id">Company :</label>
                                @if ($data instanceof \App\Models\Companies)
                                    <select class="form-control" id="company_id" name="company_id"
                                        value="{{ old('company_id') }}">
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    </select>
                                @else
                                    <select class="form-control" id="company_id" name="company_id"
                                        value="{{ old('company_id') }}">
                                        <option value="">Select Company</option>
                                        @foreach ($data as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('company_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <span class="text-danger" id="companyError"></span>
                                @error('company_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                <span class="text-danger" id="emailError"></span>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}">
                                <span class="text-danger" id="phoneError"></span>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('asset/js/employee.js') }}"></script>
@endsection
