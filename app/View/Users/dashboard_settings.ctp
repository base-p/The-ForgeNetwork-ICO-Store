<body class='dashboard dashboard--settings'>
    <script>
	var SITEPATH = '<?php echo SITEPATH; ?>';
 </script>
    <style>
       #fname-error,#lname-error,#frg_wallet-error{
            color: white;
        }
    </style>
    
    <?php echo $this->Html->script('jquery.js');?>
    <?php echo $this->Html->script('jquery.validate.min.js');?>
    <?php echo $this->Html->script('additional-methods.min.js');?>
    <?php echo $this->Html->script('validate.js');?>
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
            <li>
            <a href='dashboard'>Purchase</a>
        </li>
            <li>
            <a href='dashboard_transactions'>Transactions</a>
        </li>
            <li class='c-menu--active'>
            <a href='dashboard_settings'>Settings</a>
        </li>
            <li>
            <a href='dashboard_security'>Security</a>
        </li>
    <li>
            <a href='logout'>Logout</a>
        </li>
    </ul>            <h2>Settings</h2>
            <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'dashboard_settings'],'class' => 'c-form','id' => 'm-form')); ?>
                     <?php echo $this->Session->flash(); ?>
                <p class='c-form__row'>
                    <span class='c-form__label'>E-mail address</span>
                    <span class='c-form__field'><?php echo $email;?></span>
                </p>
                <p class='c-form__row'>
                    <label for='firstName' class='c-form__label'>First name</label>
                    <input required id='firstName' type='text' class='c-form__field' name="data[fname]" value='<?php echo $fname;?>' />
                </p>
                <p class='c-form__row'>
                    <label for='lastName' class='c-form__label'>Last name</label>
                    <input required id='lastName' type='text' class='c-form__field' name="data[lname]" value='<?php echo $lname;?>' />
                </p>
                <p class='c-form__row'>
                    <label for='frg' class='c-form__label'>FRG address</label>
                    <input required id='frg' type='text' class='c-form__field' name="data[frg_wallet]" value="<?php echo $frg_wallet;?>"/>
                </p>
                <p class='c-form__row'>
                    <button type='submit'>Update</button>
                </p>
            <?php echo $this->form->end(); ?>
        </div>
    </section>
        </div>
     <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>