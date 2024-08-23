<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lovely</title>
    <meta charset="utf-8" />
    <meta name="author" content="Codemeg Solution Pvt. Ltd., info@codemeg.com">
    <meta name="url" content="http://codemeg.com">
    <meta name="description" content="Lovely" />
    <meta name="keywords" content="Lovely" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Lovely" />
    <meta property="og:url" content="Lovely" />
    <meta property="og:site_name" content="Lovely" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--Css Stylesheets-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--Css Stylesheets-->
    <style>
        .input-wthicon {
            position: relative;
        }

        .input-wthicon input {
            padding-right: 45px;
        }

        .input-icon {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0px;
            cursor: pointer;
        }

        .input-icon span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 100%;
        }
    </style>
</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <div class="login-logo">
                        <a href="#">
                            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" class="" />
                        </a>
                    </div>

                    <form class="form w-100" method="POST" action="{{ route('admin-login') }}" id="login_form">
                        @csrf
                        <div class="mb-5">
                            <h1 class="text-dark fs-2"> Login to Lovely Admin Panel </h1>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                            <input class="form-control form-control-lg" type="text" name="email"
                                placeholder="Enter your email" autocomplete="off" />
                            {{-- @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}
                        </div>
                        <div class="fv-row mb-10">
                            {{-- <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <a href="{{ route('forgot-password') }}" class="link-primary fs-6 fw-bolder"> Forgot
                                    Password ? </a>
                            </div> --}}
                            <div class="input-wthicon">
                                <input class="form-control form-control-lg" type="password" name="password"
                                    placeholder="********" autocomplete="off" id="password" />
                                <div class="input-icon">
                                    <span toggle="#password-field" class="fa fa-eye" id="togglePassword"> </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-shadow btn-primary w-100 mb-5"> Login </button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div>
                            @foreach ($errors->all() as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Add JS for Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--begin::Javascript-->
    <script src="{{ asset('assets/plugins/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>

    <script>
        const passwordField = document.getElementById('password');
        const passwordToggle = document.getElementById('togglePassword');

        passwordToggle.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        });
    </script>

</body>

</html>
