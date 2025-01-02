<script>
    $(document).ready(function() {
        // Show the modal when the "Create media" button is clicked
        $('#createMediaButton').click(function() {
            $('#createMediaModal').removeClass('hidden'); // Show the modal
            $('#errorMessages').addClass('hidden'); // Hide error messages when opening the modal
        });

        // Close the modal when the close button is clicked
        $('#closeModalButtonMedia').click(function() {
            $('#createMediaModal').addClass('hidden'); // Hide the modal
        });

        // Handle form submission with AJAX
        $('#createMediaForm').submit(function(event) {
            event.preventDefault();

            // Check if mediaType exists before proceeding
            var mediaType = $('#mediaType').val();
            if (!mediaType) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select a media type!',
                    confirmButtonText: 'OK'
                });
                return; // Stop the submission if mediaType is not selected
            }

            // Ambil data form
            var formData = new FormData(this);

            // Kirim data melalui AJAX
            $.ajax({
                url: "{{ route('media.create') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Media Created!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        location.reload(); // Reload halaman
                    });

                    $('#createMediaForm').trigger('reset');
                    $('#createMediaModal').addClass('hidden');
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = '';

                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessages += '<p>' + errors[key][0] + '</p>';
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessages,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Initialize DataTables
        var table = $('#mediaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('media.index') }}",
                type: "GET",
                error: function(xhr, error, code) {
                    console.error("Error:", error);
                    console.error("Code:", code);
                    console.error("Response:", xhr.responseText);
                }
            },
            columns: [{
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Nomor urut
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'theme',
                    name: 'theme'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'file',
                    name: 'file'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ]
        });

        // Delete Media
        $(document).on('click', '.delete-media', function() {
            var mediaId = $(this).data('id');
            var mediaName = $(this).data('media');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete the media: " + mediaName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("media.destroy", ":id") }}'.replace(':id', mediaId),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The media has been deleted.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the media.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.edit-media', function() {
        var mediaId = $(this).data('id'); // Ambil ID media dari tombol edit

        // Kirim permintaan AJAX untuk mendapatkan detail media
        $.ajax({
            url: '{{ route("media.edit", ":id") }}'.replace(':id', mediaId), // Sesuaikan URL dengan route Anda
            method: 'GET',
            success: function(response) {
                // Isi form dengan data yang diterima
                $('#mediaNameEdit').val(response.name);
                $('#mediaDescriptionEdit').val(response.description);
                $('#mediaTypeEdit').val(response.type);
                $('#mediaThemeEdit').val(response.theme_id);
                $('#mediaStatusEdit').val(response.status);
                $('#mediaQuizEdit').val(response.link);
                // Tampilkan modal edit
                $('#editModalMedia').removeClass('hidden');
            },
            error: function(xhr) {
                Swal.fire('Error', 'Unable to load media details', 'error');
            }
        });
    });

    // Tutup modal saat tombol close atau cancel diklik
    $('#closeModalButtonMedia, #cancelModalMedia').on('click', function() {
        $('#editModalMedia').addClass('hidden');
    });

    // Kirim data pembaruan melalui AJAX
    $('#editMediaForm').on('submit', function(e) {
        e.preventDefault(); // Hentikan submit default form

        var mediaId = $('.edit-media').data('id'); // Ambil ID media
        var formData = new FormData(this); // Ambil semua data dari form
        formData.append('_token', '{{ csrf_token() }}'); // Tambahkan CSRF token

        // Kirim permintaan AJAX untuk update media
        $.ajax({
            url: '{{ route("media.update", ":id") }}'.replace(':id', mediaId), // Sesuaikan URL
            method: 'POST', // Gunakan POST untuk simulasi PUT jika server tidak mendukung
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success:', response); // Tambahkan ini
                Swal.fire('Success', 'Media updated successfully!', 'success');
                $('#editModalMedia').addClass('hidden'); // Sembunyikan modal
                location.reload(); // Reload halaman untuk melihat perubahan
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors || {};
                    var errorMessages = Object.values(errors).flat().join('<br>'); // Gabungkan pesan kesalahan
                    Swal.fire('Validation Error', errorMessages, 'error');
                } else {
                    Swal.fire('Error', 'Unable to update media', 'error');
                }
            }
        });
    });
</script>