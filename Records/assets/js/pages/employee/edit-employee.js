$(function(){
    $("#edit-employee").validate({
        'rules': {
            'first_name': {
                required: true,
                minlength: 2,
                maxlength: 25
            },
            'last_name': {
                required: true,
                minlength: 2,
                maxlength: 25
            },
            'phone_no': {
                required: true,
                minlength: 10,
                maxlength:25
            },
            'email_id': {
                required: true,
                email: true,
                maxlength: 40
            },
            'gender': {
                required: true
            },
            'block_no' : {
                required : true,
                minlength : 2,
                maxlength : 30
            },
            'street' : {
                required : true,
                minlength : 2,
                maxlength : 25
            },
            'city' : {
                required : true,
                minlength : 2,
                maxlength : 25
            },
            'pincode' : {
                required : true,
                minlength : 6,
                maxlength : 6
            },
            'town' : {
                required : true,
                minlength : 2,
                maxlength : 25
            },
            'state' : {
                required : true,
                minlength : 2,
                maxlength : 25
            },
            'country' : {
                required : true,
                minlength : 2,
                maxlength : 25
            }

        },
        submitHandler: function(form){
            form.submit();
        }
    })
});