var TableDataTables = function(){
    
    var handleEmployeeTable = function(){

        // $("#accordionSidebar").addClass('toggled');

        var manageEmployeeTable = $("#manage-employee-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageEmployeeTable.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_employee"
                }
            },
            "lengthMenu": [
                [3, 5, 7, 10, 12, 20, -1],
                [3, 5, 7, 10, 12, 20, "All"]
            ],
            "order": [
                [0, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [-2, -1]
            }],
        });

        // manageEmployeeTable.on('click', '.edit', function(){
        //     id = $(this).attr('id');
        //     $("#employee_id").val(id);
        //     $.ajax({
        //         url: baseURL + filePath,
        //         method: "POST",
        //         data: {
        //             "employee_id": id,
        //             "fetch": "employee"
        //         },
        //         dataType: "json",
        //         success: function(data){
        //             $("#employee_name").val(data[0].name);
        //             console.log(data);
        //              $.ajax({
        //                 url : baseURL + "/views/pages/edit-employee.php",
        //                 method : "POST",
        //                 data : {
        //                     "employee_data" : data
        //                 },
        //                 success: function (data) {
        //                     console.log(data);
        //                 }
        //             });
        //             window.location = baseURL + "/views/pages/edit-employee.php";
        //         }
        //     });
        // });

        manageEmployeeTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "employee_id": id,
                    "fetch": "employee"
                },
                dataType: "json"
            });
        });

        manageEmployeeTable.on('click', '.view', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/employee-data.php?employee_id=" + id;
        });

        manageEmployeeTable.on('click', '.edit', function(){
            id = $(this).attr('id');
            window.location = baseURL + "/views/pages/edit-employee.php?employee_id=" + id;
            // alert(baseURL + "/views/pages/edit-employee.php?employee_id=" + id);
        });
    }

    return{
        init: function(){
            handleEmployeeTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})