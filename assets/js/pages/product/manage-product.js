var TableDataTables = function(){
    var handleProductTable = function(){

        // $("#accordionSidebar").addClass('toggled');
        


        var manageProductTable = $("#manage-product-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageProductTable.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_product"
                }
            },
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "order": [
                [4, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [-1, 1, 2]
            }],
        });

        // manageProductTable.on('click', '.edit', function(){
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

        manageProductTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "supplier_id": id,
                    "fetch": "supplier"
                },
                dataType: "json"
            });
        });

        manageProductTable.on('click', '.view', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/supplier-data.php?supplier_id=" + id;
        });

        manageProductTable.on('click', '.edit', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/edit-supplier.php?supplier_id=" + id;
            // alert(baseURL + "/views/pages/edit-customer.php?customer_id=" + id);
        });
    }

    return{
        init: function(){
            handleProductTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})