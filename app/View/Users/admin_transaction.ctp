 <body class='admin admin--transactions'>
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
    ForgeNet ICO Admin Dashboard
    </h1>            
<ul class='c-menu c-menu--dashboard'>
            <li>
            <a href='dash'>Purchase</a>
        </li>
            <li class='c-menu--active'>
            <a href='transaction'>Transactions</a>
        </li>
    </ul>            <h2>Transactions</h2>
            <p>All transactions of all registered users.</p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Wallet address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user){ ?>
                    <tr>
                        <td><?= $user['Transaction']['id']; ?></td>
                        <td><?= $user['Transaction']['created']; ?></td>
                        <td><?= $user['Transaction']['amount'].' '.$user['Wallet']['currency']; ?></td>
                        <td><?= $user['Wallet']['address']; ?></td>
                        <td><?= $user['Transaction']['status']; ?></td>
                    </tr>
                   <?php } ?> 
                </tbody>
                <tfoot>
                <tr>
                    <td colspan='4'>
                        <?php echo $this->element('paging_links'); ?>
                        <p>Total number of transactions: <?= $total ?>.</p>
                    </td>
                </tr>
                </tfoot>
            </table>
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
</section>        <script src='js/countDown.js'></script>
    </body>