$(document).ready(function () {
    var table = $("#transactions_table").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        buttons: ['excel', 'pdf', 'copy', 'print'],
        dom: 'Bfrtip',
        order: [[0, "desc"]],
        lengthMenu: [50, 100, 250, 500],
        ajax: {
            url: "/get_transactions",
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
                data: "id",
                name: "id",
                searchable: true,
            },
            {
                data: "member_name",
                name: "member_name",
                searchable: true,
            },
            {
                data: "service_name",
                name: "service_name",
                searchable: true,
            },
            {
                data: "formatted_transaction_date",
                name: "formatted_transaction_date",
                searchable: true,
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                class: "text-right transactions-action",
                render: function (data, type, row) {
                    if (data.status == 1) {
                        return (
                            //Edit Transactions
                            '<button type="button" data-table="transactions" ' +
                            "data-id=" +
                            data.id +
                            " data-service=" +
                            data.service_id +
                            ' data-remarks="' +
                            data.remarks +
                            ' data-offerings="' +
                            data.offerings +
                            '"  data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit transactions" data-original-title="Edit Transaction" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                            //Export PDF
                            '<a type="button" target="blank" href="/export_transaction/' +
                            data.id +
                            '" data-placement="top" title="Export Transaction" data-original-title="Edit Transaction" class="edit btn btn-sm btn-secondary"><i class="fa fa-download"></i></a> ' +
                            //Delete
                            '<button type="button" data-table="transactions" data-id="' +
                            data.id +
                            '"  data-name="' +
                            data.name +
                            '"data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> '
                        );
                    }
                },
            },
        ],
        drawCallback: function (settings, json) {
            $(".tooltips").tooltip();
        },
    });

    // Edit - with universal route
    $("table tbody").on("click", ".edit", function () {
        // hidden inputs
        $("#hidden_edit_in_table").val($(this).data("table"));
        $("#hidden_id_edit").val($(this).data("id"));

        // inputs
        $("#hidden_transaction_id").val($(this).data("id"));
        $("#edit_transaction_service").val($(this).data("service")).change();
        $("#edit_total").html("&#8369; 0.00");

        var total = 0;
        //offering amounts
        $.ajax({
            type: "GET",
            url: "/get_transaction_offerings/" + $(this).data("id"),
            dataType: "json",
            success: function (data) {
                //visible offering data
                jQuery.each(data.offerings, function (index, item) {
                    $("#ministry_" + data.offerings[index].id).val(
                        data.offerings[index].amount
                    );
                    total = total + data.offerings[index].amount;
                });

                //invisible ref offering data
                jQuery.each(data.offerings, function (index, item) {
                    $("#ref_ministry_" + data.offerings[index].id).val(
                        data.offerings[index].amount
                    );
                    //total = total + data.offerings[index].amount;
                });

                //set date
                $("#edit_date").val(data.date);

                //set remarks
                $("#edit_remarks").val(data.remarks);

                //set total offering
                $("#edit_total").html(
                    "&#8369; " +
                        parseFloat(total, 10)
                            .toFixed(2)
                            .replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
                            .toString()
                );
            },
            error: function (data) {
                alert(data);
            },
        });
    });
    $("#edit_form").crud_delete();
    $("#generate_reports_form").crud_delete();

    if ($("#has_msg").val()) {
        toastr.error("Failed.", $("#has_msg").val());
    }
});

$("#generate_btn").on("click", function (e) {
    e.preventDefault();
    var date = $("#date_range_report").val();
    var service = $("#service_filter").val();
    var sort;
    $("#sort_yes").is(":checked") ? (sort = "yes") : (sort = "no");

    window.location.href =
        "/generate_summary_reports/" +
        date.replaceAll("/", "-") +
        "/" +
        service +
        "/" +
        sort;
});

$("#update_btn").on("click", function (e) {
    e.preventDefault();
    $(this).crud_click();
});

$(".offering-amount").blur(function () {
    var sum = 0;
    $(".offering-amount").each(function () {
        sum += Number($(this).val());
    });
    $("#edit_total").html(
        "&#8369; " +
            parseFloat(sum, 10)
                .toFixed(2)
                .replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
                .toString()
    );
});

// daterange generate transaction report
$('input[name="daterange"]').daterangepicker(
    {
        opens: "left",
    },
    function (start, end, label) {
        console.log(
            "A new date selection was made: " +
                start.format("YYYY-MM-DD") +
                " to " +
                end.format("YYYY-MM-DD")
        );
    }
);
