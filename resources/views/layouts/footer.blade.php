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
</script>
</body>

</html>
