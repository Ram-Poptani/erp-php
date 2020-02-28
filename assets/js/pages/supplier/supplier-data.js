var TableDataTables = function(){
    var handleSupplierTable = function(){
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var search = window.location.search.substr(1, window.location.search.length);
        arr = search.split('=');
        id = arr[1];

        $.ajax({
            url: baseURL + filePath,
            method : "GET",
            data: {
                "supplier_id": id,
                "fetch": "supplier_data"
            },
            success : function(data){
                console.log(JSON.parse(data));
            }
        });
    }

    return{
        init: function(){
            handleSupplierTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})