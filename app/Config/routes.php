<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'users', 'action' => 'index'));
	Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/dashboard', array('controller' => 'users', 'action' => 'dashboard'));
	Router::connect('/resetpassword', array('controller' => 'users', 'action' => 'resetpassword'));
	Router::connect('/dashboard_transactions', array('controller' => 'users', 'action' => 'dashboard_transactions'));
	Router::connect('/dashboard_settings', array('controller' => 'users', 'action' => 'dashboard_settings'));
	Router::connect('/dashboard_security', array('controller' => 'users', 'action' => 'dashboard_security'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/ipn_handler', array('controller' => 'users', 'action' => 'ipn_handler'));
	Router::connect('/get_rates', array('controller' => 'users', 'action' => 'get_rates'));
	Router::connect('/get_usdrate', array('controller' => 'users', 'action' => 'get_usdrate'));
	
	//Router::connect('/generate_address/**', array('controller' => 'users', 'action' => 'generate_address'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

Router::connect('/admin', array('controller' => 'users', 'action' => 'index','admin'=>1));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
