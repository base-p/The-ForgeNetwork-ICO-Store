$(document).ready(function(){
    $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
           "data[currentcode]": {
		          required: true,
		          number: true
            }
        },
        messages: {
            "data[currentcode]": {
		          required: "Enter 2FA Code!",
		          lettersonly: "Must be a Number!"
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


