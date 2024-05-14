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
                        <form id="employeeForm" action="{{ route('employee.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}">
                                <div class="invalid-feedback" id="firstNameError"></div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}">
                                <div class="invalid-feedback" id="lastNameError"></div>
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
                                <div class="invalid-feedback" id="companyError"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                <div class="invalid-feedback" id="emailError"></div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}">
                                <div class="invalid-feedback" id="phoneError"></div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('employeeForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                // Validate inputs
                var firstName = document.getElementById('first_name').value.trim();
                var lastName = document.getElementById('last_name').value.trim();
                var companyId = document.getElementById('company_id').value;
                var email = document.getElementById('email').value.trim();
                var phone = document.getElementById('phone').value.trim();

                // Reset previous errors
                var formControls = document.getElementsByClassName('form-control');
                for (var i = 0; i < formControls.length; i++) {
                    formControls[i].classList.remove('is-invalid');
                }

                var invalidFeedback = document.getElementsByClassName('invalid-feedback');
                for (var i = 0; i < invalidFeedback.length; i++) {
                    invalidFeedback[i].textContent = '';
                }

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

                if (companyId === '') {
                    document.getElementById('company_id').classList.add('is-invalid');
                    document.getElementById('companyError').textContent = 'Company is required';
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
                    document.getElementById('phoneError').textContent = 'Invalid phone number format (10 digits)';
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
