// $(document).ready(function(){
//      var currency =  $('#currency').val();
//         var amount = Math.abs($('#amount').val());
//         var frgreceived = amount*prices[currency]/current_price;
//         frgreceived = frgreceived.toFixed(2);
//         $('#frgamount').text(frgreceived+' FRG');
//
//      $('#currency, #amount').on('input', function() {
//             var currency =  $('#currency').val();
//             var amount = Math.abs($('#amount').val());
//             var frgreceived = amount*prices[currency]/current_price;
//             frgreceived = frgreceived.toFixed(2);
//             $('#frgamount').text(frgreceived+' FRG');
//             $('#labeltext').text('Amount of '+currency);
//         });
//
//      $( "form" ).each( function() {
//     $( this ).validate( {
//        errorElement: "div",
//        rules: {
//            "data[Wallet][amount]": {
// 		          number: true
//             }
//         },
//         messages: {
//             "data[Wallet][amount]": {
// 		          number: "Enter a valid amount!"
//             }
//         }
//
//    } );
//     } );
// });

(function () {
    'use strict';

    var isAddressGenerationActive = false;
    var generateAddressToggler = null;
    var generateAddressContainer = null;


    function initializeDashboard () {
        generateAddressToggler = document.getElementById('toggleAddressGeneration');
        generateAddressContainer = document.getElementById('generateAddress');

        setupAddressGeneration();
    }

    function setupAddressGeneration () {
        document.addEventListener('click', function (event) {
            var element = event.target || event.srcElement;

            if (element === generateAddressToggler) {
                generateAddressToggler.classList.toggle('c-button--active');
                generateAddressContainer.classList.toggle('c-generateAddress--active');
                isAddressGenerationActive = !isAddressGenerationActive;
            }

            if (
                element !== generateAddressContainer
                && element !== generateAddressToggler
                && !generateAddressContainer.contains(element)
                && isAddressGenerationActive === true
            ) {
                generateAddressToggler.classList.remove('c-button--active');
                generateAddressContainer.classList.remove('c-generateAddress--active');
                isAddressGenerationActive = false;
            }
        });
    }

    $(document).ready(initializeDashboard);
})();