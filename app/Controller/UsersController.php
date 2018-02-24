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
	public $uses = array('User','Feed','Wallet','Transaction','Val','Refearning');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function index() {
		$total = $this->Val->find('first',array('conditions'=>array('Val.title'=>'total')));
        $total=$total['Val']['val'];
        $total = number_format($total);
        $this->set(compact('total'));
	}
    
    
    public function dashboard() {
		//return $this->redirect(array('controller'=>'users','action' => 'dashboard_transactions'));
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
        $wallets = $this->Wallet->find('all',array('conditions'=>array('Wallet.user_id'=>$user_id)));
        $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        $fname=$userDetails['User']['first_name'];
        $ref_id=$userDetails['User']['ref_id'];
       // $usdRate = $this->getRates();
        if($this->request->is('post') && !empty($this->request->data)){
            $amount=abs($this->request->data['Wallet']['amount']);
            if($amount==0){$amount=NULL;};
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
                    $wallets = $this->Wallet->find('all',array('conditions'=>array('Wallet.user_id'=>$user_id)));
                     $this->Flash->Success(__('Successfully generated your personal '.$currency.' address. Send funds to this address (see step 2) to claim your FRG!'));
                }else{
                    $this->Flash->error(__('Unable to generate an address. Please try again. If this problem persists, please contact an FRG team member.'));
                }
            }else{
                $address=$userWallet['Wallet']['address'];
                $this->Flash->Success(__('Successfully generated your personal '.$currency.' address. Send funds to this address (see step 2) to claim your FRG!'));
            }
            
        }
        $this->set(compact('days','prices','address','currency','amount','wallets','fname','ref_id'));
	}
    
    public function dashboard_transactions() {
		$user_id = $this->Auth->User('id'); 
        $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        $fname=$userDetails['User']['first_name'];
         $txns = $this->Transaction->find('all',array('conditions'=>array('Transaction.user_id'=>$user_id)));
        if(!empty($txns)){
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
            
            /*switch ($txn['Wallet']['currency']) {
                case 'ETH':
                    $min=0.04;
                    break;
                case 'BTC':
                    $min=0.0035;
                    break;
                case 'LTC':
                    $min=0.23;
                    break;
                case 'BCH':
                    $min=0.023;
                    break;
                case 'DOGE':
                    $min=6200;
                    break;
            }
            if($txn['Transaction']['amount']<$min){
                unset($txns[$key]);
            }*/
        }
        
        }
        $refs = $this->Refearning->find('all',array('conditions'=>array('Refearning.user_id'=>$user_id)));
        if(!empty($refs)){
            $refearn=0;
            foreach ($refs as $rkey=>$ref){
                $refearn += $ref['Refearning']['earning'];
                $rctime=new DateTime($refs[$rkey]['Refearning']['created']);
                $refs[$rkey]['Refearning']['created'] = $rctime->format("Y-m-d");

            }
        }
        
        $this->set(compact('txns','earned','fname','refs','refearn'));
        
	}
    
      public function dashboard_settings() {
		$user_id = $this->Auth->User('id');
        $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        $fname = $userDetails['User']['first_name'];
        $lname = $userDetails['User']['last_name'];
        $email  = $userDetails['User']['username'];
        $frg_wallet  = $userDetails['User']['frg_wallet'];
        $ref_id = $userDetails['User']['ref_id'];
          
        $this->set(compact('fname','lname','email','frg_wallet','ref_id'));
        
        if($this->request->is('post') && !empty($this->request->data)){
            $fname = $this->request->data['fname'];
            $lname = $this->request->data['lname'];
            $frg_wallet = $this->request->data['frg_wallet'];
            if(!empty($this->request->data['frg_wallet'])){
            if (preg_match("/^F[0-9a-zA-Z]{33}$/", $this->request->data['frg_wallet'])) {
            } else {
                $this->Flash->error(__('Invalid FRG address'));
                return $this->redirect(array('controller'=>'users','action' => 'dashboard_settings'));
            }}else{
                 $frg_wallet=NULL;
             }
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
            $this->Flash->Success("Your settings have been saved.");
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard_settings'));
        }  
        
	}
    
      public function dashboard_security() {
          $user_id = $this->Auth->User('id');
          $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
        $fname=$userDetails['User']['first_name'];
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
                   return $this->redirect(array('controller'=>'users','action' => 'dashboard_security'));
                   
	           } else {
		          $this->Flash->error(__('Invalid code. The code may have been expired; please try again.'));
	           }
          }
        }elseif($this->Auth->User('2fa')==1){
            $this->Flash->success(__('Two-factor authentication is activated. Contact support if you need further assistance.'));
        }
          
          
         $this->set(compact('fa2object','fname')); 
	}
    
    public function resetpassword () {

        
        if ($this->request->is('post') && !empty($this->request->data)) {
            if(!empty($_POST['g-recaptcha-response'])){
            $captcha = $this->recaptcha($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            }else{$captcha=false;}
            if($captcha){
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
                $basePath = SITEPATH;
                $message = <<<HTML
<p>Hi,</p>
<p>Click <a href='{$basePath}users/new_password/{$user_id}/{$resetkey}'>here</a> to reset your password.</p>
<p>Or copy and paste the URL below into your browser window.</p>
<p>{$basePath}users/new_password/{$user_id}/{$resetkey}</p>
HTML;

                $this->sendMail($email, $subject, $message);
                $this->Flash->success(__("We've sent an e-mail with instructions on how to reset your password. Be sure to check spam/junk folder if our e-mail is not  in inbox!"));
                return $this->redirect(['controller'=>'users','action'=>'resetpassword']);
                
            }else{
                $this->Flash->error(__('The e-mail address you supplied is not registered.'));
            }
        }else{
                $this->Flash->error('We could not verify that you are human.');
                return $this->redirect(['controller'=>'users','action'=>'resetpassword']);
            } }
        
        $this->set(compact('days','result'));
	}
    
    
    
    public function login() {
   if(!empty($this->Auth->User('id'))){
       return $this->redirect(['controller'=>'users','action'=>'dashboard']);
   }
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
                    $this->Flash->error(__('You have not confirmed your e-mail address. Check your e-mail for further instructions.'));
                    return $this->redirect(['controller'=>'users','action'=>'login']);
                }
               return $this->redirect(['controller'=>'users','action'=>'dashboard']);
            }else{
            $this->Flash->error(__('Invalid username or password, try again.'));
            return $this->redirect(['controller'=>'users','action'=>'login']);
            
            }}
                        
           }
        }
	
    
    public function register($referrer=NULL) {
        if(!empty($this->Auth->User('id'))){
       return $this->redirect(['controller'=>'users','action'=>'dashboard']);
   }
        if(isset($referrer)){
            $this->Session->write('referrer',$referrer);
        }
        $this->set(compact('referrer'));
		 if ($this->request->is('post') && !empty($this->request->data)) {
             if(!empty($this->request->data['User']['frg_wallet'])){
            if (preg_match("/^F[0-9a-zA-Z]{33}$/", $this->request->data['User']['frg_wallet'])) {
            } else {
                $this->Flash->error(__('Invalid FRG address'));
                return $this->redirect(array('controller'=>'users','action' => 'register'));
            }}else{
                 $this->request->data['User']['frg_wallet']=NULL;
             }
             $exUser=$this->User->find('first',array('conditions'=>array('User.username'=>$this->request->data['User']['username'])));
             if(!empty($exUser)){
                 $this->Flash->error(__('Email is taken!'));
                return $this->redirect(array('controller'=>'users','action' => 'register'));
             }
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
                if(!empty($referrer)){
                    $this->request->data['User']['referrer']=$referrer['User']['id'];
                }else{
                    $this->Session->delete('referrer');
                    $this->Flash->error(__('Invalid referral link! Use https://shop.theforgenetwork.com/register to register or obtain correct referral link from your referrer'));
                    return $this->redirect(array('controller'=>'users','action' => 'register'));
                }
            }
            
            if ($this->User->save($this->request->data['User'])) {
                $ref_id=$this->request->data['User']['ref_id'];
                $email=$this->request->data['User']['username'];
                $fname=$this->request->data['User']['first_name'];
                $basePath = SITEPATH;
                $message = <<<HTML
<p>Hi {$fname}.</p>
<p>Click <a href='{$basePath}users/confirm_email/{$ref_id}'>here</a> to verify your E-mail or copy and paste the URL below into your browser to confirm your E-mail</p>
<p>https://shop.theforgenetwork.com/users/confirm_email/{$ref_id}</p>
HTML;

                $subject='Email verification';
                $this->sendMail($email,$subject,$message,$fname);
                $this->Flash->success(__('Registration was successful. You need to confirm your e-mail to proceed. Please check your e-mail for further instructions. Be sure to check spam/junk folder if our e-mail is not  in inbox!'));
                return $this->redirect(array('controller'=>'users','action' => 'register'));
            }
        $this->Flash->error(__('The user could not be saved. Please, try again. If the problem persists, please contact an FRG team member.'));
        
           } else{
                $this->Flash->error('We could not verify that you are human.');
            } 
            }
	}
    
    
   
    
    function admin_index() {
          if($this->request->is('post') && !empty($this->request->data)){
              if ($this->Auth->login()) {
                if($this->Auth->User('user_type_id')!=1){
                    $this->Auth->logout();
                    $this->Flash->error("You don't have permission to access this area.", 'default', array('class' => 'message'));
                   return $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
                }   ;
                $this->redirect(array('controller' => 'users', 'action' => 'admin_dash','admin'=>1));
                } else {
                   $this->Flash->error("Invalid username or password. Please try again.");
            $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
                }   
          }
        
    }
    
    function admin_login() {
          $this->autoRender = false;
        return $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
        
        
    }
    
    function confirm_email($ref_id=NULL) {
        $this->autoRender = false;
          if(isset($ref_id)){
              $userDetails=$this->User->find('first',array('conditions'=>array('User.ref_id'=>$ref_id)));
              if(!empty($userDetails)){
                  if($userDetails['User']['email_confirmed']==1){
                      $this->Flash->error(__('Your e-mail address has been confirmed, proceed to login.'));
                    return $this->redirect(array('controller'=>'users','action' => 'login'));
                  }
                  $this->User->updateAll(
                        array('User.email_confirmed' => 1),
                        array('User.id' => $userDetails['User']['id'])
                    );
                  $this->Flash->success(__('Your e-mail address has been confirmed, proceed to login.'));
                    return $this->redirect(array('controller'=>'users','action' => 'login'));
              }else{
                  $this->Flash->error(__('Invalid confirmation link. It may have been expired. Please try again.'));
                return $this->redirect(array('controller'=>'users','action' => 'login'));
              }
                
          }else{
              $this->Flash->error(__('Invalid confirmation link. It may have been expired. Please try again.'));
                return $this->redirect(array('controller'=>'users','action' => 'login'));
          }
        
    }
    
    function admin_dash() {
        if($this->Auth->User('user_type_id')!=1){
                    $this->Auth->logout();
                    $this->Session->setFlash("You dont have permission to access admin area!", 'default', array('class' => 'message'));
            return $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
                }   ;
        $order = array('User.id' => 'ASC');
        $this->paginate = array(
             'order' => $order,
             'limit' => 25
         );
        $total = $this->User->find('count');
        $users = $this->paginate('User');
        foreach($users as $key=>$user){
             $users[$key]['sum']=0;
            foreach($user['Transaction'] as $transaction){
                if(!empty($transaction['frg_amount'])){
                    $users[$key]['sum'] += $transaction['frg_amount'];
                }
            }
        }
        $this->set(compact('users','total'));
        
        }
    
    function admin_transaction() {
        if($this->Auth->User('user_type_id')!=1){
                    $this->Auth->logout();
                    $this->Session->setFlash("You dont have permission to access admin area!", 'default', array('class' => 'message'));
            return $this->redirect(array('controller' => 'users', 'action' => 'index','admin'=>1));
                }   ;
        $order = array('User.id' => 'ASC');
        $this->paginate = array(
             'order' => $order,
             'limit' => 25
         );
        $total = $this->Transaction->find('count');
        $users = $this->paginate('Transaction');
        foreach($users as $key=>$txn){
            $ctime=new DateTime($users[$key]['Transaction']['created']);
            $users[$key]['Transaction']['created'] = $ctime->format("Y-m-d");
            $status = $users[$key]['Transaction']['status'];
            if ($status >= 100 || $status == 2) {
                $users[$key]['Transaction']['status']='Completed';
            } else if ($status < 0) {
                $users[$key]['Transaction']['status']='Error';
            } else {
                $users[$key]['Transaction']['status']='Pending';
            }
            
            
        }
        $this->set(compact('users','total'));
        
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
    protected function sendjjj($recipient=NULL,$subject=NULL,$message=NULL,$name=''){ 
        require APP . 'Vendor' . DS. 'autoload.php';
        
        $mgClient = new Mailgun\Mailgun(MG_SECRET);
        $domain = "mail.theforgenetwork.com";

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain, array(
            'from'    => 'ForgeNetwork <shop@theforgenetwork.com>',
            'to'      => $name.' <'.$recipient.'>',
            'h:reply-to' => 'ForgeNetwork Support <support@theforgenetwork.com>',
            'subject' => $subject,
            'text'    => $message
        ));
        return $result;
    
    } 
    
     protected function sendMail($recipient=NULL,$subject=NULL,$message=NULL,$name=''){ 
        require APP . 'Vendor' . DS. 'autoload.php';
        
        $toEmailAddress = $recipient;
        $content = $message;

        $transporter = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
        $transporter
            ->setUsername(G_UN)
            ->setPassword(G_PWD);

        $mailer = new Swift_Mailer($transporter);

        $message = new Swift_Message($subject);
        $message
            ->setFrom([G_UN => 'ForgeNet Support'])
            ->setTo($toEmailAddress)
            ->setBody($content, 'text/html');

        $mailer->send($message);
         
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
                die;

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
                die;

    }
    
    function confirm2fa() {
		if($this->Session->check('oauth.username') && $this->Session->check('oauth.pass') && $this->Session->check('oauth.secret')){
            
        }else{
            $this->Flash->error(__('Oops! Wrong turn!'));
            return $this->redirect(['controller'=>'users','action'=>'login']);
        }
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
		          $this->Flash->error(__('Invalid two-factor authentication code. It may have been expired. Please try again.'));
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
                $feedtitle='btcltc';
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
                $refdets = $this->Refearning->find('first',['conditions'=>['Refearning.transaction_id'=>$txn_id]]);
                if(empty($refdets)){
                    $user_id = $wallet['Wallet']['user_id'];
                    $referee = $this->User->find('first',['conditions'=>['User.id'=>$user_id]]);
                    $referrer_id = $referee['User']['referrer'];
                    $refident = $referee['User']['username'];
                    if(isset($referrer_id)){
                        $refearn = 0.14*$frg_amount;
                        $refearn= round($refearn,2);
                        $ref_array=[
                            "user_id"=>$referrer_id,
                            "earning"=>$refearn,
                            "referee"=>$refident,
                            "transaction_id"=>$txn_id
                        ];
                        $this->Refearning->save($ref_array);
                    }   
                }
                
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
                    $refdets = $this->Refearning->find('first',['conditions'=>['Refearning.transaction_id'=>$txn_id]]);
                    if(empty($refdets)){
                        $user_id = $wallet['Wallet']['user_id'];
                        $referee = $this->User->find('first',['conditions'=>['User.id'=>$user_id]]);
                        $referrer_id = $referee['User']['referrer'];
                        $refident = $referee['User']['username'];
                        if(isset($referrer_id)){
                            $refearn = 0.14*$frg_amount;
                            $refearn= round($refearn,2);
                            $ref_array=[
                                "user_id"=>$referrer_id,
                                "earning"=>$refearn,
                                "referee"=>$refident,
                                "transaction_id"=>$txn_id
                            ];
                            $this->Refearning->save($ref_array);
                        }   
                    }

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
                $this->Flash->error(__('Invalid link.'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
            }
        }else{
            $this->Flash->error(__('Invalid link.'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
        }
        if($this->request->is('post') && !empty($this->request->data)){
            $newpwd=$this->request->data['password'];
            require_once(APP . 'Vendor' . DS. 'genpwd'. DS. 'genpwd.php');
                $nresetkey= genpwd(30);
            $userDetails['User']['password']=$newpwd;
            $userDetails['User']['reset_password']=$nresetkey;
            if($this->User->save($userDetails['User'])){
                $this->Flash->success(__('Password changed. You can now login with your new password.'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
            }
            $this->Flash->error(__('Unable to save your new user details. Please try again. If this problem persists, please contact support.'));
                return $this->redirect(['controller'=>'users','action'=>'login']);
        }
        
        $this->set(compact('user_id','r_key','email'));
	}
    
    public function total_amount() {
        $this->autoRender = false;
        $txns = $this->Transaction->find('all');
        $sum=0;
        if(!empty($txns)){
            foreach($txns as $txn){
                if(isset($txn['Transaction']['conversion_rate'])){
                    $rate = $txn['Transaction']['conversion_rate'];
                    $amount = $txn['Transaction']['amount'];
                    $sum += $rate*$amount;
                }
            }
            $sum = round($sum);
            $sum = $sum + WHALE_MONEY;
            $this->Val->updateAll(
                        array('Val.val' => $sum),
                        array('Val.title' => 'total')
                    );
            
        }
        die;
	}
    
    
}
