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
		          required: true,
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
		          required: "Wallet address is required for payout!",
		          //lettersonly: "Enter a valid amount!"
            }
        }
       
   } );
    } );
});