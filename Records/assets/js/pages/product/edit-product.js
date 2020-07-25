$(function(){
    $("#edit-product").validate({
        'rules': {
            'name': {
                required: true,
                minlength: 2,
                maxlength: 25
            },
            'specification': {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'hsn_code': {
                required: true,
                minlength: 8,
                maxlength: 8
            },
            'selling_rate':{
                required: true
            },
            'supplier_id[]':{
                required: true
            },
            'category_id': {
                required: true,
            },
            'eoq_level': {
                required: true
            },
            'danger_level' : {
                required : true
            },
            'quantity' : {
                required : true
            }

        },
        submitHandler: function(form){
            form.submit();
        }
    })
});