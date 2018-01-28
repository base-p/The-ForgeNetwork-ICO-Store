$(document).ready(function(){
    $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
            "data[email]": {
                required: true,
                email: true
            }
        },
        messages: {
            "data[email]": {
                required: "Email is required!",
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


