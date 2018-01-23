<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('User','Feed','Wallet','Transaction');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function index() {
		
	}
    
    
    public function dashboard() {
		$user_id = $this->Auth->User('id');
        $prices=[];
        $feeds=$this->Feed->find('all');
        foreach($feeds as $feed){
            $prices[$feed['Feed']['title']]=$feed['Feed']['feed'];
        }
        foreach($prices as $key=>$price){
            if($key != 'current_price' && $key != 'usdrate'){
                $prices[$key]=$price*$prices['usdrate'];
            }
        }
        
       // $usdRate = $this->getRates();
        if($this->request->is('post') && !empty($this->request->data)){
            $amount=abs($this->request->data['Wallet']['amount']);
            $currency=$this->request->data['Wallet']['currency'];
            $userWallet = $this->Wallet->find('first',array('conditions'=>array('Wallet.user_id'=>$user_id,'Wallet.currency'=>$currency)));
            if(empty($userWallet)){
                $address1=$this->generateAddress($currency);
                $address= $address1['address'];
                if(!empty($address1['pubkey'])){
                    $pubkey = $address1['pubkey'];
                    $wallet_arr = array("user_id" =>$user_id,
                        "currency" => $currency,
                        "address" => $address,
                        "pubkey" => $pubkey,
                    );
                }else{
                    $wallet_arr = array("user_id" =>$user_id,
                        "currency" => $currency,
                        "address" => $address,
                    );
                }
                if($this->Wallet->save($wallet_arr)){
                     $this->Flash->Success(__('Success!'));
                }else{
                    $this->Flash->error(__('Something went Wrong!'));
                }
            }else{
                $address=$userWallet['Wallet']['address'];
                $this->Flash->Success(__('Success!'));
            }
            
        }
        $this->set(compact('days','prices','address','currency','amount'));
	}
    
    public function dashboard_transactions() {
		$user_id = $this->Auth->User('id'); 
         $txns = $this->Transaction->find('all',array('conditions'=>array('Transaction.user_id'=>$user_id)));
        $earned=0;
        foreach ($txns as $key=>$txn){
            $earned += $txn['Transaction']['frg_amount'];
            $ctime=new DateTime($txns[$key]['Transaction']['created']);
            $txns[$key]['Transaction']['created'] = $ctime->format("Y-m-d");
            $status = $txns[$key]['Transaction']['status'];
            if ($status >= 100 || $status == 2) {
                $txns[$key]['Transaction']['status']='Completed';
            } else if ($status < 0) {
                $txns[$key]['Transaction']['status']='Error';
            } else {
                $txns[$key]['Transaction']['status']='Pending';
            }
        }
        
        
        
        $this->set(compact('txns','earned'));
        
	}
    
      public function dashboard_settings() {
		$user_id = $this->Auth->User('id');
        $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        $fname = $userDetails['User']['first_name'];
        $lname = $userDetails['User']['last_name'];
        $email  = $userDetails['User']['username'];
        $frg_wallet  = $userDetails['User']['frg_wallet'];
          
        $this->set(compact('fname','lname','email','frg_wallet'));
        
        if($this->request->is('post') && !empty($this->request->data)){
            $fname = $this->request->data['fname'];
            $lname = $this->request->data['lname'];
            $frg_wallet = $this->request->data['frg_wallet'];
            
            $db = $this->User->getDataSource();
                $fname = $db->value($fname, 'string');
                $lname = $db->value($lname, 'string');
                $frg_wallet = $db->value($frg_wallet, 'string');
                $this->User->updateAll(
                    array('User.first_name'=>$fname,
                          'User.last_name'=>$lname,
                          'User.frg_wallet'=>$frg_wallet
                         ),
                    array('User.id' => $user_id)
                );
            $this->Session->setFlash("Your setting have been Saved!", 'default', array('class' => 'message'));
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard_settings'));
        }  
        
	}
    
      public function dashboard_security() {
		$user_id = $this->Auth->User('id'); 
           $fa2object=[];
        if($this->Auth->User('2fa')==0){
            require_once(APP . 'Vendor' . DS. 'oauth'.DS.'rfc6238.php');
            $fa2object['secret']=$secret = TokenAuth6238::generateRandomClue(32);
             $fa2object['barcode']= TokenAuth6238::getBarCodeUrl('','',$secret,'ForgeNetwork');
            if($this->request->is('post') && !empty($this->request->data)){
             // require_once(APP . 'Vendor' . DS. 'oauth'.DS.'rfc6238.php');
                $currentcode = $this->request->data['currentcode'];
                $secret = $this->request->data['secret'];
                
               if (TokenAuth6238::verify($secret,$currentcode)) {
                   $db = $this->User->getDataSource();
                    $secret1 = $db->value($secret, 'string');
                    $this->User->updateAll(
                        array('User.2fa' => 1,'User.2fa_secret'=>$secret1),
                        array('User.id' => $user_id)
                    );
                    $this->Session->write('Auth.User.2fa', 1);
                    $this->Flash->Success(__('2FA Activated!'));   
                   return $this->redirect(array('controller'=>'users','action' => 'dashboard_security'));
                   
	           } else {
		          $this->Flash->success(__('Invalid code!'));
	           }
          }
        }elseif($this->Auth->User('2fa')==1){
            $this->Flash->success(__('2FA has  been Activated contact support if you need further assistance with 2FA'));         
        }
          
          
         $this->set(compact('fa2object')); 
	}
    
    public function resetpassword () {

        
        if ($this->request->is('post') && !empty($this->request->data)) {
            $email=$this->request->data['email'];
            $userDetails = $this->User->find('first',array('conditions'=>array('User.username'=>$email)));
            if(!empty($userDetails)){
                $user_id = $userDetails['User']['id'];
                require_once(APP . 'Vendor' . DS. 'genpwd'. DS. 'genpwd.php');
                $resetkey= genpwd(30);
                $db = $this->User->getDataSource();
                    $resetkey1 = $db->value($resetkey, 'string');
                     $this->User->updateAll(
                        array('User.reset_password' => $resetkey1),
                        array('User.id' => $user_id)
                    );
                $subject = "Reset Password";
                $messge = '<html><p>Hi,</p><p>Click <a href="'.SITEPATH.'users/new_password/'.$user_id.'/'.$resetkey.'">here</a> to reset your password</p><p>or copy and paste the URL below into your browser window</p><p>'.SITEPATH.'users/new_password/'.$user_id.'/'.$resetkey.'</p></html>';
                $this->sendMail($email,$subject,$messge);
                $this->Flash->error(__("We've sent an e-mail with instructions on how to reset your password."));
            }else{
                $this->Flash->error(__('The email you supplied is not registered'));
            }
        }
        
        $this->set(compact('days','result'));
	}
    
    
    
    public function login() {
   $this->Auth->logout();
        if ($this->request->is('post') && !empty($this->request->data)) {
          if(!empty($_POST['g-recaptcha-response'])){
            $captcha = $this->recaptcha($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            }else{$captcha=false;}
            if($captcha){
            if ($this->Auth->login()){
             
                if($this->Auth->User('2fa')==1){
                     $this->Session->write('oauth.username', $this->request->data['User']['username']);
                     $this->Session->write('oauth.pass', $this->request->data['User']['password']);
                     $this->Session->write('oauth.secret', $this->Auth->User('2fa_secret'));
                    $this->Auth->logout();
                    return $this->redirect(['controller'=>'users','action'=>'confirm2fa']);
                }
                if($this->Auth->User('email_confirmed')==0){
                    $this->Auth->logout();
                    $this->Flash->error(__('You have not confirmed your email address'));
                    return $this->redirect(['controller'=>'users','action'=>'login']);
                }
               return $this->redirect(['controller'=>'users','action'=>'dashboard']);
            }else{
            $this->Flash->error(__('Invalid username or password, try again'));
            return $this->redirect(['controller'=>'users','action'=>'login']);
            
            }}
                        
           }
        }
	
    
    public function register() {
        $this->Auth->logout();
		 if ($this->request->is('post') && !empty($this->request->data)) {
            
             if(!empty($_POST['g-recaptcha-response'])){
            $captcha = $this->recaptcha($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            }else{$captcha=false;}
            
            if($captcha){
            
            $this->User->create();
            $this->request->data['User']['user_type_id']=2;
            $this->request->data['User']['2fa']=0;
            $this->request->data['User']['email_confirmed']=0;
            require_once(APP . 'Vendor' . DS. 'genpwd'. DS. 'genpwd.php');
            $this->request->data['User']['ref_id'] = genpwd();
            if($this->Session->check('referrer')){
                $referrer = $this->User->findByRef_id($this->Session->read('referrer'));
                $this->request->data['User']['referrer']=$referrer['User']['id'];
            }
            
            if ($this->User->save($this->request->data['User'])) {
                 
                    $ref_id=$this->request->data['User']['ref_id'];
                $email=$this->request->data['User']['username'];
                $fname=$this->request->data['User']['first_name'];
                $message= '<html><p>Hi '.$fname.'</p> <p>Click <a href="'.SITEPATH.'users/confirm_email/'.$ref_id.'">here</a> to verify your E-mail or copy and paste the URL below into your browser to confirm your E-mail</p> <p>https://shop.theforgenetwork.com/users/confirm_email/'.$ref_id.'</p></html>';
                $subject='Email verification';
                $this->sendMail($email,$subject,$message,$fname);
                     $this->Flash->error(__('Registration was successful, You need to confirm your e-mail to Proceed, please check your e-mail for further instructions'));
                    return $this->redirect(array('controller'=>'users','action' => 'register'));
            }
        $this->Flash->error(__('The user could not be saved. Please, try again.'));
        
           } else{
                $this->Session->setFlash('We could not verify that you are human');
            } 
            }
	}
    
    
   
    
    function admin_index() {
          if($this->request->is('post') && !empty($this->request->data)){
              if ($this->Auth->login()) {
                if($this->Auth->User('usertype_id')!=1){
                    $this->Auth->logout();
                    $this->Session->setFlash("You dont have permission to access admin area!", 'default', array('class' => 'message'));
                }   ;
                $this->redirect(array('controller' => 'users', 'action' => 'admin_dash','admin'=>1));
                } else {
                   $this->Session->setFlash("Wrong Username or Password!", 'default', array('class' => 'message'));
            $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
                }   
          }
        
    }
    
    function confirm_email($ref_id=NULL) {
        $this->autoRender = false;
          if(isset($ref_id)){
              $userDetails=$this->User->find('first',array('conditions'=>array('User.ref_id'=>$ref_id)));
              if(!empty($userDetails)){
                  if($userDetails['User']['email_confirmed']==1){
                      $this->Flash->error(__('Your e-mail has been previously confirmed, proceed to login'));
                    return $this->redirect(array('controller'=>'users','action' => 'login'));
                  }
                  $this->User->updateAll(
                        array('User.email_confirmed' => 1),
                        array('User.id' => $userDetails['User']['id'])
                    );
                  $this->Flash->error(__('Your e-mail has been confirmed, proceed to login'));
                    return $this->redirect(array('controller'=>'users','action' => 'login'));
              }else{
                  $this->Flash->error(__('Invalid Confirmation link'));
                return $this->redirect(array('controller'=>'users','action' => 'login'));
              }
                
          }else{
              $this->Flash->error(__('Invalid Confirmation link'));
                return $this->redirect(array('controller'=>'users','action' => 'login'));
          }
        
    }
    
    function admin_dash() {
        if($this->Auth->User('usertype_id')!=1){
                    $this->Auth->logout();
                    $this->Session->setFlash("You dont have permission to access admin area!", 'default', array('class' => 'message'));
                }   ;
        $users = $this->User->find('all');
        foreach($users as $key=>$user){
            if(!empty($users[$key]['User']['last_share'])){
            $cutime=new DateTime($users[$key]['User']['last_share']);
            $users[$key]['User']['last_share'] = $cutime->format("Y-m-d");
            $cutime = NULL;
            }
             $users[$key]['sum']=0;
            foreach($user['Post'] as $post){
                $users[$key]['sum'] += $post['earned'];
            }
        }
        $this->set(compact('users'));
        
        }
    
    function admin_userdet($userid=NULL) {
        if($this->Auth->User('usertype_id')!=1){
                    $this->Auth->logout();
                    $this->Session->setFlash("You dont have permission to access admin area!", 'default', array('class' => 'message'));
                };
        
        $shares = $this->Post->find('all',array('conditions'=>array('Post.user_id'=>$userid)));
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
        $this->set(compact('shares','user'));
        
        }
    
     function admin_logout() {
            $this->autoRender = false;
            $this->Auth->logout();
            $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));       
        
        }
     function logout() {
            $this->autoRender = false;
            $this->Auth->logout();
            $this->redirect(array('controller' => 'users', 'action' => 'index'));       
        
        }
    
    function checkEmail() {
        $this->autoRender = false;
        $email = $this->request->data['User']['username'];
        $count = $this->User->find('count', array('conditions' => array('User.username' => $email, 'User.user_type_id' => '2')));
        if ($count == 0) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }
    
    protected function recaptcha($response = NULL, $remoteadr=NULL){ 
    $this->autoRender = false;
    if(isset($response)){
        $captcha = $response;
 
        $postdata = http_build_query(
            array(
                'secret'   => RC_SECRET,
                'response' => $captcha,
                'remoteip' => $remoteadr
            )
        );
 
        $options = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
 
        $context = stream_context_create($options);
        $result  = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context));
 
        return $result->success;
    }else{
        return false;
    }
} 
    protected function sendMail($recipient=NULL,$subject=NULL,$message=NULL,$name=''){ 
        require APP . 'Vendor' . DS. 'autoload.php';
        
        $mgClient = new Mailgun\Mailgun(MG_SECRET);
        $domain = "ico.theforgenetwork.com";

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain, array(
            'from'    => 'ForgeNetwork <postmaster@ico.theforgenetwork.com>',
            'to'      => $name.' <'.$recipient.'>',
            'subject' => $subject,
            'html'    => $message
        ));
        return $result;
    
    }
    
    public function get_rates(){
        $this->autoRender = false;
        require(APP.'Vendor'.DS.'coinpayments'. DS.'coinpayments.inc.php');
        $cps = new CoinPaymentsAPI();
	   $cps->Setup(CP_SECRET, CP_PUB);
        $result = $cps->GetRates();
	if ($result['error'] == 'ok') {
        //return $result;
		$btcltc=$result['result']['LTC']['rate_btc'];
		$btceth=$result['result']['ETH']['rate_btc'];
		$btcdoge=$result['result']['DOGE']['rate_btc'];
		$btcbch=$result['result']['BCH']['rate_btc'];
        $this->Feed->updateAll(
                    array('Feed.feed' => $btceth),
                    array('Feed.title' => 'btceth')
        );
        $this->Feed->updateAll(
                    array('Feed.feed' => $btcdoge),
                    array('Feed.title' => 'btcdoge')
        );
        $this->Feed->updateAll(
                    array('Feed.feed' => $btcltc),
                    array('Feed.title' => 'btcltc')
        );
        $this->Feed->updateAll(
                    array('Feed.feed' => $btcbch),
                    array('Feed.title' => 'btcbch')
        );
    }
    }
    
    public function get_usdrate(){
        $this->autoRender = false;
            $productionserve = 'https://api.coinmarketcap.com/v1/ticker/bitcoin/';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $productionserve);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

           // curl_setopt($ch, CURLOPT_POST, TRUE);

            $response = curl_exec($ch);
            //$cerror = curl_error($ch);
            curl_close($ch);
            $response = json_decode($response);
           $usdRate = $response[0]->price_usd;
          if(!empty($usdRate)){
               //$db = $this->Feed->getDataSource();
                //$secret1 = $db->value($secret, 'string');
                $this->Feed->updateAll(
                    array('Feed.feed' => $usdRate),
                    array('Feed.title' => 'usdrate')
                );
		      //return $usdRate;
              
          }
  
    }
    
    function confirm2fa() {
		
        if($this->request->is('post')){
           if (!empty($this->request->data)) {
                $username = $this->Session->read('oauth.username');
                $password = $this->Session->read('oauth.pass');
                $oath_secret = $this->Session->read('oauth.secret');
                require_once(APP . 'Vendor' . DS. 'oauth'.DS.'rfc6238.php');
                $currentcode = $this->request->data['currentcode'];
               if (TokenAuth6238::verify($oath_secret,$currentcode)) {
                   
		          $this->request->data['User']['username']=$username;
		          $this->request->data['User']['password']=$password;
                   if ($this->Auth->login()){
                       $this->Session->delete('oauth');
                       return $this->redirect(['controller'=>'users','action'=>'dashboard']);
                   }
                   
                   
	           } else {
		          $this->Flash->error(__('Invalid 2FA code'));
	           }
           }
        }
    }
    
    public function generateAddress($currency){
        
        require(APP.'Vendor'.DS.'coinpayments'. DS.'coinpayments.inc.php');
        $cps = new CoinPaymentsAPI();
        $cps->Setup(CP_SECRET, CP_PUB);

        $ipn_url = 'https://shop.theforgenetwork.com/ipn_handler';
       
        $result = $cps->GetCallbackAddress($currency,$ipn_url);
        
        if ($result['error'] == 'ok') {
            //$response=json_encode($result['result']);
            return $result['result'];
           // exit;
//            $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
//            print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
//            print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
//            print 'Status URL: '.$result['result']['status_url'].$le;
//        } else {
//            print 'Error: '.$result['error']."\n";
        }
    }
    
     public function ipn_handler(){
          $this->autoRender = false;
        $cp_merchant_id = MERCHANT_ID;
        $cp_ipn_secret = IPN_SECRET;
        $cp_debug_email = 'info@theforgenetwork.com';

        

        function errorAndDie($error_msg) {
            global $cp_debug_email;
            if (!empty($cp_debug_email)) {
                $report = 'Error: '.$error_msg."\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                }
                $this->sendMail($cp_debug_email, 'CoinPayments IPN Error', $report);
            }
            die('IPN Error: '.$error_msg);
        }

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            errorAndDie('IPN Mode is not HMAC');
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            errorAndDie('No HMAC signature sent.');
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            errorAndDie('Error reading POST data');
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            errorAndDie('No or incorrect Merchant ID passed');
        }

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
        //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
            errorAndDie('HMAC signature does not match');
        }

        // HMAC Signature verified at this point, load some variables.

        $txn_id = $_POST['txn_id'];
        $address = $_POST['address'];
        $confirms = intval($_POST['confirms']);
        $amount = floatval($_POST['amount']);
        $currency = $_POST['currency'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];

        //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

        // Check the original currency to make sure the buyer didn't change it.
         switch ($currency) {
            case 'ETH':
                $feedtitle='btceth';
                break;
            case 'BTC':
                $feedtitle='usdrate';
                break;
            case 'LTC':
                $feedtitle='btclltc';
                break;
            case 'BCH':
                $feedtitle='btcbch';
                break;
            case 'DOGE':
                $feedtitle='btcdoge';
                break;
        }

        $wallet = $this->Wallet->find('first',['conditions'=>['Wallet.currency'=>$currency,'Wallet.address'=>$address]]);
         $checkTxn = $this->Transaction->find('first',['conditions'=>['Transaction.txn_id'=>$txn_id]]);
         
        if(!empty($wallet) && empty($checkTxn)){
            
            $wallet_id = $wallet['Wallet']['id'];
            $user_id = $wallet['Wallet']['user_id'];
        
            $txn_array=[
                "user_id"=>$user_id,
                "wallet_id"=>$wallet_id,
                "amount"=>$amount,
                "txn_id"=>$txn_id,
                "confirms"=>$confirms,
                "status"=>$status
            ];
            
            if($status >= 100 || $status==2){
                $btcrate = $this->Feed->find('first',['conditions'=>['Feed.title'=>'usdrate']]);
                $ourrate = $this->Feed->find('first',['conditions'=>['Feed.title'=>'current_price']]);
                $feeds=$this->Feed->find('first',['conditions'=>['Feed.title'=>$feedtitle]]);
                if($feedtitle != 'usdrate'){
                    $cryptrate=$feeds['Feed']['feed']*$btcrate['Feed']['feed'];
                }else{
                    $cryptrate=$btcrate['Feed']['feed'];
                }
                
                $txn_array['frg_amount'] = round($amount*$cryptrate/$ourrate['Feed']['feed'], 2);
                $txn_array['conversion_rate'] = $cryptrate;
                
            }
            if($this->Transaction->save($txn_array)){
                
            }else{
                errorAndDie('Unable to Save');
            };
        }elseif(!empty($wallet) && !empty($checkTxn)){
            $transaction_id=$checkTxn['Transaction']['id'];
            $astat = $checkTxn['Transaction']['status'];
            if($status != $astat){
                if($status>=100 || $status==2){
                    $btcrate = $this->Feed->find('first',['conditions'=>['Feed.title'=>'usdrate']]);
                    $ourrate = $this->Feed->find('first',['conditions'=>['Feed.title'=>'current_price']]);
                    $feeds=$this->Feed->find('first',['conditions'=>['Feed.title'=>$feedtitle]]);
                    if($feedtitle != 'usdrate'){
                        $cryptrate=$feeds['Feed']['feed']*$btcrate['Feed']['feed'];
                    }else{
                        $cryptrate=$btcrate['Feed']['feed'];
                    }

                    $frg_amount= round($amount*$cryptrate/$ourrate['Feed']['feed'],2);
                    $conversion_rate = $cryptrate;
                    $db = $this->Transaction->getDataSource();
                    $frg_amount = $db->value($frg_amount, 'string');
                    $conversion_rate = $db->value($conversion_rate, 'string');
                     $this->Transaction->updateAll(
                        array('Transaction.status' => $status,'Transaction.confirms' => $confirms,'Transaction.conversion_rate'=>$conversion_rate,'Transaction.frg_amount'=>$frg_amount),
                        array('Transaction.id' => $transaction_id)
                    );

                }else{
                
                    $this->Transaction->updateAll(
                        array('Transaction.confirms' => $confirms,'Transaction.status' => $status),
                        array('Transaction.id' => $transaction_id)
                    );
                }
            }
        }
        die('IPN OK'); 

        }
    
    public function new_password($user_id=NULL, $r_key=NULL) {
        $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        if(!empty($userDetails)){
            $mkey=$userDetails['User']['reset_password'];
            $email=$userDetails['User']['username'];
            if($r_key != $mkey){
                $this->Flash->error(__('Invalid link'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
            }
        }else{
            $this->Flash->error(__('Invalid link'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
        }
        if($this->request->is('post') && !empty($this->request->data)){
            $newpwd=$this->request->data['password'];
            require_once(APP . 'Vendor' . DS. 'genpwd'. DS. 'genpwd.php');
                $nresetkey= genpwd(30);
            $userDetails['User']['password']=$newpwd;
            $userDetails['User']['reset_password']=$nresetkey;
            if($this->User->save($userDetails['User'])){
                $this->Flash->error(__('Password changed! Continue with login'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
            }
            $this->Flash->error(__('Something went wrong'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
        }
        
        $this->set(compact('user_id','r_key','email'));
	}
}
