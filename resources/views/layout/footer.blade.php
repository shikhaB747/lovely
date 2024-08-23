  <!--begin::Notification-->
  <div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true"
      data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
      data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
      <div class="card w-100 rounded-0 border-0" id="kt_drawer_chat_messenger">
          <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
              <div class="card-title">
                  <div class="d-flex justify-content-center flex-column me-3">
                      <h2 class="fs-4 fw-bolder text-gray-900  me-1 mb-2 lh-1 ">
                          Notification<span class="badge badge-warning badge-circle w-10px h-10px ms-1"></span>
                      </h2>
                  </div>
              </div>
              <div class="card-toolbar">
                  <div class="btn btn-sm btn-icon btn-active-light-success" id="kt_drawer_chat_close">
                      <span class="svg-icon svg-icon-2">
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
          </div>
          <div class="card-body" id="kt_drawer_chat_messenger_body">
              <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
                  data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                  data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
                  data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
                  <div class=" mb-5">
                      <div class="p-4 rounded bg-light-info text-dark fw-bold  text-start"
                          data-kt-element="message-text">
                          <h5 class="m-0">New User added</h5>
                          <span class="text-muted fw-bold text-muted d-block fs-7">Rahul is currently
                              Joined</span>
                      </div>
                  </div>
                  <div class=" mb-5">
                      <div class="p-4 rounded bg-light-success text-dark fw-bold  text-start"
                          data-kt-element="message-text">
                          <h5 class="m-0">New Matched</h5>
                          <span class="text-muted fw-bold text-muted d-block fs-7">Rahul and Shivani Recently
                              Matched.</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--end::Notification-->

  <!--begin::Scrolltop-->
  <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
      <span class="svg-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                  fill="black" />
              <path
                  d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                  fill="black" />
          </svg>
      </span>
  </div>
  <!--end::Scrolltop-->

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

  <!-- Delete Pop Up -->
  <div class="modal fade" id="deletePopup" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered tinysldr-main mw-400px">
          <div class="modal-content ctgry-modl">
              <div class="swal2-popup swal2-modal swal2-icon-error swal2-show">
                  <button type="button" class="swal2-close" aria-label="Close this dialog" data-bs-dismiss="modal"
                      type="submit">×</button>
                  <div class="swal2-icon swal2-error swal2-icon-show">
                      <span class="swal2-x-mark">
                          <span class="swal2-x-mark-line-left"></span>
                          <span class="swal2-x-mark-line-right"></span>
                      </span>
                  </div>
                  <h2 class="swal2-title">Are you sure?</h2>
                  <div class="swal2-html-container" id="swal2-html-container"> Do you want to Delete this!
                  </div>
                  <input type="hidden" id="recordID" value="">
                  <input type="hidden" id="route" value="">
                  <div class="swal2-actions">
                      <button type="button" class="swal2-deny btn btn-shadow btn-primary" aria-label=""
                          data-bs-dismiss="modal" type="submit">No</button>
                      <button type="button" class="swal2-confirm btn btn-shadow btn-primary" aria-label=""
                          id="deleteRecords" onclick="deleteRecord()">Yes Delete it!</button>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- End Delete Pop Up -->

  <!--begin::Javascript-->

  <script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/plugins.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
  <script src="{{ asset('assets/datatables/datatables.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/widgets.js') }}"></script>

  <!--end::Javascript-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.0/js/dataTables.bootstrap5.js"></script>

  <script type="text/javascript">
      new DataTable('#example');

      $(document).ready(function() {
          var maxField = 10; //Input fields increment limitation
          var addButton = $('.add_button'); //Add button selector
          var wrapper = $('.possesive_main'); //Input field wrapper
          var fieldHTML =
              '<div class="possesive_wrapper"><input required type="text" name="possasive[]" class="form-control mb-2 option_counter" placeholder="Enter interest here..." value="" /><a href="javascript:void(0);" class="remove_button add_remove_botton" title="Remove field"><img src="assets/media/images/remove-icon.png"/></a></div>';
          var x = 1; //Initial field counter is 1
          //Once add button is clicked
          $(addButton).click(function() {
              //Check maximum number of input fields
              if (x < maxField) {
                  x++; //Increment field counter
                  $(wrapper).append(fieldHTML); //Add field html
              }
          });
          //Once remove button is clicked
          $(wrapper).on('click', '.remove_button', function(e) {
              e.preventDefault();
              $(this).parent('div').remove(); //Remove field html
              x--; //Decrement field counter
          });
      });

    // ======================================================================

      var fieldHTML =
          '<div class="possesive_wrapper"><input required type="text" name="possasive[]" class="form-control mb-2 option_counter" placeholder="Enter interest here..." value="" /><a href="javascript:void(0);" class="remove_button add_remove_botton" title="Remove field"><img src="assets/media/images/remove-icon.png"/></a></div>';

      $('body').on('click', '#appendDiv', function() {

          $('.possesive_main1').append(fieldHTML);

          //Once remove button is clicked
          $('.possesive_main1').on('click', '.remove_button', function(e) {
              e.preventDefault();
              $(this).parent('div').remove(); //Remove field html
          });

      });

      $('body').on('click', '.remove_data', function() {
        $(this).parent('div').remove();
      });
 

      $('body').on('change', '#kt_ecommerce_add_category_store_template12', function() {
          var currentVal = $(this).val();
          var currentOption = $(this).find('option:selected');
          var currentDuration = currentOption.attr('duration');

          if (currentDuration) {
              $('#duration_in_text').val(currentDuration);
          }
      });

      function ShowEditForm(id) {
          $.ajax({
              url: base_url + ('/edit-premium-plan') + "/" + id,
              type: 'get',
              success: function(res) { 
                  $("#edit_membership_form").html(res);
                  $("#edit_membership_form").modal('show');
              }
          });
      }

      $("#myalert").fadeTo(2000, 500).slideUp(500, function() {
          $("#myalert").slideUp(500);
      });

      function ShowSuperEditForm(id) {
          $.ajax({
              url: base_url + ('/edit-super-like') + "/" + id,
              type: 'get',
              success: function(res) {
                  $("#superLikeEditModal").html(res);
                  $("#superLikeEditModal").modal('show');
              }
          });
      }

      function ShowSpotEditForm(id) {
          $.ajax({
              url: base_url + ('/edit-spot-light') + "/" + id,
              type: 'get',
              success: function(res) {
                  $("#spotLightEditModal").html(res);
                  $("#spotLightEditModal").modal('show');
              }
          });
      }

      // == Delete function

      function deletePopup(identifier) {
          $("#recordID").val($(identifier).data('id'));
          $("#route").val($(identifier).data('url'));
          $("#deletePopup").modal('show');
      }

      function showButtonLoader(id, text, action) {
          if (action === 'disable') {
              $('#' + id).prop('disabled', true);
          } else {
              $('#' + id).html(text);
              $('#' + id).prop('disabled', false);
          }
      }

      function deleteRecord() {
          let route = $("#route").val();
          let id = $("#recordID").val();
          showButtonLoader('deleteRecords', 'Delete', 'disable');
          $.ajax({
              url: route + "/" + id,
              type: 'get',
              dataType: 'json',
              success: function(res) {
                  showButtonLoader('deleteRecords', 'Delete', 'enable');
                  $("#deletePopup").modal('hide');
                  if (res.success == false) {
                      toastr.error(res.message);
                      location.reload();
                    
                  } else {
                      toastr.success(res.message);
                     // $('#example').DataTable().ajax.reload();
                     location.reload();
                  }
              }
          });
      }

      // Image Preview 
      const previewImage = e => {
          const preview = document.getElementById('preview-image');
          preview.src = URL.createObjectURL(e.target.files[0]);
          preview.onload = () => URL.revokeObjectURL(preview.src);
      };

      // =============

      function updateStatus(identifier) {

          var id = $(identifier).data('id');
          var url = $(identifier).data('url');
          var status = '';
          if (($('#' + identifier.id).is(':checked')) == true) {
              status = '0';
          } else {
              status = '1';
          }

          $.ajax({
              url: url + "/" + id + "/" + status,
              type: 'get',
              dataType: 'json',
              success: function(res) {
                  if (res.success == false) {
                      toastr.error(res.message);
                  } else {
                      toastr.success(res.message);
                      $('#table').DataTable().ajax.reload();
                  }
              }
          });
      }

      $(document).ready(function() {
          var table = $('#example').DataTable();

          // Custom search input filtering
          $('#myInput').on('keyup', function() {
              table.search(this.value).draw();
          });

          // Filter by Status column (assuming it's the second column with index 1)
          $('#statusFilter').on('change', function() {
              var selectedValue = $(this).val();
              table.search(selectedValue).draw();
          });

      });

      function ShowEditInterestForm(id) {
          $.ajax({
              url: base_url + ('/edit-interest') + "/" + id,
              type: 'get',
              success: function(res) {
                  $("#editInterest").html(res);
                  $("#editInterest").modal('show');
              }
          });
      }
  </script>

  </body>

  </html>
