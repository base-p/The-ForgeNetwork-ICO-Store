<!doctype html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='x-ua-compatible' content='ie=edge'>
        <title>ForgeNet ICO Shop</title>
        <meta name='description' content=''>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>
        <?php echo $this->Html->css('normalize'); ?>
        <?php echo $this->Html->css('main'); ?>
        <?php echo $this->Html->css('layout'); ?>
        <?php echo $this->Html->css('partials'); ?>
        <?php echo $this->Html->css('components'); ?>
        <?php echo $this->Html->css('utility'); ?>
        <?php
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
	    ?>
    </head>
<body class='dashboard dashboard--purchase'>
  
    
	 <?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
</body>
</html>