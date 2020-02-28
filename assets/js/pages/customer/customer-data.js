var TableDataTables = function(){
    var handleCustomerTable = function(){
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var search = window.location.search.substr(1, window.location.search.length);
        arr = search.split('=');
        id = arr[1];

        $.ajax({
            url: baseURL + filePath,
            method : "GET",
            data: {
                "customer_id": id,
                "fetch": "customer_data"
            },
            success : function(data){
                console.log(JSON.parse(data));
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