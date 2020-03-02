//setting to rated index to -1 cos the system's index starts from 0
var ratedIndex = -1, uID = 0, product_num = 0, cust_name = "", cust_email = "", cust_review = "";

$(document).ready(function () {
    //setting the avr star to black
    $('.star-avr').css('color', 'black');
    $('.cust_pro_rate:eq('+1+')').css('color', 'red');

    $('.user-rate').css('color', 'black');

    //getting the average of star rating and setting the color of stars to the supposed value
    let avrRating = $('.avg_rate').val();
    for (var i=0; i<avrRating; i++) {
        $('.star-avr:eq('+i+')').css('color', '#FFB656');
    }

    //individual customer rating
    let cust_rating = [];
    for (var i=0; i<=2; i++) {
        cust_rating.push($('.cust_pro_rate:eq('+i+')').val());
    }
    
alert(cust_rating);
    for (var i=0; i<cust_rating.length; i++) {

        for (var j=0; j<cust_rating[i]; j++) {
            $('.review-rating:eq('+i+') .user-rate:eq('+j+')').css('color', '#FFB656');
        }
        
    }

    
    
    $('.cust_name').attr("value", localStorage.getItem('name'));
    $('.cust_email').attr("value", localStorage.getItem('email'));

    //reset star colors to black on load
    resetStarColors()

    if (localStorage.getItem('ratedIndex') != null && localStorage.getItem('product_num') == parseInt($('.pc_data').data('dataid'))){
        setStars(parseInt(localStorage.getItem('ratedIndex')));
        uID = localStorage.getItem('uID');
    }
        

    $('.star-rate').on('click', function () {
        ratedIndex = parseInt($(this).data('index'));

        //product id
        product_num = parseInt($('.pc_data').data('dataid'));

        //alert(ratedIndex);

        localStorage.setItem('ratedIndex', ratedIndex);
        localStorage.setItem('product_num', product_num);

        
    });

    $('.post_rate').on('click', function (e) {
        e.preventDefault();
        
        cust_name = $('.cust_name').val();
        cust_email = $('.cust_email').val();
        cust_review = $('.cust_review').val();

        localStorage.setItem('name', cust_name);
        localStorage.setItem('email', cust_email);
        //alert(cust_review);
        

        if(cust_name == "" || cust_email == "" || cust_review == ""){
            alert("All fields must be filled");
        }else{
           
            saveToTheDB();
            location.reload();

            $('.cust_name').attr("value", "Dika");
            cust_email = localStorage.getItem('cust_email');
            
        }
        
    });

    $('.star-rate').mouseover(function () {
        resetStarColors();
        var currentIndex = parseInt($(this).data('index'));
        setStars(currentIndex);
    });

    $('.star-rate').mouseleave(function () {
        resetStarColors()

        //keeps the color of the number of stars clicks on leave
        if(ratedIndex != -1)
            setStars(ratedIndex);
    });


    function saveToTheDB () {
      
        $.ajax({
            url : "ajax/ratings_process.php",
            method: "POST",
            dataType: 'json',
            data: { 'save': 1, 'ratedIndex' : ratedIndex, 'product_num' : product_num, 'uID' : uID, 'cust_name' : cust_name, 'cust_email' : cust_email, 'cust_review' : cust_review },
            success: function (response) {
                uID = response.id;
                localStorage.setItem('uID', uID);
              
            }
        });

        

    }

    function setStars (max){
        for (var i=0; i<=max; i++)
                $('.star-rate:eq('+i+')').css('color', '#FFB656');
    }

    //function to reset star colors to black on load
    function resetStarColors() {
        $('.star-rate').css('color', 'black');
    }
});