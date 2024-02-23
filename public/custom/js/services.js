$(document).ready(function() {
    var table = $('#services_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: "/get_services",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
                data: 'name',
                name: 'name',
                searchable: true
            }, {
                data: null,
                orderable: false,
                searchable: false,
                class: 'text-right services-action',
                render: function(data, type, row) {
                    if (data.status == 1) {
                        return '<button type="button" data-table="services" data-id=' + data.id + ' data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit Services" data-original-title="Edit Handler" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                        //Delete
                            '<button type="button" data-table="services" data-id="' + data.id + '"  data-name="' + data.name + '"data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> ';
                    } else {
                        return '<button type="button" data-table="services" data-id="' + data.id + '" data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#activate"  data-placement="top" title="Activate" data-original-title="Activate" class="activate btn btn-sm btn-secondary"><i class="fa fa-toggle-off"></i></button> ';
                    }
                }
            }
        ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

  
 
    // Edit - with universal route
    $('table tbody').on('click', '.edit', function() {

        // hidden inputs
        $('#hidden_edit_in_table').val($(this).data('table'));
        $('#hidden_id_edit').val($(this).data('id'));
        // header
        $('#edit_name_header').text("Edit - " + $(this).data('name'));
        // inputs
        $('#edit_name').val($(this).data('name'));


    });
    $('#edit_form').crud_delete();


    $('#save_btn').on('click', function(e) {
        e.preventDefault();
    
        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_service_name", function(xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_service_name");
    
        $(this).crud_click();
    });

    $('#update_btn').on('click', function(e) {
        e.preventDefault();
    
        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_service_name_edit", function(xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_service_name_edit", {
            "data": {
                "id": $("#hidden_id_edit").val()
            }
        });
    
        $(this).crud_click();
    });

});
