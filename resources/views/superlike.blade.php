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
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Superlikes</h1>
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Plan </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Superlikes </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <div class="d-flex align-items-center py-1">
                        <a href="#" class="btn btn-shadow btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_offer_a_deal">Add Superlike</a>
                    </div>
                </div>
            </div>
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container-xxl">
                    <div class="row gy-5 g-xl-10">
                        <div class="col-xl-12">
                            <div class="card h-md-100">
                                <div class="card-body pt-6">
                                    <!--start::Table-->
                                    <div class="table-responsive prdct-tbl">
                                        <table class="table table-row-dashed align-middle gs-0 gy-4 my-0" id="example">
                                            <thead>
                                                <tr class="fs-7 fw-bolder text-gray-500">
                                                    <th class="ps-0 w-50px">#</th>
                                                    <th class="min-w-200px">Title</th>
                                                    <th class="min-w-150px">Superlikes</th>
                                                    <th class="min-w-170px">Price</th>
                                                    <th class="min-w-170px">Discount</th>
                                                    <th class="min-w-70px pe-0 text-end">ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($plansList))
                                                    @foreach ($plansList as $key => $plans)
                                                        <tr>
                                                            <td>
                                                                <span class="">{{ $key + 1 }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-start flex-column">
                                                                    <span
                                                                        class="text-dark fw-bolder fs-7">{{ $plans->title }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-muted">{{ $plans->super_likes_count }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted">${{ $plans->price }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted">{{ $plans->discount }}%</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="d-flex justify-content-end flex-shrink-0">
                                                                    <div class="svcrd-togl me-3">
                                                                        <div class="tgl-sld">
                                                                            <label>

                                                                                <input name="prprtyrelation" type="checkbox"
                                                                                    data-id="{{ $plans->id }}"
                                                                                    data-url="{{ URL('premium/status') }}"
                                                                                    onclick="updateStatus(this)"
                                                                                    id="checkbox{{ $plans->id }}"
                                                                                    @if ($plans->status == 0) {{ 'checked' }} @endif>

                                                                                <span>
                                                                                    <i></i>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <a href="#"
                                                                        onclick="ShowSuperEditForm({{ $plans->id }})"
                                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-2">
                                                                        <span class="svg-icon svg-icon-3"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="" data-bs-original-title="Edit">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none">
                                                                                <path opacity="0.3"
                                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                    fill="black"></path>
                                                                                <path
                                                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                    fill="black"></path>
                                                                            </svg>
                                                                        </span>
                                                                    </a>

                                                                    <a data-id="{{ $plans->id }}"
                                                                        href="javascript:void(0)"
                                                                        data-url="{{ URL('premium/delete') }}"
                                                                        onclick="deletePopup(this)" id="delete_record"
                                                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary me-3">

                                                                        <span class="svg-icon svg-icon-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="currentColor"
                                                                                opacity="0.3">
                                                                                <path
                                                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z">
                                                                                </path>
                                                                                <path opacity="0.5"
                                                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z">
                                                                                </path>
                                                                                <path opacity="0.5"
                                                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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

        {{-- Models --}}

        <!--begin::Modal -  edit Superlikes-->
        <div class="modal fade" id="superLikeEditModal" tabindex="-1" aria-hidden="true">

        </div>
        <!--end::Modal - edit Superlikes-->

        <!--begin::Modal - add Superlikes-->
        <div class="modal fade" id="kt_modal_offer_a_deal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-400px">
                <div class="modal-content ctgry-modl">
                    <div class="row">

                        <form method="post" action="{{ route('add-premium') }}" id="example">
                            @csrf

                            <div class="col-md-12">

                                <div class="modal-header py-3 d-flex justify-content-between">
                                    <h2>Add Superlikes</h2>
                                    <div class="btn btn-sm btn-icon btn-active-color-primary">
                                    </div>
                                </div>

                                <input type="hidden" name="category" class="form-control mb-2" value="Super like">

                                <div class="modal-body py-lg-8 px-lg-7">
                                    <div class="card-body pt-0 px-0 pb-0">
                                        <div class="mb-5 fv-row fv-plugins-icon-container">
                                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                                <label class="required form-label">Title</label>
                                                <input type="text" name="title" class="form-control mb-2"
                                                    placeholder="Enter your title">
                                            </div>

                                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                                <label class="required form-label">Superlike Count</label>
                                                <input type="number" name="super_likes_count" class="form-control mb-2"
                                                    placeholder="Enter Superlike Count">
                                            </div>

                                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                                <label class="required form-label">Price</label>
                                                <input type="number" name="price" class="form-control mb-2"
                                                    placeholder="Enter price">
                                            </div>

                                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                                <label class="required form-label">Discount</label>
                                                <input type="number" name="discount" class="form-control mb-2"
                                                    placeholder="Enter discount percent" value="0">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer py-lg-8 px-lg-7">
                                    <div class="d-flex justify-content-end">
                                        <button data-bs-dismiss="modal" type="button"
                                            class="btn btn-shadow btn-light me-5">
                                            Close
                                        </button>
                                        <button type="submit" id="kt_ecommerce_add_category_submit"
                                            class="btn btn-shadow btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal - add Superlikes-->
    @endsection
