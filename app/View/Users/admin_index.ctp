 <body class='login'>
     <script>
	var SITEPATH = '<?php echo SITEPATH; ?>';
 </script>
    
    <?php echo $this->Html->script('jquery.js');?>
    <?php echo $this->Html->script('jquery.validate.min.js');?>
    <?php echo $this->Html->script('additional-methods.min.js');?>
    <?php echo $this->Html->script('loginvalidate.js');?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <?php echo $this->element('header');?>      
     <div class='contentContainer'>
                <section class='l-row'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    Login to ForgeNet Admin Dashboard
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <?php echo $this->Form->create('User', array('url'=>['controller' => 'users', 'action' => 'index','admin'=>1],'class' => 'c-form','id' => 'm-form')); ?>
                     <?php echo $this->Session->flash(); ?>
                        <p class='c-form__row'>
                            <label for='username' class='c-form__label'>E-mail address</label>
                            <input required id='username' type='text' class='c-form__field' name="data[User][username]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='password' class='c-form__label'>Password</label>
                            <span class='c-form__subtitle'>Forgot your password? <a href='resetpassword'>Reset</a> it here.</span>
                            <input required id='password' type='password' class='c-form__field' name="data[User][password]"/>
                        </p>
                    <div id='recaptcha' class="g-recaptcha" data-sitekey="6Ld_1UEUAAAAAADb_csEomGPzZUh9dZmCyRAYtl8" data-callback="onSubmit" data-size="invisible" data-badge="bottomleft">
                        </div>
                        <p class='c-form__row'>
                            <button type='submit'>Login</button>
                        </p>
                    <?php echo $this->form->end(); ?>
                </div>
                <div class='l-col'>
                    
                </div>
            </div>
        </div>
    </section>
        </div>
     <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>