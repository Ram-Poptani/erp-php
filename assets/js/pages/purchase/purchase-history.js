var TableDataTables = function(){
    var handlePurchaseTable = function(){

        // $("#accordionSidebar").addClass('toggled');
        


        var managePurchaseTable = $("#purchase-hitory-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = managePurchaseTable.dataTable({
            "buttons": [
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
                    "page": "purchase_hitory"
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
                'targets': [0, 1]
            }],
        });

        // managePurchaseTable.on('click', '.edit', function(){
        //     id = $(this).attr('id');
        //     $("#customer_id").val(id);
        //     $.ajax({
        //         url: baseURL + filePath,
        //         method: "POST",
        //         data: {
        //             "customer_id": id,
        //             "fetch": "customer"
        //         },
        //         dataType: "json",
        //         success: function(data){
        //             $("#customer_name").val(data[0].name);
        //             console.log(data);
        //              $.ajax({
        //                 url : baseURL + "/views/pages/edit-customer.php",
        //                 method : "POST",
        //                 data : {
        //                     "customer_data" : data
        //                 },
        //                 success: function (data) {
        //                     console.log(data);
        //                 }
        //             });
        //             window.location = baseURL + "/views/pages/edit-customer.php";
        //         }
        //     });
        // });

        managePurchaseTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "purchase_id": id,
                    "fetch": "purchase"
                },
                dataType: "json"
            });
        });

        managePurchaseTable.on('click', '.view', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/purchase-data.php?purchase_id=" + id;
        });

        managePurchaseTable.on('click', '.edit', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/edit-purchase.php?purchase_id=" + id;
            // alert(baseURL + "/views/pages/edit-customer.php?customer_id=" + id);
        });
    }

    return{
        init: function(){
            handlePurchaseTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})