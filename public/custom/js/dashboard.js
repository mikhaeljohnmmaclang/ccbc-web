$(document).ready(function () {
    // Offerings
    $.ajax({
        type: "get",
        url: "/get_monthly_offerings_report",
        success: function (data) {
            let total_offerings = [];
            let months = [];

            jQuery.each(data[0], function (index, item) {
                total_offerings.push(item);
                months.push(index);
            });

            var options = {
                series: [
                    {
                        name: "Total Amount",
                        data: total_offerings,
                    },
                ],
                colors: ["#002D64", "#006CBC", "#0F9EE8", "#30B7EE", "#6AD2F5"],
                chart: {
                    height: 350,
                    type: "line",
                    zoom: {
                        enabled: false,
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 5,
                    curve: "smooth",
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                      shade: 'dark',
                      gradientToColors: [ '#5FB8E8'],
                      shadeIntensity: 1,
                      type: 'horizontal',
                      opacityFrom: 1,
                      opacityTo: 1,
                      stops: [0, 100, 100, 70]
                    },
                  },
                grid: {
                    row: {
                        colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                        opacity: 0.5,
                    },
                },
                xaxis: {
                    categories: months,
                },
                yaxis: {
                    labels: {
                        formatter: (item) => {
                            return '₱' + item.toLocaleString('en-PH');
                        },
                    },
                },
            };

            var chart = new ApexCharts(
                document.querySelector("#data_offerings"),
                options
            );
            chart.render();
        },
        error: function (data) {
            console.log(data);
        },
    });

    //Expenses
    $.ajax({
        type: "get",
        url: "/get_expenses_report",
        success: function (data) {
            let date = [];
            let amount = [];

            jQuery.each(data, function (index, item) {
                date.push(item.date);
                amount.push(item.amount);
            });

            var options = {
                series: [
                    {
                        data: amount,
                    },
                ],
                chart: {
                    type: "bar",
                    height: 350,
                    width: 500,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "55%",
                        endingShape: "rounded",
                    },
                },
                colors: ["#002D64", "#006CBC", "#0F9EE8", "#30B7EE", "#6AD2F5"],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                xaxis: {
                    categories: date,
                },
                yaxis: {
                    labels: {
                        formatter: (item) => {
                            return '₱' + item.toLocaleString('en-PH');
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
                responsive: [
                    {
                        breakpoint: 1366,
                        options: {
                            chart: {
                                width: 330,
                            },
                        },
                    },
                    {
                        breakpoint: 1280,
                        options: {
                            chart: {
                                width: 300,
                            },
                        },
                    },

                    {
                        breakpoint: 768,
                        options: {
                            chart: {
                                width: 500,
                            },
                        },
                    },
                    {
                        breakpoint: 520,
                        options: {
                            chart: {
                                width: 400,
                            },
                        },
                    },
                ],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '₱' + val.toLocaleString('en-PH');
                        },
                    },
                },
            };

            var chart = new ApexCharts(
                document.querySelector("#data_expenses"),
                options
            );
            chart.render();
        },
        error: function (data) {
            console.log(data);
        },
    });

    //Minitries
    $.ajax({
        type: "get",
        url: "/get_ministries_report",
        success: function (data) {
            let funds = [];
            let ministries = [];
            jQuery.each(data, function (index, item) {
                funds.push(item.funds);
                ministries.push(item.name);
            });

            var options = {
                series: funds,
                chart: {
                    width: 420,
                    type: "donut",
                },
                labels: ministries,
                colors: ["#2B7FC0", "#36A3E8", "#5FB8E8", "#A1CDE5", "#DCDCDC","#DAA28E", "#D66A52", "#DB4A31", "#BD3525"],
                tooltip: {
                    y: {
                      formatter: function (value) {
                        return '₱' + value.toLocaleString('en-PH');
                      }
                    }
                  },
                responsive: [
                    {
                        breakpoint: 520,
                        options: {
                            chart: {
                                width: 500,
                            },
                            legend: {
                                position: "bottom",
                            },
                        },
                    },
                ],
            };

            var chart = new ApexCharts(
                document.querySelector("#data_ministries"),
                options
            );
            chart.render();
        },
        error: function (data) {
            console.log(data);
        },
    });

    //Minitries
    $.ajax({
        type: "get",
        url: "/get_activity_logs",
        success: function (data) {
            let result = JSON.parse(data);
           
            if (result.length > 0) {
                $.each(result, function (index, value) {
                    $("#activity_logs_list").append('<div class="d-flex flex-column shadow p-3 mb-2 bg-white rounded w-100">'+
                        '<div class="d-flex justify-content-between align-items-center">' +
                              '<label class="fw-bold text-bold text-primary border-bottom border-primary">'+ result[index].admin_name +'</label>' +
                              '<label class="text-secondary font-monospace">'+ result[index].date +'</label>'+
                       '</div>'+
                        '<div class="d-flex flex-column justify-content-center align-items-start border-red w-100 pt-2">'+
                        result[index].description +
                        '</div>'+
                      '</div>'
                    );
                });
            } else {
                $("#activity_logs_list").append(
                    "<h4 class='align-self-center'>No activity logs found</h4>"
                );
            }
        },
        error: function (data) {
            alert(data);
        },
    });
});
