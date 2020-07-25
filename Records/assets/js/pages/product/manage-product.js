
var TableDataTables = function(){
    var handleProductTable = function(){
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
                [1, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [0, -1]
            }],
        });

        manageProductTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
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