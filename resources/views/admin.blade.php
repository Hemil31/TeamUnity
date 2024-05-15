<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        .login-card {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Admin Login</h2>
                        <form method="post" action="{{ route('login') }}" id="adminLogin">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="{{ old('email') }}">
                                <span id="emailError" class="text-danger"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password" placeholder="Enter your password">
                                <input type="checkbox" onclick="myFunction()"><span> Show Password</span><br>
                                <span id="errorpassword" class="text-danger"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show success modal if there is a success message
            @if (session('success'))
                $('#successModal').modal('show');
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 1000);
            @endif

            // Show error modal if there is an error message
            @if (session('error'))
                $('#errorModal').modal('show');
                // setTimeout(function() {
                //     $('#errorModal').modal('hide');
                // }, 1000);
            @endif
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('adminLogin').addEventListener('submit', function(e) {
                e.preventDefault();
                // Validate inputs
                var email = document.getElementById('email').value.trim();
                var password = document.getElementById('password').value.trim();
                var valid = true;

                // Reset error messages
                document.getElementById('emailError').textContent = '';
                document.getElementById('errorpassword').textContent = '';

                // Validate email
                if (email === '') {
                    document.getElementById('emailError').textContent = 'Email is required';
                    valid = false;
                } else if (!isValidEmail(email)) {
                    document.getElementById('emailError').textContent = 'Invalid email format';
                    valid = false;
                }

                // Validate email format
                function isValidEmail(email) {
                    var emailPattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
                    return emailPattern.test(email);
                }

                // Validate password
                if (password === '') {
                    document.getElementById('errorpassword').textContent = 'Password is required';
                    valid = false;
                }

                // If valid, submit the form
                if (valid) {
                    this.submit();
                }
            });
        });
    </script>
</body>

</html>
