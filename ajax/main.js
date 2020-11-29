

//step ground
$("#ground").click(function(event) {
 /* Stop form from submitting normally */
    event.preventDefault();

	var coupon = $('#coupon').val();
	var hit = $('#hit').val();

	 $.ajax({
	        url: "include/controller/handler.php",
	        type: "post",
	        dataType: "json",
	        data: $('#ground-form').serialize(),
	        success: function (response) {

	           //$("#result").html(response);
			   //$("#gd-0").hide();

							if(!response.status) {
				                $("#result").html("<div class='alert alert-danger'>" +response.message + "</div>");
				            } else if(response.status) {
				               
								$("#result").html("<div class='alert alert-success'>" +response.message + "</div>");
				                $("#gd-0").hide();
				                $("#stats").hide();
								$("#abort-denied").show(800);

								window.setTimeout(function() {
								    window.location.href = 'index.php';
								}, 2000);
				            }



	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });


});



//step 1
$("#detail-btn").click(function(event) {
 /* Stop form from submitting normally */
    event.preventDefault();

	var fname = $('#fname').val();
	var lname = $('#lname').val();
	var email = $('#email').val();
	var hit = $('#hit').val();

	 $.ajax({
	        url: "include/controller/handler.php",
	        type: "post",
	        dataType: "json",
	        data: $('#form-details').serialize(),
	        success: function (response) {

	           //$("#result").html(response);
			   //$("#gd-0").hide();

							if(!response.status) {
				                $("#result").html("<div class='alert alert-danger'>" +response.message + "</div>");
				            } else if(response.status) {
				                
								
								$("#result").html("<div class='alert alert-success'>" +response.message + "</div>");
				                $("#section-details").hide();
				               

								window.setTimeout(function() {
								    window.location.href = 'index.php';
								}, 2000);
				            }



	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });


});


//step 2
$("#salt-btn").click(function(event) {
 /* Stop form from submitting normally */
    event.preventDefault();

	var salt = $('#salt').val();
	var hit = $('#hit').val();

	 $.ajax({
	        url: "include/controller/handler.php",
	        type: "post",
	        dataType: "json",
	        data: $('#form-verify').serialize(),
	        success: function (response) {

							if(!response.status) {
				                $("#result").html("<div class='alert alert-danger'>" +response.message + "</div>");
				            } else if(response.status) {
				                
								
								$("#result").html("<div class='alert alert-success'>" +response.message + "</div>");
				              
								window.setTimeout(function() {
								    window.location.href = 'index.php';
								}, 2000);
				            }



	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });


});



//step 3
$("#pay-btn").click(function(event) {
 /* Stop form from submitting normally */
    event.preventDefault();

	var paytm = $('#paytm').val();
	var hit = $('#hit').val();

	 $.ajax({
	        url: "include/controller/handler.php",
	        type: "post",
	        dataType: "json",
	        data: $('#form-payment').serialize(),
	        success: function (response) {

							if(!response.status) {
				                $("#result").html("<div class='alert alert-danger'>" +response.message + "</div>");
				            } else if(response.status) {
				                
								$("#result").html("<div class='alert alert-success'>" +response.message + "</div>");
				                $("#pay-section").hide();
				                $("#10-min-msg").hide();
				                
								window.setTimeout(function() {
								    window.location.href = 'index.php';
								}, 4000);
				            }



	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });


});