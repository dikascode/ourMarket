$(document).ready(function() {
    $('.submit_pro').on('submit', function(e) {
        e.preventDefault();
        let product_num = $(this).find('.pc_data').data('dataid');
        // alert("Product Id is "+product_num);

        if (product_num == "") {

            alert("Data Key Not Found");
            
        } else {

            $.ajax({
                type: "POST",
                url: "ajax/cart_process.php",
                data: { 'product_num' : product_num },
                success: function (response) {
                    let get_val = JSON.parse(response);
                    console.log(response);

                    if(get_val.status == 100) {
                        alert(get_val.msg);
                        location.reload();
                    } else if (get_val.status == 103) {
                        alert(get_val.msg);
                    } else {
                        console.log(get_val.msg);
                    }
                }
            });

        }
    });
});