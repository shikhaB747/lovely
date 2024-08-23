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
                    {{-- {{$data}} --}}
                    <a class="d-lg-none">
                        <img alt="Logo" src="{{ $data->image_profile }}" class="h-25px" />
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
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">User Detail</h1>
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">User</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">User Detail</li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                </div>
            </div>
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container-xxl">
                    <div class="">
                        <div class="profmain-detal">
                            <div class="card mb-5 mb-xl-8">
                                <div class="card-body pt-15 position-relative">
                                    <div class="d-flex flex-center flex-column mb-5">
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            <img src="{{ $data->image_profile }}" alt="image">
                                        </div>
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">
                                            {{ ucfirst($data->name) }}</a>
                                        <div class="d-flex mb-6">
                                            <div class="fw-bolder me-2">User ID:</div>
                                            <div class="text-gray-600">#{{ $data->id }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-stack fs-4">
                                        <div class="fw-bolder rotate collapsible active">User Details
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div id="kt_customer_view_details" class="collapse show">
                                        <div class="py-0 fs-6">
                                            <div class="usrdtl-flx-main mt-8">
                                                <div class="usrdtl-flx-inner">
                                                    <div class="d-flex  justify-content-between">
                                                        <div class="fw-bolder fs-7">Date of Birth</div>
                                                        <div class="text-gray-600">
                                                            <span
                                                                class="text-gray-600 text-hover-primary">{{ $data->birthday }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Contact No.</div>
                                                        <div class="text-gray-600">
                                                            <span
                                                                class="text-gray-600 text-hover-primary">{{ $data->phone }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Email Address</div>
                                                        <div class="text-gray-600">
                                                            <span
                                                                class="text-gray-600 text-hover-primary">{{ $data->email }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Location</div>
                                                        <div class="text-gray-600">
                                                            <span
                                                                class="text-gray-600 text-hover-primary">{{ $data->location }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="usrdtl-flx-inner">
                                                    <div class="d-flex  justify-content-between">
                                                        <div class="fw-bolder fs-7">Date Of Registration</div>
                                                        <div class="text-gray-600">
                                                            <span class="text-gray-600 text-hover-primary">
                                                                {{ date('d-m-Y', strtotime($data->created_at)) }} </span>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Superlike</div>
                                                        <div class="text-warning">
                                                            <span
                                                                class="text-warning text-hover-warning">{{ $data->total_super_likes_points }}
                                                                Likes</span>
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Spotlight</div>
                                                        <div class="text-gray-600">250</div>
                                                    </div>
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <div class="d-flex  justify-content-between mt-5">
                                                        <div class="fw-bolder fs-7">Membership</div>
                                                        <div class="text-gray-600">7 Days Left</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card h-md-100">
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    {{-- <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <input type="text" data-kt-ecommerce-order-filter="search"
                                        class="form-control form-control-solid w-250px ps-14"
                                        placeholder="Search"  id="myInput" /> --}}
                                </div>
                            </div>
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                                <div class="w-100 mw-175px">
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Plan Type"
                                        data-kt-ecommerce-order-filter="status" id="statusFilter">
                                        <option></option>
                                        <option value=""> Default </option>
                                        <option value="Spotlight"> Spotlight </option>
                                        <option value="Premium"> Membership </option>
                                        <option value="Super like"> Superlikes </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-6">
                            <!--start::Table-->


                            <div class="table-responsive prdct-tbl">
                                <table id="example" class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                    <thead>
                                        <tr class="fs-7 fw-bolder text-gray-500">
                                            <th class="ps-0 w-50px">#</th>

                                            <th class="min-w-150px text-center">Credit Type</th>
                                            <th class="min-w-150px text-center">Plan Detail</th>
                                            <th class="min-w-100px text-center">Credit Price</th>
                                            <th class="min-w-100px text-end pe-0">Transaction Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($credit as $key => $history)
                                            <tr>
                                                <td>
                                                    <span>{{ $key + 1 }}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge 
                @if ($history->membershipPlan->category == 'Premium') badge-danger
                @elseif($history->membershipPlan->category == 'Spotlight') badge-success
                @elseif ($history->membershipPlan->category == 'Super like') badge-primary @endif">
                                                        {{ $history->membershipPlan->category }}
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="text-muted">
                                                        @if ($history->membershipPlan->category == 'Premium')
                                                            {{ $history->membershipPlan->duration }}
                                                        @elseif ($history->membershipPlan->category == 'Spotlight')
                                                            {{ $history->membershipPlan->spot_light_count }}
                                                            {{ $history->membershipPlan->category }}
                                                        @elseif ($history->membershipPlan->category == 'Super like')
                                                            {{ $history->membershipPlan->super_likes_count }}
                                                            {{ $history->membershipPlan->category }}
                                                        @endif
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="text-muted">${{ $history->membershipPlan->price }}</span>
                                                </td>

                                                <td class="text-end">
                                                    <span class="text-muted">{{ $history->purchase_date }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    No data available
                                                </td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
