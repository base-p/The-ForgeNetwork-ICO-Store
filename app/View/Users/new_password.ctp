<body class='login'>
    <?php echo $this->element('header');?>
                <div class='contentContainer'>
                <section class='l-row'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    Set a new password
    </h1>            <div class='l-cols l-cols--2'>
                <div class='l-col'>
                    <?php echo $this->Form->create('User', array('url'=>['controller'=>'users','action'=>'new_password',$user_id,$r_key],'class' => 'c-form','id' => 'm-form')); ?>
                        <p class='c-form__row'>
                            <span class='c-form__label'>E-mail address</span>
                            <span class='c-form__field'><?php echo $email; ?></span>
                        </p>
                        <p class='c-form__row'>
                            <label for='password' class='c-form__label'>Password</label>
                            <input required id='password' type='password' class='c-form__field' name="data[password]"/>
                        </p>
                        <p class='c-form__row'>
                            <label for='passwordConfirm' class='c-form__label'>Password (confirmation)</label>
                            <input required id='passwordConfirm' type='password' class='c-form__field'name="data[cpwd]" />
                        </p>
                        <p class='c-form__row'>
                            <button type='submit'>Save password</button>
                        </p>
                    <?php echo $this->form->end(); ?>
                </div>
                <div class='l-col'>
                    <p>
                        Need help reactivating your account? Please contact us at one of our social media channels.
                        We'll be there to help you out. You'll be up and running in notime.
                    </p>
                </div>
            </div>
        </div>
    </section>
        </div>
         <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>