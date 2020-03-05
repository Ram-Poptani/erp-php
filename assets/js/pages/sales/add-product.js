var getCategory = function() {
    
    var baseURL = window.location.origin;
    var filePath = "/helper/routing.php";

    $.ajax({
        url: baseURL + filePath,
        method: "POST",
        data: {
            "fetch": "categories_for_product"
        },
        success : function(data){
            // console.log( JSON.parse( data ) );
            addCategoriesOptions(data);
        },
        // dataType: "json"
    });
    function addCategoriesOptions( categories ) {
        JSON.parse( categories ).forEach(option => {
            name = option['name'] + " ";
            name = name.substr(0, name.length-1);
            $("#category").append(`<option value="${name}"> ${name} </option>`);
        });
    }
}

jQuery(document).ready(function(){
    getCategory();
})