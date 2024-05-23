@extends('layouts.master')
@section('title', 'Company')
@section('page-title', 'Edit Company')


@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <br>
                    <form action="{{ route('companies.update', $data->id) }}" method="POST" enctype="multipart/form-data"
                        id="companyForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" id="formType" value="edit">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $data->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span id="nameError" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $data->email }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span id="emailError" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo (minimum 100x100)</label><br>
                            <label for="logo">(optional)</label>
                            <input type="file" name="logo" id="logo" class="form-control-file">
                            @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span id="logoError" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" class="form-control"
                                value="{{ $data->website }}">
                            @error('website')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span id="websiteError" class="text-danger"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <br><br>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('asset/js/company.js') }}"></script>
@endsection
