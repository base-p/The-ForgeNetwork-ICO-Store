$(document).ready(function(){
     var currency =  $('#currency').val();  
        var amount = Math.abs($('#amount').val());
        var frgreceived = amount*prices[currency]/current_price;
        frgreceived = frgreceived.toFixed(2);
        $('#frgamount').text(frgreceived+' FRG');
     $('#currency,#amount')
        .change(function(){
            var currency =  $('#currency').val();  
            var amount = Math.abs($('#amount').val()); 
            var frgreceived = amount*prices[currency]/current_price;
            frgreceived = frgreceived.toFixed(2);
            $('#frgamount').text(frgreceived+' FRG');
        });
    
     $( "form" ).each( function() {
    $( this ).validate( {
       errorElement: "div",
       rules: {
           "data[Wallet][amount]": {
		          number: true
            }
        },
        messages: {
            "data[Wallet][amount]": {
		          number: "Enter a valid amount!"
            }
        }
       
   } );
    } );
});