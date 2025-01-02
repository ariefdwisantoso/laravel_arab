<script>
    $(document).ready(function() {
        // Show the modal when the "Create Theme" button is clicked
        $('#createThemeButton').click(function() {
            $('#createThemeModal').removeClass('hidden'); // Show the modal
            $('#errorMessages').addClass('hidden'); // Hide error messages when opening the modal
        });

        // Close the modal when the close button is clicked
        $('#closeModalButton').click(function() {
            $('#createThemeModal').addClass('hidden'); // Hide the modal
        });

        // Handle form submission with AJAX
        $('#createThemeForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Ambil data form
            var formData = new FormData(this);

            // Send the AJAX request
            $.ajax({
                url: "{{ route('theme.create') }}", // URL to send the request to
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle successful response with SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Theme Created!',
                        text: 'The theme has been successfully created.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Reload halaman setelah penghapusan sukses
                        location.reload(); // Reload halaman untuk memperbarui DataTable
                    });

                    $('#createThemeForm').trigger('reset'); // Reset the form
                    $('#createThemeModal').addClass('hidden'); // Hide the modal after submission
                },
                error: function(xhr, status, error) {
                    // Handle error response with SweetAlert
                    var errors = xhr.responseJSON.errors; // Get the error messages from the response
                    var errorMessages = ''; // Initialize an empty string for error messages

                    // Loop through each error and append it to the errorMessages string
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessages += '<p>' + errors[key][0] + '</p>';
                        }
                    }

                    // Display the error messages in a SweetAlert modal
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessages,
                        confirmButtonText: 'OK'
                    });

                    // Show error messages in the modal if needed
                    $('#errorMessages').html(errorMessages).removeClass('hidden'); // Show error messages
                }
            });
        });

        var table = $('#themesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('theme.index') }}",
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
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'file_path',
                    name: 'file_path'
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

        // Delete Theme
        $(document).on('click', '.delete-theme', function() {
            var themeId = $(this).data('id');
            var themeName = $(this).data('name');

            // Menampilkan konfirmasi SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete the theme: " + themeName + ". Deleting a theme will delete any related media.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX untuk menghapus tema
                    $.ajax({
                        url: '{{ route("theme.destroy", ":id") }}'.replace(':id', themeId), // Gunakan route name dan ganti :id dengan themeId
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                        },
                        success: function(response) {
                            // Menampilkan SweetAlert2 setelah sukses menghapus
                            Swal.fire(
                                'Deleted!',
                                'The theme has been deleted.',
                                'success'
                            ).then((result) => {
                                // Reload halaman setelah penghapusan sukses
                                location.reload(); // Reload halaman untuk memperbarui DataTable
                            });
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan error jika ada masalah saat menghapus
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the theme.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.edit-theme', function() {
        var themeId = $(this).data('id'); // Get the theme ID

        // Send AJAX request to get the theme details
        $.ajax({
            url: '{{ route("theme.update", ":id") }}'.replace(':id', themeId), // Use named route for the update
            method: 'GET',
            success: function(response) {
                // Fill in the form fields with the returned data
                $('#name').val(response.name);
                $('#description').val(response.description);
                $('#status').val(response.status);

                // Show the modal
                $('#editModalTheme').removeClass('hidden');
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Unable to load theme details', 'error');
            }
        });
    });

    // Close modal when clicking the close button
    $('#closeModalButtonTheme, #cancelModal').on('click', function() {
        $('#editModalTheme').addClass('hidden');
    });

    // Save form data
    $('#editThemeForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var themeId = $('.edit-theme').data('id'); // Get the theme ID
        var formData = new FormData(this); // Ambil semua data dari form

        // Send AJAX request to update the theme
        $.ajax({
            url: '{{ route("theme.update", ":id") }}'.replace(':id', themeId), // Use named route for the update
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(response) {
                Swal.fire('Success', 'Theme updated successfully!', 'success');
                $('#editModalTheme').addClass('hidden'); // Hide modal after update
                location.reload(); // Reload the page after update
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors || {};
                    var errorMessages = Object.values(errors).flat().join('<br>');
                    Swal.fire('Validation Error', errorMessages, 'error');
                } else {
                    Swal.fire('Error', 'Unable to update theme', 'error');
                }
            }
        });
    });

</script>