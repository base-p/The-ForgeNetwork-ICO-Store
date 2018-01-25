(function () {
    'use strict';

    var isAddressGenerationActive = false;
    var generateAddressToggler = null;
    var generateAddressContainer = null;


    function initializeDashboard () {
        generateAddressToggler = document.getElementById('toggleAddressGeneration');
        generateAddressContainer = document.getElementById('generateAddress');

        setupAddressGeneration();
        setupFrgCalculator();
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

    function setupFrgCalculator () {
        $('#c-calculator--currency, #c-calculator--paymentAmount').on('input', function () {
            var currency =  $('#c-calculator--currency').val();
            var amount = Math.abs($('#c-calculator--paymentAmount').val());
            var frgReceived = amount * prices[currency] / current_price;
            frgReceived = frgReceived.toFixed(2);
            $('#c-calculator--frgAmount').text(frgReceived +' FRG');
        });
    }

    $(document).ready(initializeDashboard);
})();