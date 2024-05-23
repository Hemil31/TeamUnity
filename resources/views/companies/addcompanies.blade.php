@extends('layouts.master')
@section('title', 'Company')
@section('page-title', 'Add Company')
@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <br>
                    <form id="companyForm" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="formType" value="add"> <!-- or "edit" -->
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}">
                            <span id="nameError" class="text-danger"></span>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email') }}">
                            <span id="emailError" class="text-danger"></span>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo (minimum 100x100)</label>
                            <input type="file" name="logo" id="logo" class="form-control-file">
                            <span id="logoError" class="text-danger"></span>
                            @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" class="form-control"
                                value="{{ old('website') }}">
                            <span id="websiteError" class="text-danger"></span>
                            @error('website')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <br><br>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('asset/js/company.js') }}"></script>
@endsection
