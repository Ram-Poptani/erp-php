var TableDataTables = function(){
    var handleSalesTable = function(){

        $("#accordionSidebar").removeClass('toggled');
        


        var manageSalesReport = $("#sales-datatable");
        // console.log( manageSalesReport );        
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageSalesReport.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "sales_report"
                }
            },
            "lengthMenu": [
                [10, 20, 40, 60, 80, 100, -1],
                [10, 20, 40, 60, 80, 100, "All"]
            ],
            "order": [
                [4, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [0, -1]
            }],
        });
        new $.fn.dataTable.Buttons( oTable, {
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
        // console.log( oTable.buttons() );        
        oTable.buttons().container().appendTo(oTable.table().container());
        // oTable.buttons().container().appendTo( $("#dt-buttons") );
    }

    return{
        init: function(){
            handleSalesTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})