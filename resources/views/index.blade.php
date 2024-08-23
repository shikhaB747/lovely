@extends('layout.app')
@section('content')
    <!--begin::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--start::Header-->
        <div id="kt_header" class="header align-items-stretch">
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                    <div class="btn btn-icon btn-active-color-white" id="kt_aside_mobile_toggle">
                        <i class="bi bi-list fs-1"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="#" class="d-lg-none">
                        <img alt="Logo" src="assets/media/logos/logo.png" class="h-25px" />
                    </a>
                </div>
                <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                    <div class="d-flex align-items-stretch" id="kt_header_nav">
                    </div>
                    <div class="topbar d-flex align-items-stretch flex-shrink-0">
                        <div class="d-flex align-items-stretch">
                            <div class="topbar-item px-3 px-lg-5 position-relative" id="kt_drawer_chat_toggle">
                                <i class="bi bi-bell fs-2"></i>
                                <span
                                    class="bullet bullet-dot bg-success h-9px w-9px position-absolute translate-middle mt-4"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-stretch d-lg-none px-3 me-n3" title="Show header menu">
                            <div class="topbar-item" id="kt_header_menu_mobile_toggle">
                                <i class="bi bi-text-left fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="toolbar" id="kt_toolbar">
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard
                        </h1>
                    </div>
                </div>
            </div>
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container-xxl">
                    <div class="row g-5">
                        <div class="col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                            <div class="card">
                                <div class="card-header py-6">
                                    <div class="card-title flex-column align-items-start">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">
                                                {{ $data['thisMonthUsers'] }} </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-400 pt-1 fw-bold fs-6">This Month Users</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                            <div class="card">
                                <div class="card-header py-6">
                                    <div class="card-title flex-column align-items-start">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">{{ $data['totalMatchedUsers'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-400 pt-1 fw-bold fs-6">Total Matched User</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                            <div class="card">
                                <div class="card-header py-6">
                                    <div class="card-title flex-column align-items-start">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">{{ $data['overallUsers'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-400 pt-1 fw-bold fs-6">Overall Users</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted fw-bold me-1">2024©</span>
                        <span class="text-gray-800">Lovely</span>
                    </div>
                </div>
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    </div>
    <!--end::main-->
@endsection
