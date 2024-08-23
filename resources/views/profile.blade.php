@extends('layout.app')
@section('content')
    <!--start::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div id="kt_header" class="header align-items-stretch">
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                    <div class="btn btn-icon btn-active-color-white" id="kt_aside_mobile_toggle">
                        <i class="bi bi-list fs-1"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="#" class="d-lg-none">
                        <img alt="Logo" src="assets/media/logos/logo.png" class="h-25px">
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

        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="toolbar" id="kt_toolbar">
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Profile</h1>
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Setting</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Profile</li>
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
                                <div class="card-body pt-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="advndr-flex">
                                                <div class="vndr-inerflx-100">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">Name</label>
                                                        <input type="text" name="restaurant" class="form-control mb-2"
                                                            placeholder="Enter Your Name" value="Anna Simmons">
                                                    </div>
                                                </div>
                                                <div class="vndr-inerflx-50">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">Email</label>
                                                        <input type="email" name="email" class="form-control mb-2"
                                                            placeholder="Enter your email address" value="anna@gmail.com">
                                                    </div>
                                                </div>
                                                <div class="vndr-inerflx-50">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">Phone</label>
                                                        <input type="tel" name="phone" class="form-control mb-2"
                                                            placeholder="Enter your mobile no." value="9858465144">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end brdr-tp mt-5 pt-8 px-lg-10">
                                                    <button data-bs-dismiss="modal" type="submit" class="btn btn-light me-5">
                                                        <span class="indicator-label">Close</span>
                                                    </button>
                                                    <button type="submit" id="kt_ecommerce_add_category_submit"
                                                        class="btn btn-primary">
                                                        <span class="indicator-label">Update</span>
                                                    </button>
                                                </div>
                                                
                                                <div class="vndr-inerflx-100">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">Old Password</label>
                                                        <div class="oldpassword-flx">
                                                            <div class="pwdinpu-cmn pwdinpu-bx">
                                                                <input type="password" name="password"
                                                                    class="form-control mb-2"
                                                                    placeholder="Enter old password here"
                                                                    value="**********">
                                                            </div>
                                                            <div class="pwdinpu-cmn chngepwd-btn">
                                                                <button type="submit" id="kt_ecommerce_add_category_submit"
                                                                    class="mb-2 btn btn-primary">
                                                                    Change Password
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="vndr-inerflx-50">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">New Password</label>
                                                        <input type="password" name="new_password"
                                                            class="form-control mb-2"
                                                            placeholder="Enter New password here" value="">
                                                    </div>
                                                </div>
                                                <div class="vndr-inerflx-50">
                                                    <div class="mb-5 fv-row fv-plugins-icon-container">
                                                        <label class="required form-label">Confirm Password</label>
                                                        <input type="password" name="confirm_password"
                                                            class="form-control mb-2"
                                                            placeholder="Enter Confirm password here" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="uplod-ctegry mb-5">
                                                <label class="form-label"> Profile Image</label>
                                                <div class="editimage-userdoc restro-imgupld">
                                                    <div class="img-uplder">
                                                        <div class="imguplod-editsign">
                                                            <em><i class="bi bi-pencil"></i></em>
                                                        </div>
                                                        <input id="file" type="file">
                                                        <div class="filupl-rsltimg">
                                                            <span
                                                                style="background-image: url(https://dev.codemeg.com/caly-backend/public/no_image.png);"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="imageupld-notes mt-3">
                                                    <p><strong>Note: </strong>Image dimension should be 370px in width *
                                                        208px in height</p>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>



                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->

        <!--start::confrimation-popup-box-->
        <div class="modal fade" id="kt_modal_create_campaign" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered tinysldr-main mw-400px">
                <div class="modal-content ctgry-modl">
                    <div class="swal2-popup swal2-modal swal2-icon-error swal2-show">
                        <button type="button" class="swal2-close" aria-label="Close this dialog"
                            data-bs-dismiss="modal" type="submit">×</button>
                        <div class="swal2-icon swal2-error swal2-icon-show">
                            <span class="swal2-x-mark">
                                <span class="swal2-x-mark-line-left"></span>
                                <span class="swal2-x-mark-line-right"></span>
                            </span>
                        </div>
                        <h2 class="swal2-title">Are you sure?</h2>
                        <div class="swal2-html-container" id="swal2-html-container">You want to Delete this Restaurant!
                        </div>
                        <div class="swal2-actions">
                            <button type="button" class="swal2-confirm btn btn-primary" aria-label="">Yes Delete
                                it!</button>
                            <button type="button" class="swal2-deny btn btn-primary" aria-label=""
                                data-bs-dismiss="modal" type="submit">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--start::confrimation-popup-box-->

        <!--begin::Modal - Map Location-->
        <div class="modal fade" id="kt_modal_offer_a_deal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h2>Location</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body p-0">
                        <div class="card-body p-0 pt-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-0 fv-row">
                                        <div class="map-location">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.746518937666!2d75.87374301443629!3d22.700478233986562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fdbb083cb955%3A0x35181305540ab4b!2sCodeMeg%20Soft%20Solutions%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1646649130712!5m2!1sen!2sin"
                                                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal - Map Location-->
    @endsection
