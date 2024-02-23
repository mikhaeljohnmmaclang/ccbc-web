$(document).ready(function () {
    var table = $("#ministries_table").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        "lengthMenu": [ 25, 50, 75, 100 ],
        ajax: {
            url: "/get_ministries",
            error: function (xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error("An error occured, please try again later");
                }
            },
        },
        columns: [
            {
                data: null,
                sortable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: "name",
                name: "name",
                searchable: true,
            },

            {
                data: null,
                orderable: false,
                searchable: false,
                class: "text-left ministries-action",
                render: function (data, type, row) {
                    return (
                        "&#8369; " +
                        parseFloat(data.funds, 10)
                            .toFixed(2)
                            .replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
                            .toString()
                    );
                },
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                class: "text-right ministries-action",
                render: function (data, type, row) {
                    if (data.status == 1) {
                        return (
                            '<button type="button" data-table="ministries" data-id=' +
                            data.id +
                            " data-contact=" +
                            data.contact_number +
                            ' data-name="' +
                            data.name +
                            '" data-email="' +
                            data.email +
                            '" data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit Members" data-original-title="Edit Handler" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                            '<button type="button" data-table="ministries" data-id="' +
                            data.id +
                            '"  data-name="' +
                            data.name +
                            '"data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> '
                        );
                    } else {
                        return (
                            '<button type="button" data-table="ministries" data-id="' +
                            data.id +
                            '" data-name="' +
                            data.name +
                            '" data-bs-toggle="modal" data-bs-target="#activate"  data-placement="top" title="Activate" data-original-title="Activate" class="activate btn btn-sm btn-secondary"><i class="fa fa-toggle-off"></i></button> '
                        );
                    }
                },
            },
        ],
        drawCallback: function (settings, json) {
            $(".tooltips").tooltip();
        },
    });

    $("#save_btn").on("click", function (e) {
        e.preventDefault();
        $(this).crud_click();
    });

    $("#update_btn").on("click", function (e) {
        e.preventDefault();
        $(this).crud_click();
    });

    // Edit - with universal route
    $("table tbody").on("click", ".edit", function () {
        // hidden inputs
        $("#hidden_edit_in_table").val($(this).data("table"));
        $("#hidden_id_edit").val($(this).data("id"));
        // header
        $("#edit_name_header").text("Edit - " + $(this).data("name"));
        // inputs
        $("#edit_name").val($(this).data("name"));
    });
    $("#edit_form").crud_delete();
});
