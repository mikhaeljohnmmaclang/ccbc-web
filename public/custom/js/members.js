$(document).ready(function() {
    var table = $('#members_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        buttons: false,
        "lengthMenu": [ 50,  75, 100, 250, 500 ],
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: "/get_members",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
                data: 'full_name',
                name: 'full_name',
                searchable: true
            }, {
                data: null,
                orderable: false,
                searchable: false,
                class: 'text-right members-action',
                render: function(data, type, row) {
                    if (data.status == 1) {
                        return '<button type="button" data-table="members" data-id=' + data.id + ' data-bs-toggle="modal" data-bs-target="#modal_add_offerings" data-placement="top" title="Add Offering" data-original-title="Add Offering" class="add-offering-btn btn btn-sm btn-primary"><i class="fa fa-plus"></i></button> ' +
                         //Set Firstfruit
                         '<button type="button" data-table="members" data-commitment_id='+ data.commitment_id +' data-id=' + data.id + ' data-ff_amount=' + data.ff_amount + ' data-bs-toggle="modal" data-bs-target="#modal_set_ff" data-placement="top" title="Set Firstfruit" data-original-title="Set Firstfruit" class="set-ff btn btn-sm btn-secondary"><i class="fa fa-money-bill-alt"></i></button> ' +
                        //View
                        '<a href="/view_member/'+data.id+'" data-id=' + data.id + ' data-table="members"  data-placement="top" title="View Member" data-original-title="View Member" class="view-member btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a> ' +
                        //Edit
                        '<button type="button" '+
                        'data-table="members"' +
                        ' data-id=' + data.id + 
                        ' data-contact=' + data.contact_number + 
                        '" data-first_name="' + data.first_name + 
                        '" data-middle_name="' + data.middle_name + 
                        '" data-last_name="' + data.last_name + 
                        '" data-email="' + data.email + 
                        '" data-birthdate="' + data.birthdate + 
                        '" data-address="' + data.address + 
                        '" data-gender="' + data.gender + 
                        '" data-occupation="' + data.occupation + 
                        '"  data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit Members" data-original-title="Edit Handler" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                        //Delete
                            '<button type="button" data-table="members" data-id="' + data.id + '"  data-name="' + data.name + '"data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> ';
                    } else {
                        return '<button type="button" data-table="members" data-id="' + data.id + '" data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#activate"  data-placement="top" title="Activate" data-original-title="Activate" class="activate btn btn-sm btn-secondary"><i class="fa fa-toggle-off"></i></button> ';
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
        $('#edit_first_name').val($(this).data('first_name'));
        $('#edit_middle_name').val($(this).data('middle_name'));
        $('#edit_last_name').val($(this).data('last_name'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_contact').val($(this).data('contact'));
        $('#edit_birthdate').val($(this).data('birthdate'));
        $('#edit_address').val($(this).data('address'));
        $("input[name='gender'][value=" + $(this).data('gender') + "]").prop('checked', true);
        $('#edit_occupation').val($(this).data('occupation'));


    });
    $('#edit_form').crud_delete();


    // Add offering modal
    $('table tbody').on('click', '.add-offering-btn', function() {

        $('#hidden_member_id').val($(this).data('id'));

    });modal_set_ff

    // Set Firstfruit
    $('table tbody').on('click', '.set-ff', function() {

        $('#hidden_commitment_id').val($(this).data('commitment_id'));
        $('#hidden_ff_member_id').val($(this).data('id'));
        $('#ff_amount').val($(this).data('ff_amount'));
        
    });
    $('#edit_ff_form').crud_delete();

    //Compute total
    $( "add_offering_form input[type=number]" ).keyup(function() {
        var input = $(this);
        $("#total_offering").text(input)
      });

});


$('#save_btn').on('click', function(e) {
    e.preventDefault();

    Parsley._remoteCache = {};
    Parsley.addAsyncValidator("check_unique_member_name", function(xhr) {
        return xhr.responseText === 'false' ? false : true;
    }, "/check_unique_member_name", {
        "data": {
            "first_name": $('#create_first_name').val(),
            "last_name": $('#create_last_name').val()
        }
    });

    $(this).crud_click();
});


$('#save_offering').on('click', function(e) {
    e.preventDefault();
    $(this).crud_click();
});

$('#update_btn').on('click', function(e) {
    e.preventDefault();

    Parsley._remoteCache = {};
    Parsley.addAsyncValidator("check_unique_member_name_edit", function(xhr) {
        return xhr.responseText === 'false' ? false : true;
    }, "/check_unique_member_name_edit", {
        "data": {
            "id": $("#hidden_id_edit").val(),
            "first_name": $("#edit_first_name").val(),
            "last_name": $("#edit_last_name").val()
        }
    });

    $(this).crud_click();


   
});


$('.offering-amount').keyup(function () {
    var sum = 0;
    $('.offering-amount').each(function() {
        sum += Number($(this).val());
    });
   $('#total_offering').html("&#8369; "+parseFloat(sum, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
});