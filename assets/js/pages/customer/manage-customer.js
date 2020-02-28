var TableDataTables = function(){
    var handleCustomerTable = function(){

        // $("#accordionSidebar").addClass('toggled');
        


        var manageCustomerTable = $("#manage-customer-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageCustomerTable.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_customer"
                }
            },
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "order": [
                [0, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [-2, -1]
            }],
        });

        // manageCustomerTable.on('click', '.edit', function(){
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

        manageCustomerTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "customer_id": id,
                    "fetch": "customer"
                },
                dataType: "json"
            });
        });

        manageCustomerTable.on('click', '.view', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/customer-data.php?customer_id=" + id;
        });

        manageCustomerTable.on('click', '.edit', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/edit-customer.php?customer_id=" + id;
            // alert(baseURL + "/views/pages/edit-customer.php?customer_id=" + id);
        });
    }

    return{
        init: function(){
            handleCustomerTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})