<div class="modal-dialog modal-dialog-centered mw-400px">
    <div class="modal-content ctgry-modl">
        <form method="post" action="{{ route('edit-premium') }}">
            @csrf

            <input type="hidden" name="id" class="form-control mb-2" value="{{ $premium->id }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal-header py-3 d-flex justify-content-between">
                        <h2> Edit Membership </h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary">
                        </div>
                    </div>
                    <div class="modal-body py-lg-8 px-lg-7">
                        <div class="card-body pt-0 px-0 pb-0">
                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                <label class="required form-label">Total Days</label>
                                <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                    name="validity" data-placeholder="Select Days" required
                                    id="kt_ecommerce_add_category_store_template12">

                                    <option></option>
                                    <option value="7" duration="1 week"
                                        @if ($premium->validity == 7) {{ 'selected' }} @endif> 7 days (1 week)
                                    </option>
                                    <option value="30" duration="1 month"
                                        @if ($premium->validity == 30) {{ 'selected' }} @endif> 30 days (1 month)
                                    </option>
                                    <option value="90" duration="3 months"
                                        @if ($premium->validity == 90) {{ 'selected' }} @endif> 90 days (3 months)
                                    </option>
                                    <option value="180" duration="6 months"
                                        @if ($premium->validity == 180) {{ 'selected' }} @endif> 180 days (6
                                        months) </option>
                                    <option value="365" duration="12 months"
                                        @if ($premium->validity == 365) {{ 'selected' }} @endif> 365 days (12
                                        months)
                                    </option>
                                </select>
                            </div>

                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                <label class="required form-label">Price</label>
                                <input type="number" name="price" class="form-control mb-2"
                                    placeholder="Enter your membership price" required value="{{ $premium->price }}">
                            </div>

                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                <label class="required form-label">Discount</label>
                                <input type="number" name="discount" class="form-control mb-2"
                                    placeholder="Enter discount percent" required value="{{ $premium->discount }}">
                            </div>

                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                <label class="form-label"> Duration </label>
                                <input type="text" name="duration" class="form-control mb-2" id="duration_in_text"
                                    value="{{ $premium->duration }}" readonly placeholder="Enter duration percent">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end brdr-tp mb-2 py-lg-8 px-lg-10">
                <button data-bs-dismiss="modal" type="button" class="btn btn-shadow btn-light me-5">
                    <span class="indicator-label">Close</span>
                </button>
                <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-shadow btn-primary">
                    <span class="indicator-label">Update</span>
                </button>
            </div>
        </form>
    </div>
</div>
