//add to cart script

$(document).ready(function() {


    $('.submit_pro').on('submit', function(e) {
        e.preventDefault();
        let product_num = $(this).find('.pc_data').data('dataid');
        let product_qty = $(this).find('.pro-qty').val();
        //let product_price = $(this).find('.pro-price').val();
         //alert("Product Id is "+product_num+" Product quantity "+product_qty);

        if (product_num == "" || product_qty == "") {

            alert("Data Key Not Found");
            
        } else {

            $.ajax({
                type: "POST",
                url: "ajax/cart_process.php",
                data: { 'product_num' : product_num, 'product_qty' : product_qty },
                success: function (response) {
                    var get_val = JSON.parse(response);
                    console.log(response);

                    if(get_val.status == 100) {
                        console.log(get_val.msg);
                        location.reload();
                    } else if (get_val.status == 103) {
                        console.log(get_val.msg);
                        alert(get_val.msg)
                    } else {
                        console.log(get_val.msg);
                    }
                }
            });

        }
    });

    $(document).on('click', 'button.rm-val', function () {
        //alert('hi');
        let rm_val = $(this).data('dataval');
        
        if(rm_val == '') {
            alert('Data Value not found');
            
        } else {
            
            $.ajax({
                
                type: "POST",
                url: "ajax/cart_process.php",
                data: { 'rm_val' : rm_val },
                success: function (response) {

                    let get_val = JSON.parse(response);

                    if(get_val.status == 102) {
                        console.log(get_val.msg)
                        location.reload();
                    }else {
                        console.log(get_val.msg)
                    }
                
                }
            });
            

        }
    });
});



