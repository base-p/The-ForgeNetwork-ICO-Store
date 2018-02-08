<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
   public $components = array('Cookie','Session','Flash',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'users',
                'action' => 'dashboard'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'index'
            ),
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'fields'=>['username'=>'username',
                    'password'=>'password']
                )
            ),
        )
    );
  
    
    public function beforeFilter() {
        parent::beforeFilter();  
       $this->Cookie->name = 'userdet';
       $this->Cookie->time = 3600; // or '1 hour'
        $this->Cookie->key = 'qSI232qs*&sXOw!obum@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
//       $this->Cookie->httpOnly = true;
       $this->Cookie->type('aes');
        $this->Auth->allow('index','resetpassword','logout','register','login','admin_index','regadmin','confirm_email','checkEmail','recaptcha','sendMail','get_rates','get_usdrate','confirm2fa','ipn_handler','new_password','total_amount');
    }
}
