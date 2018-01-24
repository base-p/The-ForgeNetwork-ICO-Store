$(document).ready(function(){
    $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
           
           "data[User][password]": {
		      required: true,
		      minlength: 8
           },
            "data[User][username]": {
                required: true,
                email: true
            }
        },
        messages: {
            
           "data[User][password]": {
		      required: "Enter Password!",
		      minlength: "The password must be at least 8 characters long"
           },
            "data[User][username]": {
                required: "We need your Email!",
                email: "Email is in wrong format!"
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


