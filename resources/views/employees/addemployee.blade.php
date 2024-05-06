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
                        <form action="{{ route('employee.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company" id="">Company :</label>
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
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                @error('company_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
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
@endsection
