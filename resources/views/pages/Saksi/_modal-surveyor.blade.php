<div class="modal fade" id="modalSurveyor" tabindex="-1" aria-labelledby="modalSurveyorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalSurveyorLabel">Ambil data surveyor</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="w-100">
            <label  class="form-label">Nama/Email Surveyor</label>
            <select name="surveyor_id" id="select_surveyor"  class="form-select" id="single-select-field" data-placeholder="Choose one thing">
              <option value="0">Pilih Surveyor</option>
            </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@push('addScript')
    <script type="text/javascript">
        $(document).ready(function(){

          $("#select_surveyor").select2({
            dropdownParent: $("#modalSurveyor"),
            theme: 'bootstrap-5',
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            ajax: {
              url: "{{route('admin.real-count.getSurveyor')}}",
              type: "GET",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  search: params.term // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response
                };
              },
              cache: true
            }

          });

        });
    </script>
@endpush
