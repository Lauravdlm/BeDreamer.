@if (Session::has('success'))
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}'
                });
            }, 500);
        });
    </script>
@endif
@if (Session::has('error'))
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}'
                });
            }, 500);
        });
    </script>
@endif
