<body class='login'>
    <script>
	var SITEPATH = '<?php echo SITEPATH; ?>';
 </script>
    
    <?php echo $this->Html->script('jquery.js');?>
    <?php echo $this->Html->script('jquery.validate.min.js');?>
    <?php echo $this->Html->script('additional-methods.min.js');?>
    <?php echo $this->Html->script('resetvalidate.js');?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <?php echo $this->element('header');?>      <div class='contentContainer'>
                <section class='l-row'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    Reset your password
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'resetpassword'],'class' => 'c-form','id' => 'm-form')); ?>
                        <p class='c-form__row'>
                            <label for='username' class='c-form__label'>E-mail address</label>
                            <input required id='username' type='text' class='c-form__field'  name="data[email]" />
                        </p>
                    <div id='recaptcha' class="g-recaptcha" data-sitekey="6Ld_1UEUAAAAAADb_csEomGPzZUh9dZmCyRAYtl8" data-callback="onSubmit" data-size="invisible" data-badge="bottomleft">
                        </div>
                        <p class='c-form__row'>
                            <button type='submit'>Reset password</button>
                        </p>
                   <?php echo $this->form->end(); ?>
                </div>
                <div class='l-col'>
                    <p>
                        Can't remember the e-mail address you used? Please contact us at one of our social media channels.
                        We'll be there to help you out. You'll be up and running in notime.
                    </p>
                    <p>
                        Don't have an account yet? You can <a href='register'>register</a> here.
                    </p>
                </div>
            </div>
        </div>
    </section>
        </div>
    
     <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>