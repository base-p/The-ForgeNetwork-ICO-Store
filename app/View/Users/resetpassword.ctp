<body class='login'>
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
    Reset your password
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <div class='c-notice'><?php echo $this->Session->flash(); ?></div>
                    <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'resetpassword'],'class' => 'c-form','id' => 'm-form')); ?>
                        <p class='c-form__row'>
                            <label for='username' class='c-form__label'>E-mail address</label>
                            <input required id='username' type='text' class='c-form__field'  name="data[email]" />
                        </p>
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
                        Don't have an account yet? You can <a href='register.html'>register</a> here.
                    </p>
                </div>
            </div>
        </div>
    </section>
        </div>
    
     <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>