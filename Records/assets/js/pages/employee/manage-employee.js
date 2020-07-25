var TableDataTables = function(){
    var handleEmployeeTable = function(){
        var manageEmployeeTable = $("#manage-employee-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageEmployeeTable.dataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url : baseURL + filePath,
                method : "POST",
                data : {
                    "page" : "manage_employee"
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

        manageEmployeeTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
        });
    }

    return {
        init : function(){
            handleEmployeeTable();
        }
    }
}();

jQuery(document).ready(function(){
    TableDataTables.init();
})