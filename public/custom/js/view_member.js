$(document).ready(function() {
    let member_id = $("#member_id").val();

 $('#offering_summary').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        order: [
            [0, 'desc']
        ],
        "lengthMenu": [ 25, 50, 75, 100 ],
        ajax: {
            url: "/get_member_offering_summary/"+member_id,
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
                data: 'ministry_name',
                name: 'ministry_name',
                searchable: true
            },  {
                data: null,
                orderable: false,
                searchable: false,
                class: 'text-left',
                render: function(data, type, row) {
                    return "&#8369; "+parseFloat(data.total_amount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                }
            },
        ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });



});

