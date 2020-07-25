var TableDataTables = function(){
    var handleCustomerTable = function(){
        var manageSupplierTable = $("#manage-supplier-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageSupplierTable.dataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url : baseURL + filePath,
                method : "POST",
                data : {
                    "page" : "manage_supplier"
                }
            },
            "lengthMenu" : [
                [5, 10, 15, 30, -1],
                [5, 10, 15, 30, "All"]
            ],
            "order" : [
                [1, "ASC"]
            ],
            "columnDefs":[{
                'orderable' : false,
                'targets' : [0, -1, -2]
            }]
        });

        manageSupplierTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
        });
    }

    return {
        init : function(){
            handleCustomerTable();
        }
    }
}();

jQuery(document).ready(function(){
    TableDataTables.init();
})