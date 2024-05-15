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
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ $data->first_name }}">
                                <div class="invalid-feedback" id="firstNameError"></div>
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ $data->last_name }}">
                                <div class="invalid-feedback" id="lastNameError"></div>
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $data->email }}">
                                <div class="invalid-feedback" id="emailError"></div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ $data->phone }}">
                                <div class="invalid-feedback" id="phoneError"></div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('employeeForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                // Validate inputs
                var firstName = document.getElementById('first_name').value.trim();
                var lastName = document.getElementById('last_name').value.trim();
                var email = document.getElementById('email').value.trim();
                var phone = document.getElementById('phone').value.trim();

                // Reset previous errors
                document.getElementById('firstNameError').textContent = '';
                document.getElementById('lastNameError').textContent = '';
                document.getElementById('emailError').textContent = '';
                document.getElementById('phoneError').textContent = '';

                var valid = true;

                if (firstName === '') {
                    document.getElementById('first_name').classList.add('is-invalid');
                    document.getElementById('firstNameError').textContent = 'First name is required';
                    valid = false;
                } else if (!isValidName(firstName)) {
                    document.getElementById('first_name').classList.add('is-invalid');
                    document.getElementById('firstNameError').textContent =
                        'First name should contain only alphabetic characters';
                    valid = false;
                }

                if (lastName === '') {
                    document.getElementById('last_name').classList.add('is-invalid');
                    document.getElementById('lastNameError').textContent = 'Last name is required';
                    valid = false;
                } else if (!isValidName(lastName)) {
                    document.getElementById('last_name').classList.add('is-invalid');
                    document.getElementById('lastNameError').textContent =
                        'Last name should contain only alphabetic characters';
                    valid = false;
                }

                if (email === '') {
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('emailError').textContent = 'Email is required';
                    valid = false;
                } else if (!isValidEmail(email)) {
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('emailError').textContent = 'Invalid email format';
                    valid = false;
                }

                if (phone === '') {
                    document.getElementById('phone').classList.add('is-invalid');
                    document.getElementById('phoneError').textContent = 'Phone number is required';
                    valid = false;
                } else if (!isValidPhone(phone)) {
                    document.getElementById('phone').classList.add('is-invalid');
                    document.getElementById('phoneError').textContent = 'Invalid phone number format';
                    valid = false;
                }

                // If all inputs are valid, submit the form
                if (valid) {
                    this.submit();
                }
            });

            // Function to validate alphabetic characters
            function isValidName(name) {
                var namePattern = /^[a-zA-Z]+$/;
                return namePattern.test(name);
            }

            // Function to validate email format
            function isValidEmail(email) {
                var emailPattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
                return emailPattern.test(email);
            }

            // Function to validate phone number format
            function isValidPhone(phone) {
                var phonePattern = /^\d{10}$/;
                return phonePattern.test(phone);
            }
        });
    </script>
@endsection
