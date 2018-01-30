$(document).ready(function(){
     
    
     $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
           "data[fname]": {
		          required: true,
		          lettersonly: true
            },
           "data[lname]": {
		          required: true,
		          lettersonly: true
            },
           "data[frg_wallet]": {
		           minlength: 34
		          //lettersonly: true
            }
        },
        messages: {
            "data[fname]": {
		          required: "First name cannot be empty!",
		          lettersonly: "Not a valid name!"
            },
            "data[lname]": {
		          required: "Last name cannot be empty!",
		          lettersonly: "Not a valid name!"
            }, 
            "data[frg_wallet]": {
		          minlength: "Enter a valid wallet address!",
		          //lettersonly: "Enter a valid amount!"
            }
        }
       
   } );
    } );
});