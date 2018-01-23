<body class='dashboard dashboard--purchase'>

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


                    <h2><?php echo $message; ?></h2>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
</div>
 </section>
        </div>
        <section class='l-row l-row--footer p-footer'>
    <div class='l-row__inner'>
        <div class='p-footer__first'>
            <div class='c-joinConversation'>
    <p class='c-joinConversation__label'>Questions? We've got answers:</p>
    <ul class='c-joinConversation__list u-flatList'>
        <li>
        
                        
<a class='c-socialMediaLink c-socialMediaLink--telegram c-socialMediaLink--white' href='https://t.me/ForgeNet' target='_blank' rel='noopener'>
    Telegram
</a></li>
        <li>
        
    
<a class='c-socialMediaLink c-socialMediaLink--discord c-socialMediaLink--white' href='https://discord.gg/QGrvgKC' target='_blank' rel='noopener'>
    Discord
</a></li>
        <li>
        
                        
<a class='c-socialMediaLink c-socialMediaLink--facebook c-socialMediaLink--white' href='https://www.facebook.com/ForgeNetCoin/' target='_blank' rel='noopener'>
    Facebook
</a></li>
        <li>
        
                        
<a class='c-socialMediaLink c-socialMediaLink--twitter c-socialMediaLink--white' href='https://twitter.com/forgenetcoin' target='_blank' rel='noopener'>
    Twitter
</a></li>
        <li>
        
                        
<a class='c-socialMediaLink c-socialMediaLink--instagram c-socialMediaLink--white' href='https://www.instagram.com/theforgenetwork' target='_blank' rel='noopener'>
    Instagram
</a></li>
        <li>
        
                        
<a class='c-socialMediaLink c-socialMediaLink--reddit c-socialMediaLink--white' href='https://www.reddit.com/r/TheForgeNetwork/' target='_blank' rel='noopener'>
    Reddit
</a></li>
    </ul>
</div>        </div>
        <div class='p-footer__second'>
            <p>Copyright 2018 The Forge Network. All rights reserved.</p>
            <ul>
                <li><a target='_blank' href='https://theforgenetwork.com/privacy-policy'>Privacy policy</a></li>
                <li><a target='_blank' href='https://theforgenetwork.com/terms-of-service'>Terms of Service</a></li>
            </ul>
        </div>
    </div>              
</section>
    <?php echo $this->Html->script('countDown');?>
</body>        