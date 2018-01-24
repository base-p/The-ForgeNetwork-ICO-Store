<body class='login'>
    
     <script>
	var SITEPATH = '<?php echo SITEPATH; ?>';
 </script>
    
    <?php echo $this->Html->script('jquery.js');?>
    <?php echo $this->Html->script('jquery.validate.min.js');?>
    <?php echo $this->Html->script('additional-methods.min.js');?>
    <?php echo $this->Html->script('2favalidate.js');?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <?php echo $this->element('header');?>       <div class='contentContainer'>
                <section class='l-row'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    Confirm 2FA Code
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <p class='c-notice'>Confirm 2FA Code as displayed on your Google Athenticator or Authy</p>
                      <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'confirm2fa'],'class' => 'c-form','id' => 'm-form')); ?>
                  
                        <?php echo $this->Session->flash(); ?>
                        <p class='c-form__row'>
                            <label for='username' class='c-form__label'>2FA Code</label>
                            <input required id='username' type='number' class='c-form__field' name='data[currentcode]' />
                        </p>
                    <div id='recaptcha' class="g-recaptcha" data-sitekey="6Ld_1UEUAAAAAADb_csEomGPzZUh9dZmCyRAYtl8" data-callback="onSubmit" data-size="invisible" data-badge="bottomleft">
                        </div>
                        <p class='c-form__row'>
                            <button type='submit'>Confirm 2FA</button>
                        </p>
                   <?php echo $this->form->end(); ?>
                </div>
                <div class='l-col'>
                    <p>
                        Dont Have Access to your phone? Please contact us at one of our social media channels.
                        We'll be there to help you out. You'll be up and running in no time.
                    </p>
                    
                </div>
            </div>
        </div>
    </section>
        </div>
    
     <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>