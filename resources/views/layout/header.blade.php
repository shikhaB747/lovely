<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
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
    <!--start::Stylesheets link-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="{{ asset('assets/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" /> --}}
    <link href="https://cdn.datatables.net/2.1.0/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--end::Stylesheets link-->
    <style>
        @media (max-width:991px) {
            .header-tablet-and-mobile-fixed.toolbar-tablet-and-mobile-fixed .wrapper {
                padding-top: calc(0px + var(--kt-toolbar-height-tablet-and-mobile));
            }

            #kt_toolbar {
                display: none;
            }
        }
 
        .success-msg-card {
            background: #eaffea;
        }

        .success-msg-card p {
            color: #14c314;
        }

        .danger-msg-card {
            background: #ffebeb;
        }

        .danger-msg-card p {
            color: red;
        }

        .alert-warning {
            color: #665000;
            background-color: #fff4cc;
            border-color: #ffeeb3
        }

        .alert-warning .alert-link {
            color: #524000
        }

        .alert-danger {
            color: #912741;
            background-color: #fcd9e2;
            border-color: #fbc6d3
        }

        .alert-danger .alert-link {
            color: #741f34
        }
    </style>

    <script>
        const base_url = "{{ env('APP_URL') }}";
    
        function formatDate(dateString) {
            var options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };
            return new Date(dateString).toLocaleString('en-US', options);
        }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
