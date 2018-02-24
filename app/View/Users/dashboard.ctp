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
    </ul>
            
            <ol class="u-flatList c-purchaseSteps">
                <li class='c-purchaseSteps__step'>
                    <span class='c-purchaseSteps__count'>1</span> Generate address
                </li>
                <li class='c-purchaseSteps__step'>
                    <span class='c-purchaseSteps__count'>2</span> Send funds
                </li>
                <li class='c-purchaseSteps__step'>
                    <span class='c-purchaseSteps__count'>3</span> Get FRG
                </li>
            </ol>
            <?php echo $this->Session->flash(); ?>
            <h2>Generate address</h2>
            <p><span id='toggleAddressGeneration' class="c-button c-button--white">Generate new address</span></p>
            <div id='generateAddress' class='c-generateAddress'>
                <p>
                    You can generate addresses for up to five currencies. Generated addresses are personal and can be used for multiple transactions.
                    Please note that generating an address can take <strong>up to one minute</strong>.
                </p>
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
                    <button type='submit'>Generate address</button>
                </p>
                <?php echo $this->form->end(); ?>
            </div>
            <div class='c-refDisplay'>
                <p>Here is your referral link:</p>
                <p><code class="reflinkdisp">https://shop.theforgenetwork.com/register/ref/<?=$ref_id;?></code></p>
                <p class="reflinkpdisp">Use it to invite your friends to purchase FRG and you earn a 14% bonus on their deposits. Feel free to share it on social media too!</p>        
            </div>
            
            <?php if(!empty($wallets)){ ?>
            <h2>Send funds</h2>
            <p>You can safely send funds to one of the generated addresses below. These addresses are
            <em>personal</em>. You can use an address for multiple transactions. Make sure that the currency you send, matches
            the one of the generated address. Failing to do so, will result in the loss of your funds!</p>
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
                        
                    </p>
                </li>
                <?php }; ?>
            </ul>
            <p class="c-disclaimer">No minimum transaction!</p>
            <h2>Get FRG</h2>
            <p>
                Every time you send funds to one of the above addresses, a new transaction will be generated.
                Sent funds will be converted to FRG upon completion of the transaction. All of your transactions will
                be visible on the <a href='dashboard_transactions'>transactions page</a>.
            </p>
            <?php }; ?>
        </div>
        
    </section>
        <section class="l-row l-row--calculator l-row--tint">
            <div class="l-row__inner">
                <h2>FRG calculator</h2>
                <p>Want to know the amount of FRG you'll receive? We've built a little calculator to help you out. Please note that the shown amount is an estimate: the final conversion takes place upon completion of the transaction, and exchange rates may vary.</p>
                <form class="c-form c-calculator">
                    <p class="c-form__row">
                        <label for="c-calculator--currency" class="c-form__label">Select currency you plan to pay with</label>
                        <select id="c-calculator--currency" class="c-form__field">
                            <option value="BTC">Bitcoin</option>
                            <option value="ETH">Ethereum</option>
                            <option value="LTC">Litecoin</option>
                            <option value="BCH">Bitcoin Cash</option>
                            <option value="DOGE">Doge</option>
                        </select>
                    </p>
                    <p class="c-form__row">
                        <label for="c-calculator--paymentAmount" class="c-form__label">Payment amount</label>
                        <input id="c-calculator--paymentAmount" type="number" class="c-form__field" />
                    </p>
                    <p class="c-form__row">
                        <span class="c-form__label">Amount of FRG you'll receive</span>
                        <span class="c-form__field"><code id="c-calculator--frgAmount">... FRG</code></span>
                    </p>
                </form>
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