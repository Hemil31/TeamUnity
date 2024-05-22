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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('companyForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                // Validate inputs
                var name = document.getElementById('name').value.trim();
                var email = document.getElementById('email').value.trim();
                // var logo = document.getElementById('logo').value.trim();
                var website = document.getElementById('website').value.trim();

                // Reset previous errors
                document.getElementById('nameError').textContent = '';
                document.getElementById('emailError').textContent = '';
                // document.getElementById('logoError').textContent = '';
                document.getElementById('websiteError').textContent = '';

                var valid = true;

                // Check if name is empty
                if (name === '') {
                    document.getElementById('nameError').textContent = 'Name is required';
                    valid = false;
                }

                // Check if email is empty and valid
                if (email === '') {
                    document.getElementById('emailError').textContent = 'Email is required';
                    valid = false;
                } else if (!isValidEmail(email)) {
                    document.getElementById('emailError').textContent = 'Invalid email format';
                    valid = false;
                }


                // Check if website is empty and valid
                if (website === '') {
                    document.getElementById('websiteError').textContent = 'Website is required';
                    valid = false;
                } else if (!isValidWebsite(website)) {
                    document.getElementById('websiteError').textContent = 'Invalid website format';
                    valid = false;
                }

                // Submit form if all inputs are valid
                if (valid) {
                    this.submit();
                }
            });

            function isValidName(name) {
                var namePattern = /^[a-zA-Z]+$/;
                return namePattern.test(name);
            }

            function isValidEmail(email) {
                var emailPattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
                return emailPattern.test(email);
            }

            function isValidWebsite(website) {
                var websitePattern = /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w-._~:\/?#\[\]@!$&'()*+,;=]*)?$/;
                return websitePattern.test(website);
            }

            function isValidLogo(logo) {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                return allowedExtensions.test(logo);
            }
        });
    </script>
@endsection
