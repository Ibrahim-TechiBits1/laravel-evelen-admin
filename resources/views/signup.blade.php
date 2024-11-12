<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="icon" href="{{ asset('assets/img/laravel-logo.png') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>


<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="{{ route('user-create') }}" method="POST">
                                @csrf
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control form-control-user" name="first_name"
                                        required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control form-control-user" name="last_name"
                                        required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control form-control-user" name="username"
                                        required />
                                </div>


                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Phone</label>
                                    <input type="number" class="form-control form-control-user" id="phone"
                                        name="phone" required />
                                    <span id="phone-status"></span>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control form-control-user" id="email"
                                        name="email" required />
                                    <span id="email-status"></span>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control form-control-user" name="password"
                                        required />
                                </div>
                                <button type="submit" class="btn btn-primary mb-4 w-100">Sign In</button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('index') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('#phone').on('input', function() {
            var phone = $(this).val();

            if (phone) {
                $.ajax({
                    url: "{{ route('check-information') }}",
                    method: 'POST',
                    data: {
                        phone: phone,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#phone-status').text('This phone number is already taken.')
                                .css('color', 'red');
                        } else {
                            $('#phone-status').text(
                                    'This phone number is available.')
                                .css('color', 'green');
                        }
                    }
                });
            } else {
                $('#phone-status').text('');
            }
        });

        $('#email').on('input', function() {
            var email = $(this).val();

            if (email) {
                $.ajax({
                    url: "{{ route('check-information') }}",
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#email-status').text('This email is already taken.')
                                .css('color', 'red');
                        } else {
                            $('#email-status').text('This email is available.')
                                .css('color', 'green');
                        }
                    }
                });
            } else {
                $('#email-status').text('');
            }
        });
    });
</script>


</html>
