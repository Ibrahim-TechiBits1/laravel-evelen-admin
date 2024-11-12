<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>


<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Recovery Account!</h1>
                            </div>
                            @if ($errors->has('message'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('message') }}
                                </div>
                            @endif
                            <form action="{{ route('forgot-password-verify') }}" method="POST">
                                @csrf
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Please enter the phone number you used when creating your
                                        account.</label>
                                    <input type="number" class="form-control" name="phone" id="phone" required />
                                    <span id="phone-status"></span>
                                </div>


                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Please enter the email address you used when creating your
                                        account.</label>
                                    <input type="email" class="form-control" name="email" id="email" required />
                                    <span id="email-status"></span>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Enter New Password</label>
                                    <input type="password" class="form-control" name="password" required />
                                </div>
                                <button type="submit" class="btn btn-primary mb-4 w-100">Recovery</button>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // For phone number input
            $('#phone').on('input', function() {
                var phone = $(this).val();

                // If the user enters a phone number
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
                                $('#phone-status').text('Phone number found in the database.')
                                    .css('color', 'green');
                            } else {
                                $('#phone-status').text(
                                        'Phone number not found in the database.')
                                    .css('color', 'red');
                            }
                        }
                    });
                } else {
                    $('#phone-status').text('');
                }
            });

            $('#email').on('input', function() {
                var email = $(this).val();

                // If the user enters an email
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
                                $('#email-status').text('Email found in the database.')
                                    .css('color', 'green');
                            } else {
                                $('#email-status').text('Email not found in the database.')
                                    .css('color', 'red');
                            }
                        }
                    });
                } else {
                    $('#email-status').text('');
                }
            });
        });
    </script>



</body>

</html>
