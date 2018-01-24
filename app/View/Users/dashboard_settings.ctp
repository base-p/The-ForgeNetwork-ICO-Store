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
       <?php echo $this->element('header');?>    <div class='contentContainer'>
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
                    <span class='c-form__field'><?php echo htmlspecialchars($email, ENT_QUOTES);?></span>
                </p>
                <p class='c-form__row'>
                    <label for='firstName' class='c-form__label'>First name</label>
                    <input required id='firstName' type='text' class='c-form__field' name="data[fname]" value='<?php echo htmlspecialchars($fname, ENT_QUOTES);?>' />
                </p>
                <p class='c-form__row'>
                    <label for='lastName' class='c-form__label'>Last name</label>
                    <input required id='lastName' type='text' class='c-form__field' name="data[lname]" value='<?php echo htmlspecialchars($lname, ENT_QUOTES);?>' />
                </p>
                <p class='c-form__row'>
                    <label for='frg' class='c-form__label'>FRG address</label>
                    <input required id='frg' type='text' class='c-form__field' name="data[frg_wallet]" value="<?php echo htmlspecialchars($frg_wallet, ENT_QUOTES);?>"/>
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