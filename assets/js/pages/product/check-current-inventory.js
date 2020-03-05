var InventoryCharts = function(){
    var handleCharts = function(){

        // $("#accordionSidebar").addClass('toggled');
        


        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";

        

        $.ajax({
            url : baseURL + filePath,
            method : "POST",
            data : {
                "page": "check_current_inventory",
                "for": "chart"
            },
            success: function (data_for_chart) {
                data_for_chart = JSON.parse( data_for_chart );
                // console.log( data_for_chart );
                let quantities = [];
                let names = [];
                data_for_chart.forEach(pie => {
                    quantities.push(pie['quantity']);
                    names.push(pie['name'])
                });


                // console.log( names );
                // console.log( quantities );
                // console.log(window);
                

                var ctx = $('#quantity-chart');
                var quantity_chart = new Chart(ctx,
                {
                    type: 'pie',
                    data: {
                        labels: names,
                        datasets: [{
                            data: quantities,
                            backgroundColor: [
                                '#FFA400', 
                                '#03F7EB', 
                                '#3185FC',
                                '#248232',
                                '#D4C5E2'],
                            hoverBackgroundColor: [
                                '#BC7A00', 
                                '#01B7AE', 
                                '#225FB5',
                                '#1B6326',
                                '#A094AA'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }]
                    },
                    options: {
                        // responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 20,
                            yPadding: 20,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        scales: {
                            left : 2
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels:{
                                boxWidth : 12,
                                fontColor : '#AAA',
                                padding : 15
                            }
                        },
                    },
                });
            }
        });
    }
    var handleDatatable = function () {
        
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";

        var oTable = $("#low-quantity-products-datatable").dataTable({
            buttons: [
                {
                    extend: 'pdf',
                    text: 'Save current page',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "check_current_inventory",
                    "for": "datatable"
                }
            },
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "order": [
                [1, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [0, 1]
            }],
        });
    }

    return{
        init: function(){
            handleCharts();
            handleDatatable();
        }
    }
}();


jQuery(document).ready(function(){
    // window.devicePixelRatio	= 2;
    // $("#quantity-chart").width( $("#quantity-chart").width() * 2 );
    // $("#quantity-chart").height( $("#quantity-chart").height() * 2 );
    
    InventoryCharts.init();
    // window.devicePixelRatio	= 2;
    // $("#quantity-chart").width( $("#quantity-chart").width() * 2 );
    // $("#quantity-chart").height( $("#quantity-chart").height() * 2 );

})