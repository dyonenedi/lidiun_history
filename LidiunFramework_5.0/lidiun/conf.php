<?php
	/**********************************************************
	* Lidiun PHP Framework 4.0 - (http://www.lidiun.com)
	*
	* @Created in 26/08/2013
	* @Author  Dyon Enedi <dyonenedi@hotmail.com>
	* @Modify in 04/08/2014
	* @By Dyon Enedi <dyonenedi@hotmail.com>
	* @Contributor Gabriela A. Ayres Garcia <gabriela.ayres.garcia@gmail.com>
	* @Contributor Rodolfo Bulati <rbulati@gmail.com>
	* @License: free
	*
	**********************************************************/
	
	namespace Lidiun;
	
	class Conf
	{
		public static $_conf;
		
		public function init($conf){
			self::$_conf = $conf;

			// Set time zone
			date_default_timezone_set(self::$_conf['preset']['timezone']);

			// Set domain and local server
			$dominio = $_SERVER['HTTP_HOST'];
			if ($dominio != self::$_conf['preset']['domain']) {
				if (explode('.', $dominio)) {
					$dominio = explode('.', $dominio);
					unset($dominio[0]);
					$dominio = implode($dominio, '.');
				}
			}

			if (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
				self::$_conf['preset']['local_server'] = 'local';
			} elseif (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
				self::$_conf['preset']['local_server'] = 'local';
			} elseif ($dominio == self::$_conf['preset']['domain']) {
				self::$_conf['preset']['local_server'] = 'production';
			} elseif ($dominio == self::$_conf['preset']['domain']) {
				self::$_conf['preset']['local_server'] = 'statement';
			} else {
				throw new \Exception('I can\'t carry on with domain "'.$dominio.'", without the settings of the local server in: '.__FILE__.' on line: '.__LINE__);
			}

			// Set preset
			self::$_conf['preset']['copyright'] = '© '.date('Y').' '.self::$_conf['preset']['app_name'];
			self::$_conf['preset']['debug'] = (self::$_conf['preset']['local_server'] == 'production') ? false : true;
			self::$_conf['path']['dif_root_x_public_path'] = (!empty(self::$_conf['path']['dif_root_x_public_path'])) ? str_replace(' ', '/', trim(str_replace('/', ' ', self::$_conf['path']['dif_root_x_public_path']))) : false;
			
			// Set support redirect
			if (self::$_conf['preset']['support']) {
				Redirect::support();		
			}

			// Start session
			session_start();
			
			session_set_cookie_params( 
			    Conf::$_conf['preset']['cookie_lifetime'], 
			    Conf::$_conf['preset']['cookie_path'], 
			    '.'.Request::$_url['domain'], 
			    Conf::$_conf['preset']["cookie_secure"], 
			    Conf::$_conf['preset']["cookie_httponly"]
			);
		}
	}