var TableDataTables = function(){
    var handleSupplierTable = function(){
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var search = window.location.search.substr(1, window.location.search.length);
        arr = search.split('=');
        id = arr[1];


        $.ajax({
            url: baseURL + filePath,
            method : "POST",
            data: {
                "fetch" : "edit_supplier",
                "supplier_id" : id
            },
            success : function(data){
                // console.log( data );
                
                // console.log( JSON.parse(data)[0] );
                
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
            handleSupplierTable();
        }
    }
}();


jQuery(document).ready(function(){
    TableDataTables.init();
})