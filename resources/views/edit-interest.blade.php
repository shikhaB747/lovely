 <div class="modal-dialog modal-dialog-centered mw-400px">
     <div class="modal-content">


         <div class="modal-header py-3 d-flex justify-content-between">
             <h2>Edit Interest</h2>
             <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                 <span class="svg-icon svg-icon-1">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none">
                         <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                             transform="rotate(-45 6 17.3137)" fill="black" />
                         <rect x="7.41422" y="6" width="16" height="2" rx="1"
                             transform="rotate(45 7.41422 6)" fill="black" />
                     </svg>
                 </span>
             </div>
         </div>

         <form method="post" action="{{ route('update-interest') }}">
             @csrf

             <input type="hidden" name="id" value="{{ $interest->id }}">

             <div class="modal-body py-lg-8 px-lg-10">

                 <div class="card-body ps-0 pe-0 py-0 pt-0">
                     <div class="mb-5 fv-row fv-plugins-icon-container">
                         <label class="required form-label">Interest Title</label>
                         <input type="text" name="title" class="form-control mb-2"
                             placeholder="Enter Interest Title" value="{{ $interest->title }}">
                     </div>
                 </div>

                 <div class="card-body ps-0 pe-0 py-0 pt-0">
                     <div class="mb-5 fv-row fv-plugins-icon-container">
                         <label class="required form-label">Interest Details</label>
                         <div class="mb-5 fv-row possesive_main possesive_main1">
                             <div class="possesive_wrapper possesive_wrapper1">

                                 @if (!empty($interest->sub_title))
                                     @foreach ($interest->sub_title as $key => $subTitle)
                                         @if ($key == 0)
                                             <input type="text" name="possasive[]" required
                                                 class="form-control mb-2 option_counter"
                                                 placeholder="Enter interest here..." value="{{ $subTitle }}" />

                                             <a href="javascript:void(0);" id="appendDiv" class="add_button"
                                                 title="Add field"><img src="assets/media/images/add-icon.png" /></a>
                                         @else
                                             <div class="possesive_wrapper"><input type="text" name="possasive[]" class="form-control mb-2 option_counter"
                                                     placeholder="Enter interest here..."
                                                     value="{{ $subTitle }}" />
                                                     <a href="javascript:void(0);"
                                                     class="remove_button remove_data" title="Remove field"><img src="assets/media/images/remove-icon.png" /></a></div>
                                         @endif
                                     @endforeach
                                 @endif

                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="d-flex justify-content-end mb-6">
                     <button data-bs-dismiss="modal" type="submit" class="btn btn-light me-5">Close</button>
                     <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-shadow btn-primary">
                         Edit
                     </button>
                 </div>
             </div>

         </form>

     </div>
 </div>
