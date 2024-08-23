<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Livre</title>
    <meta charset="utf-8" />
    <meta name="author" content="Codemeg Solution Pvt. Ltd., info@codemeg.com">
    <meta name="url" content="http://codemeg.com">
    <meta name="description" content="Livre" />
    <meta name="keywords" content="Livre" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Livre" />
    <meta property="og:url" content="Livre" />
    <meta property="og:site_name" content="Livre" />
    <link rel="shortcut icon" href="{{env('APP_URL').'/public/favicon.ico'}}" />
    <!--start::Stylesheets link-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{asset('/plugins/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Stylesheets link-->
    <style>
        .password-toggle {
          position: relative;
        }

        #password {
            padding-right: 30px;
        }

        #togglePassword {
            position: absolute;
            top: 43%;
            right: 450px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #togglePassword2 {
            position: absolute;
            top: 59%;
            right: 450px;
            transform: translateY(-50%);
            cursor: pointer;
        }

    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <div class="login-logo">
                        <a href="{{route('landing-page')}}" >
                            <img alt="Logo" src="{{asset('/media/logos/logo.png')}}" class="" >
                        </a>
                    </div>
                    @include('flash-message')
                    <!--begin::Form-->
                    <form class="form w-100" method="POST" action="{{route('reset-password')}}" id="login_form" autocomplete="off" >
                      @csrf
                        <div class="mb-5">
                          <h1 class="text-dark fs-2">Reset Password | Livre {{$data->role}} Panel </h1>
                        </div>
                        <input type="hidden" name="token" value="{{$data->remember_token}}" >
                        
                        <div class="fv-row mb-10">
                           <label class="form-label fs-6 fw-bolder text-dark"> Password </label>
                           <input class="form-control form-control-lg" type="password" name="password" autocomplete="off" placeholder="Password"  id="passwordInput" >
                           <span toggle="#password-field" class="fa fa-eye" id="togglePassword" > </span> 
                        </div>
                        
                        <div class="fv-row mb-10" >
                            <div class="d-flex flex-stack mb-2" >
                                <label class="form-label fw-bolder text-dark fs-6 mb-0"> Confirm Password </label>
                                <a href="{{route('sign-up')}}" class="link-primary fs-6 fw-bolder"> Back to Login ? </a>
                            </div>
                            <input class="form-control form-control-lg" type="password" name="confirm_password" autocomplete="off" placeholder="Confirm Password" id="passwordInput2" >
                            <span toggle="#password-field" class="fa fa-eye" id="togglePassword2" > </span> 
                        </div>

                        <div class="text-center">
                           <button type="submit" class="btn btn-lg btn-shadow btn-primary w-100 mb-5"> <span class="indicator-label"> Save </span> </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Main-->
    <script src="{{asset('/plugins/plugins.bundle.js')}}"></script>
    <script src="{{asset('/js/scripts.bundle.js')}}"></script>
    <!--end::Javascript-->
    <script>
        $("#myalert").fadeTo(2000, 500).slideUp(500, function(){
            $("#myalert").slideUp(500);
        });

        // Password Field 1
        const passwordInput = document.getElementById('passwordInput');
        const toggleButton = document.getElementById('togglePassword');

        toggleButton.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        });

        // Password Field 2
        const passwordInput2 = document.getElementById('passwordInput2');
        const toggleButton2 = document.getElementById('togglePassword2');

        toggleButton2.addEventListener('click', function () {
            if (passwordInput2.type === 'password') {
                passwordInput2.type = 'text';
                toggleButton2.classList.remove('fa-eye');
                toggleButton2.classList.add('fa-eye-slash');
            } else {
                passwordInput2.type = 'password';
                toggleButton2.classList.remove('fa-eye-slash');
                toggleButton2.classList.add('fa-eye');
            }
        });


    </script>
</body>

</html>