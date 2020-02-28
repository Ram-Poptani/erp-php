var TableDataTables = function(){
    var handleCustomerTable = function(){
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var search = window.location.search.substr(1, window.location.search.length);
        arr = search.split('=');
        id = arr[1];


        $.ajax({
            url: baseURL + filePath,
            method : "POST",
            data: {
                "fetch" : "edit_customer",
                "customer_id" : id
            },
            success : function(data){
                data = JSON.parse(data)[0];
                // console.log(Object.keys(data));
                Object.keys(data).forEach(field => {
                    $('#'+field).val(data[field]);                    
                });                
            }
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