<div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDataModalLabel">Hapus Data</h5>
            </div>
            <div class="modal-body">
                Data mau dihapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Ya</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            var url;
            $(document).on('click', '.delete-button', function () {
                var ID = $(this).data('kode');
                var master = $(this).data('master');
                var jenis = $(this).data('jenis');
                console.log("kode " + ID);
                console.log("master" + master);
                console.log("jenis" + jenis);

                url = '/'+master+'/'+jenis+'/' + ID;
            });
            $('#confirmDeleteButton').on('click', function () {
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {
                            '_token': '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            $('.modal-backdrop').remove();
                            $('#deleteDataModal').modal('hide'); // Correct the selector here
                            toastr.success(response.message);
                            table.draw();
                        },
                        error: function (xhr, status, error) {
                            // Handle errors, for example, display error messages
                            $('.modal-backdrop').remove();
                            $('#deleteDataModal').modal('hide'); // Correct the selector here
                            toastr.error(xhr.responseJSON.message);
                            table.draw();
                        }
                    });
                });
        })
    </script>
@endpush
