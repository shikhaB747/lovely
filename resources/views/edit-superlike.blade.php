<div class="modal-dialog modal-dialog-centered mw-400px">
    <div class="modal-content ctgry-modl">
        <div class="row">

            <form method="post" action="{{ route('edit-premium') }}">
                @csrf
                <input type="hidden" name="id" class="form-control mb-2" value="{{ $premium->id }}">
                <div class="col-md-12">

                    <div class="modal-header py-3 d-flex justify-content-between">
                        <h2>Edit Superlikes</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary">
                        </div>
                    </div>

                    <div class="modal-body py-lg-8 px-lg-7">
                        <div class="card-body pt-0 px-0 pb-0">
                            <div class="mb-5 fv-row fv-plugins-icon-container">
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Title</label>
                                    <input type="text" name="title" class="form-control mb-2"
                                        placeholder="Enter your title" value="{{ $premium->title }}" required>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Superlike Counts</label>
                                    <input type="text" name="super_likes_count" class="form-control mb-2"
                                        placeholder="Enter superlike counts" value="{{ $premium->super_likes_count }}"
                                        required>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Price</label>
                                    <input type="text" name="price" class="form-control mb-2"
                                        placeholder="Enter superlike price" value="{{ $premium->price }}" required>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Discount</label>
                                    <input type="number" name="discount" class="form-control mb-2"
                                        placeholder="Enter discount percent" value="{{ $premium->discount }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-lg-8 px-lg-7">
                        <div class="d-flex justify-content-end">

                            <button data-bs-dismiss="modal" type="button" class="btn btn-shadow btn-light me-5"> Close
                            </button>

                            <button type="submit" id="kt_ecommerce_add_category_submit"
                                class="btn btn-shadow btn-primary"> Save </button>

                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>
