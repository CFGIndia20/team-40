var TableDataTables = function(){
    var handleCategoryTable = function(){
        var manageCategoryTable = $("#manage-category-datatable");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        var oTable = manageCategoryTable.dataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url : baseURL + filePath,
                method : "POST",
                data : {
                    "page": "manage_category"
                }
            },
            "lengthMenu" : [
                [5, 10, 20, -1],
                [5, 10, 20, 'All']
            ],
            "order" : [
                [1, "ASC"]
            ],
            "columnDefs":[{
                'orderable' : false,
                'targets' : [0, -1]
            }],
        });

        manageCategoryTable.on('click', '.edit', function(){
            console.log("Here");
            id = $(this).attr('id');
            $("#category_id").val(id);
            $.ajax({
                url : baseURL + filePath,
                method : "POST",
                data : {
                    "category_id" : id,
                    "fetch" : "category"
                },
                dataType : "json",
                success : function(data){
                    console.log(data[0].name);
                    $("#category_name").val(data[0].name);
                }
            });
        });
        manageCategoryTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url : baseURL + filePath,
                method : "POST",
                data : {
                    "category_id": id,
                    "fetch" : "category"
                },
                dataType : "json",
                success: function(data){
                    $("#category_name").val(data[0].name);
                }
            });
        });
    }
    return {
        init : function(){
            handleCategoryTable();
        }
    }
}();

jQuery(document).ready(function(){
    TableDataTables.init();
})