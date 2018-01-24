$(document).ready(function(){
    $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
           "data[User][first_name]": {
		          required: true,
		          lettersonly: true
            },
           "data[User][last_name]": {
		          required: true,
		          lettersonly: true
            },
           "data[User][password]": {
		      required: true,
		      minlength: 8
           },
            "data[User][username]": {
                required: true,
                email: true,
                remote: {url: SITEPATH +'users/checkEmail', type: "post"}
            },
           "data[cnfrm_password]": {
               required: true,
                equalTo: "#password"
            },
           "data[User][frg_wallet]": {
               required: true
            }
        },
        messages: {
            "data[User][first_name]": {
		          required: "Enter First Name!",
		          lettersonly: "Letters only!"
            },
           "data[User][last_name]": {
		          required: "Enter First Name!",
		          lettersonly: "Letters only!"
            },
           "data[User][password]": {
		      required: "Enter Password!",
		      minlength: "The password must be at least 8 characters long"
           },
            "data[User][username]": {
                required: "We need your Email!",
                email: "Email is in wrong format!",
                remote: "Email is already registered"
            },
           "data[cnfrm_password]": {
               required: "Confirm password!",
                equalTo: "Wrong confirmation"
            },
            "data[User][frg_wallet]": {
               required: "Enter Wallet Address!"
            }
        },
        submitHandler: function() {
           
            grecaptcha.execute();
          
        }

       
   } );
    } );

});

function onSubmit(token) {
   document.getElementById("m-form").submit();

  }


