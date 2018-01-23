<body class='register'>
    <script>
	var SITEPATH = '<?php echo SITEPATH; ?>';
 </script>
    
    <?php echo $this->Html->script('jquery.js');?>
    <?php echo $this->Html->script('jquery.validate.min.js');?>
    <?php echo $this->Html->script('additional-methods.min.js');?>
    <?php echo $this->Html->script('Homevalidate.js');?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
        <section class='l-row l-row--menu p-menu'>
    <div class='l-row__inner'>
        <a href='home.html' class='c-minimalLogo'>
    <img class='c-minimalLogo__avatar' src='img/favicon.png' width='18' height='18' alt=''>
    <span class='c-minimalLogo__company u-fontHeadings'>ForgeNet</span>
    <span class='c-minimalLogo__tagLine'>ICO Shop</span>
</a>    </div>
</section>        <div class='contentContainer'>
                <section class='l-row'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
   Register for ForgeNet ICO Dashboard
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'register'],'class' => 'c-form','id' => 'm-form')); ?>
                  
                        <?php echo $this->Session->flash(); ?>
                        <p class='c-form__row'>
                            <label for='firstName' class='c-form__label'>First name</label>
                            <input required id='firstName' type='text' class='c-form__field' name="data[User][first_name]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='lastName' class='c-form__label'>Last name</label>
                            <input required id='lastName' type='text' class='c-form__field' name="data[User][last_name]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='email' class='c-form__label'>E-mail address</label>
                            <input required id='email' type='email' class='c-form__field' name="data[User][username]"/>
                        </p>
                        <p class='c-form__row'>
                            <span class='c-form__subtitle'>
                                Please provide your FRG wallet address. Coins will be sent to this address after
                                purchasing them. Don't have an address yet? You can download
                                <a href='https://theforgenetwork.com/wallets'>the wallet here</a>.
                            </span>
                            <label for='frg' class='c-form__label'>FRG address</label>
                            <input required id='frg' type='text' class='c-form__field' name="data[User][frg_wallet]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='password' class='c-form__label'>Password</label>
                            <input required id='password' type='password' class='c-form__field' name="data[User][password]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='passwordConfirm' class='c-form__label'>Password (confirmation)</label>
                            <input required id='passwordConfirm' type='password' class='c-form__field'  name="data[cnfrm_password]"/>
                        </p>
                      <div id='recaptcha' class="g-recaptcha" data-sitekey="6Ld_1UEUAAAAAADb_csEomGPzZUh9dZmCyRAYtl8" data-callback="onSubmit" data-size="invisible" data-badge="bottomleft">
                        </div>
                        
                        <p class='c-form__row'>
                           
                            <button type="submit">Register</button>
                        </p>
                   <?php echo $this->form->end(); ?>
                </div>
                <div class='l-col'>
                    <p>
                        Trouble registering? Please contact us at one of our social media channels. We'll be there
                        to help you out. You'll be up and running in notime.
                    </p>
                    <p>
                        Already have an account? You can <a href='login'>login</a> here.
                    </p>
                </div>
            </div>
        </div>
    </section>
        </div>
     <?php echo $this->element('footer');?>
              <?php echo $this->Html->script('countDown');?>
    </body>