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
    <link href="{{asset('plugins/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Stylesheets link-->
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
              <a href="{{route('dashboard')}}">
                <img alt="Logo" src="{{asset('/media/logos/logo.png')}}" class="">
              </a>
            </div>
           
            @include('flash-message')
            <form class="form w-100" novalidate="novalidate" method="post" action="{{route('sendResetLinkEmail')}}" >
              @csrf
              <div class="mb-5">
                <h1 class="text-dark fs-2">Forgot Password</h1>
              </div>

              <div class="fv-row mb-10">
                <!-- <label class="form-label fs-6 fw-bolder text-dark">Email</label> -->
                <input class="form-control form-control-lg" type="email" name="email" autocomplete="off" placeholder="Enter your Email Id" >
              </div>
             
              <div class="text-center" > 
                <button type="submit" class="btn btn-lg btn-shadow btn-primary w-100 mb-5"> <span class="indicator-label"> Send Email </span>
                </button>
              </div>
              
            </form>
             
            <div class="text-right"> 
              <a href="{{url('/')}}" class="link-primary fs-6 fw-bolder"> Back to Login </a>
            </div>

          </div>
        </div>
      </div>
    </div>
    
    <!--end::Main-->
    <script src="{{asset('/plugins/plugins.bundle.js')}}"></script>
    <script src="{{asset('/js/scripts.bundle.js')}}"></script>
    <!--end::Javascript-->
  </body>
</html>