<body class='dashboard dashboard--transactions'>
        <?php echo $this->element('header');?>        <div class='contentContainer'>
                <section class='l-row l-row--dashboard'>
        <div class='l-row__inner'>
            <h1 class='c-pageTitle'>
    ForgeNet ICO Dashboard
    <span class='c-pageTitle__subtitle'>Welcome, <?php echo htmlspecialchars(ucfirst($fname), ENT_QUOTES); ?></span></h1>            
<ul class='c-menu'>
            <li>
            <a href='dashboard'>Purchase</a>
        </li>
            <li class='c-menu--active'>
            <a href='dashboard_transactions'>Transactions</a>
        </li>
            <li>
            <a href='dashboard_settings'>Settings</a>
        </li>
            <li>
            <a href='dashboard_security'>Security</a>
        </li>
    <li>
            <a href='logout'>Logout</a>
        </li>
    </ul>            <h2>Transactions</h2>
            <p>
                Your transaction history shows all of your transactions. A transaction can have the status
                <code>pending</code> or <code>completed</code> or <code>error</code>. Pending transactions will be completed as soon
                we have received sufficient confirmations. Transactions with Error status may never be completed and has probably been double spent or reversed to you. If you've got a question regarding a transaction,
                please join us on one of our channels and refer to the transaction <code>ID</code>. FRG Amount is computed when payment has been confirmed on the blockchain.
            </p>
            <?php if(!empty($txns)){ ?>
            <table>
                <caption>You've purchased <code><?php echo $earned; ?> FRG</code> in total.</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Amount(FRG)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach($txns as $txn) {?>
                    <tr>
                        <td><?php echo $txn['Transaction']['id']; ?></td>
                        <td><?php echo $txn['Transaction']['created']; ?></td>
                        <td><?php echo $txn['Transaction']['amount']; ?></td>
                        <td><?php echo $txn['Wallet']['currency']; ?></td>
                        <td><?php if(!empty($txn['Transaction']['frg_amount'])) {echo $txn['Transaction']['frg_amount'].' FRG';}else{echo '...';} ?></td>
                        <td><?php echo $txn['Transaction']['status']; ?></td>
                    </tr>
                     <?php }?>
                </tbody>
            </table>
            <?php }else {?>
                <p>
                   No activity recorded yet.
                </p>
            <?php }?>
        </div>
    </section>
        </div>
    <?php echo $this->element('footer');?>
             <?php echo $this->Html->script('countDown');?>
    </body>