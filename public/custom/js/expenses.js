$(document).ready(function () {
    var table = $('#expenses_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "/get_expenses",
            error: function (xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
            data: "voucher_number",
            name: "voucher_number",
            searchable: true
        }, {
            data: 'ministry_name',
            name: 'ministry_name',
            searchable: true
        }, {
            data: 'name',
            name: 'name',
            searchable: true
        },
        {
            data: 'descriptions',
            name: 'descriptions',
            searchable: true
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            class: 'text-left ministries-action',
            render: function(data, type, row) {
                return "&#8369; "+parseFloat(data.amount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
            }
        },
        {
            data: "expense_date",
            name: "expense_date",
            searchable: true
        },
        {
            data: "recorded_by",
            name: "recorded_by",
            searchable: true
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            class: 'text-right expenses-action',
            render: function (data, type, row) {
                if (data.status == 1) {
                    return '<button type="button" data-table="expenses" data-id="' + data.id + '" data-voucher_number="' + data.voucher_number + '" data-name="' + data.name + '" data-amount="' + data.amount + '" data-expense_date="' + data.expense_date + '"  data-expense_date_raw="' + data.date + '" data-descriptions="' + data.descriptions + '" data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit Members" data-original-title="Edit Expense" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                        '<button type="button" data-table="expenses" data-id="' + data.id + '"  data-name="' + data.name + '"data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> ';
                } else {
                    return '<button type="button" data-table="expenses" data-id="' + data.id + '" data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#activate"  data-placement="top" title="Activate" data-original-title="Activate" class="activate btn btn-sm btn-secondary"><i class="fa fa-toggle-off"></i></button> ';
                }
            }
        }
        ],
        drawCallback: function (settings, json) {
            $('.tooltips').tooltip();
        },

    });

    $('#save_btn').on('click', function (e) {
        e.preventDefault();

        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_member_email", function (xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_member_email");

        $(this).crud_click();
    });

    $('#update_btn').on('click', function (e) {
        e.preventDefault();

        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_member_email_edit", function (xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_member_email_edit", {
            "data": {
                "id": $("#hidden_id_edit").val()
            }
        });

        $(this).crud_click();
    });


// Edit - with universal route
$('table tbody').on('click', '.edit', function () {
    // hidden inputs
    $('#hidden_edit_in_table').val($(this).data('table'));
    $('#hidden_id_edit').val($(this).data('id'));
    // header
    $('#edit_name_header').text("Edit - " + $(this).data('name'));
    // inputs
    $('#edit_name').val($(this).data('name'));
    $('#edit_voucher_number').val($(this).data('voucher_number'));
    $('#edit_date').val($(this).data('expense_date_raw'));
    $('#edit_amount').val($(this).data('amount'));
    $('#edit_descriptions').val($(this).data('descriptions'));

});
$('#edit_form').crud_delete();

});

