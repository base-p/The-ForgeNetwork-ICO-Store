<body class='dashboard dashboard--purchase'>
    <script>
	   var SITEPATH = '<?php echo SITEPATH; ?>';
        var prices = [];
        prices['BTC'] = <?php echo $prices['usdrate']; ?>;
        prices['LTC'] = <?php echo $prices['btcltc']; ?>;
        prices['ETH'] = <?php echo $prices['btceth']; ?>;
        prices['BCH'] = <?php echo $prices['btcbch']; ?>;
        prices['DOGE'] = <?php echo $prices['btcdoge']; ?>;
        var current_price = <?php echo $prices['current_price']; ?>;
    </script>
    <style>
       #amount-error{
            color: white;
        }
    </style>

        <section class='l-row l-row--menu p-menu'>
    <div class='l-row__inner'>
        <a href='home.html' class='c-minimalLogo'>
    <img class='c-minimalLogo__avatar' src='img/favicon.png' width='18' height='18' alt=''>
    <span class='c-minimalLogo__company u-fontHeadings'>ForgeNet</span>
    <span class='c-minimalLogo__tagLine'>ICO Shop</span>
</a>    </div>
</section>        <div class='contentContainer'>
                <section class='l-row l-row--dashboard'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    ForgeNet ICO Dashboard
    <span class='c-pageTitle__subtitle'>Welcome, Peter</span></h1>            
<ul class='c-menu'>
            <li class='c-menu--active'>
            <a href='dashboard'>Purchase</a>
        </li>
            <li>
            <a href='dashboard_transactions'>Transactions</a>
        </li>
            <li>
            <a href='dashboard_settings'>Settings</a>
        </li>
            <li>
            <a href='dashboard_security'>Security</a>
        </li>
    <li>
            <a href='logout'>Logout</a>
        </li>
    </ul>            <h2>Purchase FRG</h2>
            <p>
                For simplicity and accessibility, we are accepting all Coinbase currencies, aswell as Doge.
                You can purchase FRG by selecting the currency and amount you wish to pay with below. After
                submitting your order, you'll be provided with an address for the selected currency.
                After you have sent the payment, return to transaction history for more details. Your transaction history will be visible
                <a href='dashboard_transactions'>here</a>. You'll see pending aswell as completed transactions there.
                Pending transactions will be marked complete as soon as enough confirmations have been received.<strong> Actual amount of FRG received will be determined when your payment is confirmed on the blockchain.</strong>
            </p>
            
           <?php echo $this->Form->create('Wallet', array('url'=>['controller'=>'users','action'=>'dashboard'],'class' => 'c-form','id' => 'm-form')); ?>
                     <?php echo $this->Session->flash(); ?>
                <p class='c-form__row'>
                    <label for='currency' class='c-form__label'>Select currency to pay with</label>
                    <select required id='currency' class='c-form__field' name="data[Wallet][currency]">
                        <option value='BTC'>Bitcoin</option>
                        <option value='ETH'>Ethereum</option>
                        <option value='LTC'>Litecoin</option>
                        <option value='BCH'>Bitcoin Cash</option>
                        <option value='DOGE'>Doge</option>
                    </select>
                </p>
                <p class='c-form__row'>
                    <label for='amount' class='c-form__label'>Amount</label>
                    <input required id='amount' type='number' class='c-form__field' name="data[Wallet][amount]"/>
                </p>
                <p class='c-form__row' id="displayrecv">
                    <span class='c-form__label'>Amount of FRG you'll receive</span>
                    <span class='c-form__field'><code id="frgamount">... FRG</code></span>
                </p> 
                <?php if(isset($address) && isset($amount) && isset($currency)){ ?>
                <p class='c-form__row'>
                    <span class='c-form__label'>Send <?php echo $amount ?> <?php echo $currency ?> to:</span>
                    <span class='c-form__field'><code><?php echo $address ?></code></span>
                    <span class='c-form__label'>Sending any currency other than <?php echo $currency ?> to the above address will result in the loss of your funds.</span>
                </p>
                <?php } ?>
                <p class='c-form__row'>
                    <button type='submit'>Purchase</button>
                </p>
             <?php echo $this->form->end(); ?>
        </div>
    </section>
        </div>
    <?php echo $this->element('footer');?>
              <?php echo $this->Html->script('countDown');?>
              <?php echo $this->Html->script('jquery');?>
             <?php echo $this->Html->script('jquery.validate.min.js');?>
                <?php echo $this->Html->script('additional-methods.min.js');?>
              <?php echo $this->Html->script('dashboard');?>
    </body>