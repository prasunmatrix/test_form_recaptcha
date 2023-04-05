<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Google Recaptcha</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->      
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<body>
  <div id="message_div" style="display:none">Your enquiry has been sent.</div>
  <form class="contactfrm" id="contactfrm" method="post" id="contactform" autocomplete="off">
    <div class="row">
      <div class="col-md-6">
        <input type="text" name="user_name" value="" placeholder="Name" id="user_name" minlength="2"><br />
        <span id="error_uname" style="color:red;"></span>
      </div>
      <div class="col-md-6">
        <input type="text" name="user_email" value="" placeholder="Email" id="user_email"><br />
        <span id="error_email" style="color:red;"></span>
      </div>
      <div class="col-md-6">
        <input type="text" name="user_contact" value="" placeholder="Contact Number" id="user_contact" title="Enter Valid mobile number ex.9811111111"><br />
        <span id="error_contact" style="color:red;"></span>
      </div>
      <div class="col-md-6">
        <input type="text" name="user_company_name" value="" placeholder="Company" id="user_company_name">
      </div>
      <div class="col-md-12">
        <textarea name="user_message" placeholder="Message" id="user_message"></textarea><br />
        <span id="error_msg" style="color:red;"></span>
      </div>
      <div class="col-md-12">
        <!-- <img src="assets/images/capcha.png" alt=""> -->
        <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LcvxmAeAAAAACUJKhWnNEkcHuROjS9zB2hWBP_F"></div>
        <div class="captcha-error alert alert-danger" style="display:none;"></div>
      </div>
      <div class="col-md-12">
        <input type="submit" name="send" value="Submit">
      </div>
    </div>
    <!-- <table border="1" align="center">
      <tr>
        <td>
          <input type="text" name="user_name" value="" placeholder="Name" id="user_name" minlength="2"><br>
          <span id="error_uname" style="color:red;"></span>
        </td>
      </tr>
      <tr>
        <td><button type="submit" name="send">SUBMIT</button></td>
      </tr>
    </table> -->
  </form>
  <script>
    $('#user_contact').bind('keyup blur', function(e) {
      var mb = $(this);
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        mb.val(mb.val().replace(/[^0-9]/g, ''));
      }
    });
    $(document).ready(function(e) {
      $('#contactfrm').on('submit', (function(e) {
        //alert('test');
        e.preventDefault();
        var err = 0;
        var mbReg = /^\d{10}$/;
        var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var user_name = $('#user_name').val();
        var user_email = $('#user_email').val();
        var user_contact = $('#user_contact').val();
        var user_message = $('#user_message').val();
        var response = grecaptcha.getResponse();

        if (user_name == '') {
          err++;
          $('#error_uname').html('Please enter your name!');
          //alert("Please enter your name.");
          $('#user_name').focus();
          //return false;
        } else {
          $('#error_uname').html('');
        }
        if (user_email == '') {
          err++;
          $('#error_email').html('Please enter your email!');
          $('#user_email').focus();
          //return false;
        } else {
          if (!emailReg.test(user_email)) {
            //console.log('test');
            err++;
            $('#error_email').html('Please enter valid email id');
            $('#user_email').focus();
          } else {
            $('#error_email').html('');
          }
        }
        if (user_contact == '') {
          err++;
          $('#error_contact').html('Please enter your contact number!');
          $('#user_contact').focus();
        } else {
          if (!mbReg.test(user_contact)) {
            //console.log('test');
            err++;
            $('#error_contact').html('Please enter your valid contact number!');
            $('#user_contact').focus();
          } else {
            $('#error_contact').html('');
          }
        }
        if (user_message == '') {
          err++;
          $('#error_msg').html('Please enter your message!');
          $('#user_message').focus();
        } else {
          $('#error_msg').html('');
        }
        if (!response) {
          err++;
          $('.captcha-error').attr("style", "display:block;color:red;").html('Coud not get recaptcha response');
          return false;
        }
        else
        {
          $('.captcha-error').attr("style", "display:none").html('');
        }
        if (err == 0) {
          //console.log('here is the ajax code!');
          var formData = {
            user_name: $("#user_name").val(),
            user_email: $("#user_email").val(),
            user_contact: $("#user_contact").val(),
            user_company_name: $("#user_company_name").val(),
            user_message: $("#user_message").val(),
          };
          $.ajax({
    		  type:'POST',
    		  url:'contact.php',
    		  data:formData,
          dataType: 'json',
          encode: true,
    		  success:function(response){
    			//alert(response);
    			if(response.success==true)
          {
            // $("#message_div").attr("style", "display:block");
            // $('#message_div').addClass('alert alert-success');
            // $('#message_div').html(data.message);

            // setTimeout(function() {
            //     $('#message_div').fadeOut('fast');
            //     //grecaptcha.reset();
            // }, 5000);
            toastr.options.timeOut = 5000;
            toastr.success('Your enquiry has been sent.');
            // setTimeout(function() {
            //   location.reload();
            // }, 7000);
            $("#user_name").val('');
            $("#user_email").val('');
            $("#user_contact").val('');
            $("#user_company_name").val('');
            $("#user_message").val('');  
          }

    		}
    	});
          //return true;
        } else {
          return false;
        }
      }));
    });
  </script>
</body>

</html>