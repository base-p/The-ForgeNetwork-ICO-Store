<?php
App::uses('AppModel', 'Model');

class Transaction extends AppModel {
     var $name = 'Transaction';
    
    public $belongsTo = 'Wallet';
    
    
     
}
?>
