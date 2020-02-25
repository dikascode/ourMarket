//add to cart script

$(document).ready(function() {


    $('.submit_pro').on('submit', function(e) {
        e.preventDefault();
        let product_num = $(this).find('.pc_data').data('dataid');
        let product_qty = $(this).find('.pro-qty').val();
         alert("Product Id is "+product_num+" Product quantity "+product_qty);

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
                    } else {
                        console.log(get_val.msg);
                    }
                }
            });

        }
    });
});

let classname =  document.getElementsByClassName("cartLink");
Array.from(classname).forEach(function(element) {
 element.addEventListener('click', function (e){
     //alert('hi');
     //window.location= "index.php";
 });
});

