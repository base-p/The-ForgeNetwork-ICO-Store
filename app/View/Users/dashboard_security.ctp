<body class='dashboard dashboard--security'>
        <?php echo $this->element('header');?>       <div class='contentContainer'>
                <section class='l-row l-row--dashboard'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    ForgeNet ICO Dashboard
    <span class='c-pageTitle__subtitle'>Welcome, <?php echo htmlspecialchars(ucfirst($fname), ENT_QUOTES); ?></span></h1>            
<ul class='c-menu'>
            <li>
            <a href='dashboard'>Purchase</a>
        </li>
            <li>
            <a href='dashboard_transactions'>Transactions</a>
        </li>
            <li>
            <a href='dashboard_settings'>Settings</a>
        </li>
            <li class='c-menu--active'>
            <a href='dashboard_security'>Security</a>
        </li>   
        <li>
            <a href='logout'>Logout</a>
        </li>
    </ul>            <h2>Security</h2>
            <p>
                Please enable two-factor authentication for you to secure your profile. Enable this by scanning
                the following QR code (Using Google Authenticator or Authy) and entering the one-time code in the following field. Also Back-up your 2FA secret, it will be needed if you loose your phone.
            </p>
            <?php echo $this->Session->flash(); ?>
            <?php 
            if(!empty($fa2object)){
            echo $this->Form->create('Wallet', array('url'=>['controller'=>'users','action'=>'dashboard_security'],'class' => 'c-form','id' => 'm-form')); ?>
                     <?php echo $this->Session->flash(); ?>
                <p class='c-form__row'>
                    <img src='<?php echo $fa2object['barcode'] ?>' alt='' width='200' />
                </p>
                <p class='c-form__row'>
                    2FA Secret:  <code><?php echo $fa2object['secret'] ?></code>
                </p>
                <p class='c-form__row'>
                    <label required for='code' class='c-form__label'>Code</label>
                    <input required id='code' type='number' class='c-form__field' name="data[currentcode]"/>
                    <input type='hidden' value='<?php echo $fa2object['secret'];?>' name="data[secret]"/>
                </p>
                <p class='c-form__row'>
                    <button type='submit'>Enable two-factor authentication</button>
                </p>
            <?php echo $this->form->end(); }?>
        </div>
    </section>
        </div>
    <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>