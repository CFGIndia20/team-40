var id = 2;
var baseURL = window.location.origin;
var filePath = "/helper/routing.php";

function deleteProduct(delete_id){
    var elements = document.getElementsByClassName("product_row");
    if(elements.length != 1){
        $("#element_"+delete_id).remove();
        calculateTotalAmount();
    }
}

function addProduct(){
    $("#product_container").append(
        `<!-- BEGIN: PRDOUCT CUSTOM CONTROL -->
        <div class="row product_row" id="element_${id}">
            <!-- BEGIN: CATEGORY SELECT -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Category</label>
                    <select name="" id="category_${id}" class="form-control category_select">
                        <option disabled selected>Select Category</option>
                        <?php
                        $categories = $di->get("database")->readData("category", ["id", "name"], "deleted=0");
                        foreach ($categories as $category) {
                            echo "<option value='{$category->id}'>{$category->name}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- END: CATEGORY SELECT -->

            <!-- BEGIN: PRODUCTS SELECT -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Products</label>
                    <select name="product_id[]" id="product_${id}" class="form-control product_select">
                        <option disabled selected>Select Product</option>
                    </select>
                </div>
            </div>
            <!-- END: PRODUCTS SELECT -->

            <!-- BEGIN: SELLING PRICE -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Selling Price</label>
                    <input type="number" id="selling_price_${id}" value="0" class="form-control" disabled>
                </div>
            </div>
            <!-- END: SELLING PRICE -->

            <!-- BEGIN: QUANTITY -->
            <div class="col-md-1">
                <div class="form-group">
                    <label for="">Quantity</label>
                    <input type="number" min="1" name="quantity[]" id="quantity_${id}" class="form-control quantity_input" value="0">
                </div>
            </div>
            <!-- END: QUANTITY -->

            <!-- BEGIN: DISCOUNT -->
            <div class="col-md-1">
                <div class="form-group">
                    <label for="">Discount</label>
                    <input type="number" min="1" name="discount[]" id="discount_${id}" class="form-control discount_input" value="0">
                </div>
            </div>
            <!-- END: DISCOUNT -->

            <!-- BEGIN: FINAL RATE -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Final Rate</label>
                    <input type="text" id="final_price_${id}" class="form-control final_price_input" disabled value="0">
                </div>
            </div>
            <!-- END: FINAL RATE -->

            <!-- BEGIN: DELETE BUTTON -->
            <div class="col-md-1">
                <button onclick="deleteProduct(${id})" type="button" class="btn btn-danger" style="margin-top:40%"><i class="far fa-trash-alt"></i></button>
            </div>
            <!-- END: DISCOUNT -->
        </div>
        <!-- END: PRODUCT CUSTOM CONTROL -->`
      );

    
    $.ajax({
        url: baseURL+filePath,
        method: "POST",
        data:{
            getCategories: true
        },
        dataType: 'json',
        success: function(categories){
            categories.forEach(function(category){
                $("#category_" + id).append(
                    `<option value='${category.id}'>${category.name}</option>`
                );
            });
            id++;
        }
    });
}

$("#product_container").on('change', '.category_select', function(){
    var element_id = $(this).attr('id').split("_")[1];
    var category_id = this.value;
    $.ajax({
        url: baseURL+filePath,
        method: "POST",
        data:{
            getProductsByCategoryID: true,
            categoryID: category_id
        },
        dataType: 'json',
        success: function(products){
            $("#product_"+element_id).empty();
            $("#selling_price_"+element_id).attr("value", 0);
            $("#quantity_"+element_id).val(0);
            $("#discount_"+element_id).val(0);
            $("#final_price_"+element_id).attr("value", 0);
            calculateTotalAmount();
            $("#product_"+element_id).append("<option disabled selected>Select Product</option>");
            products.forEach(function(product){
                $("#product_" + element_id).append(
                    `<option value='${product.id}'>${product.name}</option>`
                );
            });
        }
    });
});

$("#product_container").on('change', '.product_select', function(){
    var element_id = $(this).attr('id').split("_")[1];
    var product_id = this.value;
    $.ajax({
        url: baseURL+filePath,
        method: "POST",
        data:{
            getSellingPriceByProductID: true,
            productID: product_id
        },
        dataType: 'json',
        success: function(selling_price){
            $("#selling_price_"+element_id).attr("value", selling_price);
        }
    });
});

$("#product_container").on('change', '.quantity_input,.discount_input', function(){
    var element_id = $(this).attr('id').split("_")[1];

    if($(this).val() == "" || parseInt($(this).val()) <= 0){
        $(this).addClass("text-field-error");
        return;
    }
    $(this).removeClass("text-field-error");
    
    calculatefinalPrice(element_id);
    calculateTotalAmount();

});

function calculatefinalPrice(element_id){
    selling_price = parseInt($("#selling_price_"+element_id).val());
    quantity = parseInt($("#quantity_"+element_id).val());
    discountPerc = parseInt($("#discount_"+element_id).val());

    price = selling_price * quantity;
    if(discountPerc > 0){
        discount = price * (discountPerc/100);
        price = price-discount;
    }
    
    $("#final_price_"+element_id).attr("value", price);
    console.log("")
}

function calculateTotalAmount(){
    console.log($(".final_price_input"));
    totalFinalPrice = 0;
    for(i = 0; i < $(".final_price_input").length; i++){
        totalFinalPrice += parseInt($(".final_price_input")[i].value);
    }

    $("#finalTotal").attr("value", totalFinalPrice);
}

    $("#check_email").click(function(){
        var email = $("#customer_email").val();
        // console.log(email);
    
    $.ajax({
        url: baseURL+filePath,
        method: "POST",
        data:{
            getCustomerWithEmail: true,
            emailID : email,
        },
        dataType: 'json',
        success: function(customer_id){
            
            if(customer_id!=null)
            {
            if(customer_id[0].id!=null){
                
                
                $("#email_verify_success").addClass('d-inline-block');
                $("#email_verify_success").removeClass('d-none');

                $("#customer_id").val(customer_id[0].id);
            }
        }
            else{
                $("#email_verify_success").addClass('d-none');
                $("#email_verify_success").removeClass('d-inline-block');


                $("#email_verify_fail").removeClass('d-none');
                $("#email_verify_fail").addClass('d-inline-block');

                $("#add_customer_btn").removeClass('d-none');
                $("#add_customer_btn").addClass('d-inline-block');

                $("#customer_id").val("");
            }

            
        }
    });

    
    
});
