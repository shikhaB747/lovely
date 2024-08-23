@extends('layout.app')
@section('content')
    <!--start::Wrapper-->
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
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Credit History</h1>
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Credit History</li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                </div>
            </div>
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container-xxl">
                    <div class="row gy-5 g-xl-10">
                        <div class="col-xl-12">
                            <div class="card h-md-100">
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                        height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                        fill="black" />
                                                    <path
                                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <input type="text" data-kt-ecommerce-order-filter="search"
                                                class="form-control form-control-solid w-250px ps-14"
                                                placeholder="Search by user name" id="myInput" />
                                        </div>
                                    </div>
                                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                                        <div class="w-100 mw-175px">
                                            <select class="form-select form-select-solid" data-control="select2"
                                                id="statusFilter" data-hide-search="true" data-placeholder="Plan Type"
                                                data-kt-ecommerce-order-filter="status">
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
                                        <table class="table table-row-dashed align-middle gs-0 gy-4 my-0" id="example">
                                            <thead>
                                                <tr class="fs-7 fw-bolder text-gray-500">
                                                    <th class="ps-0 w-50px">#</th>
                                                    <th class="min-w-200px">User detail</th>
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
                                                            <span class="">{{ $key + 1 }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-45px me-5">
                                                                    <img src="{{ $history->user->image_profile }}"
                                                                        alt="">
                                                                </div>
                                                                <div class="d-flex justify-content-start flex-column">
                                                                    <span
                                                                        class="text-dark fw-bolder fs-7">{{ $history->user->name }}</span>
                                                                    <span class="text-muted text-muted d-block fs-7">User
                                                                        id:#{{ $history->id . $history->user->id }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">

                                                            <span
                                                                class="badge @if ($history->membershipPlan->category == 'Premium') {{ 'badge-danger' }}@elseif($history->membershipPlan->category == 'Spotlight'){{ 'badge-success' }}@elseif ($history->membershipPlan->category == 'Super like'){{ 'badge-primary' }} @endif">{{ $history->membershipPlan->category }}
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
                                                            <span
                                                                class="text-muted">${{ $history->membershipPlan->price }}</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="text-muted">{{ $history->purchase_date }}</span>
                                                        </td>
                                                    </tr>

                                                @empty
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
            </div>
        </div>
        <!--end::Content-->

        <!--begin::Modal -  edit category detail-->
        <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-400px">
                <div class="modal-content ctgry-modl">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-header py-3 d-flex justify-content-between">
                                <h2>Edit Grocery Category</h2>
                                <div class="btn btn-sm btn-icon btn-active-color-primary">
                                </div>
                            </div>
                            <div class="modal-body py-lg-8 px-lg-7">
                                <div class="card-body pt-0 px-0 pb-0">
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="required form-label">Title</label>
                                        <input type="text" name="Category_name" class="form-control mb-2"
                                            placeholder="Enter your title" value="">
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="required form-label">Credit Point</label>
                                        <input type="text" name="Category_name" class="form-control mb-2"
                                            placeholder="Enter your credit point" value="">
                                    </div>
                                    <div class="uplod-ctegry">
                                        <label class="form-label">Image Upload</label>
                                        <div class="main-fileupldr meals-bgicon">
                                            <div class="img-uplder"><input id="file" type="file">
                                                <div class="filupl-rsltimg">
                                                    <span
                                                        style="background-image: url(https://dev.codemeg.com/caly-backend/public/no_image.png);"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="imageupld-notes mt-3">
                                            <p><strong>Note: </strong>Image dimension should be 370px in width * 208px in
                                                height
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end brdr-tp mb-2 py-lg-8 px-lg-10">
                        <button data-bs-dismiss="modal" type="submit" class="btn btn-shadow btn-light me-5">
                            <span class="indicator-label">Close</span>
                        </button>
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-shadow btn-primary">
                            <span class="indicator-label">Update</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal - edit category detail-->

        <!--begin::Modal - add Sticker-->
        <div class="modal fade" id="kt_modal_offer_a_deal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-400px">
                <div class="modal-content ctgry-modl">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-header py-3 d-flex justify-content-between">
                                <h2>Add Sticker</h2>
                                <div class="btn btn-sm btn-icon btn-active-color-primary">
                                </div>
                            </div>
                            <div class="modal-body py-lg-8 px-lg-7">
                                <div class="card-body pt-0 px-0 pb-0">
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="required form-label">Title</label>
                                        <input type="text" name="Category_name" class="form-control mb-2"
                                            placeholder="Enter your title" value="">
                                    </div>
                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                        <label class="required form-label">Credit Point</label>
                                        <input type="text" name="Category_name" class="form-control mb-2"
                                            placeholder="Enter your credit point" value="">
                                    </div>
                                    <div class="uplod-ctegry">
                                        <label class="form-label">Image Upload</label>
                                        <div class="main-fileupldr meals-bgicon">
                                            <div class="img-uplder"><input id="file" type="file">
                                                <div class="filupl-rsltimg">
                                                    <span
                                                        style="background-image: url(https://dev.codemeg.com/caly-backend/public/no_image.png);"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="imageupld-notes mt-3">
                                            <p><strong>Note: </strong>Image dimension should be 370px in width * 208px in
                                                height
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end brdr-tp mb-2 py-lg-8 px-lg-10">
                        <button data-bs-dismiss="modal" type="submit" class="btn btn-shadow btn-light me-5">
                            <span class="indicator-label">Close</span>
                        </button>
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-shadow btn-primary">
                            <span class="indicator-label">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal - add Sticker-->
    @endsection
