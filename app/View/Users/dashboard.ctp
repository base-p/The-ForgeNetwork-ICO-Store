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

        <?php echo $this->element('header');?>       <div class='contentContainer'>
                <section class='l-row l-row--dashboard'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    ForgeNet ICO Dashboard
    <span class='c-pageTitle__subtitle'>Welcome, <?php echo htmlspecialchars(ucfirst($fname), ENT_QUOTES); ?></span></h1>            
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
    </ul>           <h2>Purchase FRG</h2>
            <?php echo $this->Session->flash(); ?>
            <p>
                Send funds to one of your personal addresses as generated below. You can send funds to the same address multiple times. Every
                transaction will be listed on the <a href='dashboard_transactions'>transactions</a> page separately.
            </p>
            <p>
                Make sure that the currency you send, matches the one of the generated address. Failing to do so, will
                result in the loss of your funds!
            </p>
           <?php if(!empty($wallets)){ ?>
            <ul class='c-addresses u-flatList'>
                <?php foreach($wallets as $wallet){ ?>
                <li class='c-addresses__address c-addresses__address--<?php echo strtolower($wallet['Wallet']['currency']); ?>'>
                    <h4>
                        <?php 
                            switch ($wallet['Wallet']['currency']) {
                            case 'ETH':
                                echo 'Ethereum';
                                break;
                            case 'BTC':
                                echo 'Bitcoin';
                                break;
                            case 'LTC':
                                echo 'Litecoin';
                                break;
                            case 'BCH':
                                echo 'Bitcoin Cash';
                                break;
                            case 'DOGE':
                                echo 'DOGE';
                                break;
                            }
                        ?>
                    </h4>
                    <p>
                        <span><code><?php echo $wallet['Wallet']['address']; ?></code></span>
                        <span>Minimal transaction: <code><?php 
                            switch ($wallet['Wallet']['currency']) {
                            case 'ETH':
                                echo '0.178 ETH';
                                break;
                            case 'BTC':
                                echo '0.016 BTC';
                                break;
                            case 'LTC':
                                echo '1 LTC';
                                break;
                            case 'BCH':
                                echo '0.11 BCH';
                                break;
                            case 'DOGE':
                                echo '26211 DOGE';
                                break;
                            }
                        ?></code></span>
                    </p>
                    
                </li>
                <?php }; ?>
            </ul>
            <?php }; ?>
            <h3>Generate a personal payment address</h3>
            
           <?php echo $this->Form->create('Wallet', array('url'=>['controller'=>'users','action'=>'dashboard'],'class' => 'c-form','id' => 'm-form')); ?>
                     
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
                    <span class='c-form__subtitle'>Entering an amount is optional and only used to calculate the estimate below.</span>
                    <input id='amount' type='number' class='c-form__field' name="data[Wallet][amount]"/>
                </p>
                <p class='c-form__row' id="displayrecv">
                    <span class='c-form__label'>Amount of FRG you'll receive</span>
                    <span class='c-form__field'><code id="frgamount">... FRG</code></span>
                </p> 
                
                <p class='c-form__row'>
                    <button type='submit'>Generate address</button>
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