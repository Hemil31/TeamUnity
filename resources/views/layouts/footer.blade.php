<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Us</h5>
                <p>Company & Employee Management is a comprehensive solution for managing your company's data and
                    workforce efficiently.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Companies</a></li>
                    <li><a href="#">Employees</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <address>
                    <strong>Company & Employee Management</strong><br>
                    123 Management Street,<br>
                    City, Country<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890<br>
                    <abbr title="Email">E:</abbr> info@companymanagement.com
                </address>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <p>&copy; 2024 Company & Employee Management. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS (optional, only if needed) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Your custom scripts -->
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

    function adjustFooterPosition() {
        var contentHeight = $('.content').outerHeight();
        var windowHeight = $(window).height();
        var footer = $('.footer');

        if (contentHeight < windowHeight) {
            footer.css('position', 'fixed');
            footer.css('bottom', 0);
        } else {
            footer.css('position', 'static');
        }
    }
    // Call on document ready and window resize
    $(document).ready(adjustFooterPosition);
    $(window).resize(adjustFooterPosition);
</script>
</body>

</html>
