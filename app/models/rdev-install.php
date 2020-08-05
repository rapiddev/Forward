<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	use Mysqli;

	/**
	*
	* Model [Install]
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Model extends Models
	{	
		/**
		* Get
		* Get install form
		*
		* @access   private
		*/
		public function Get()
		{
			$this->InstallForm();
			exit;
		}

		/**
		* Post
		* Get install form
		*
		* @access   private
		*/
		public function Post()
		{
			$this->InstallForm();
			exit;
		}

		/**
		* InstallForm
		* Parse and verify install form
		*
		* @access   private
		*/
		private function InstallForm()
		{
			$result = array(
				'status' => 'error',
				'message' => 'Something went wrong!'
			);

			if (!isset(
				$_POST['action'],
				$_POST['input_scriptname'],
				$_POST['input_baseuri'],
				$_POST['input_db_name'],
				$_POST['input_db_user'],
				$_POST['input_db_host'],
				$_POST['input_db_password'],
				$_POST['input_user_name'],
				$_POST['input_user_password']
			))
			{
				$result['message'] = 'Missing fields';
				exit(json_encode($result));
			}

			if($_POST['action'] != 'setup')
			{
				$result['message'] = 'Inavlid action';
				exit(json_encode($result));
			}

			if(trim($_POST['input_user_name']) === '')
			{
				$result['message'] = 'User name empty';
				exit(json_encode($result));
			}

			if(trim($_POST['input_user_password']) === '')
			{
				$result['message'] = 'Password empty';
				exit(json_encode($result));
			}

			if(trim($_POST['input_db_name']) === '')
			{
				$result['message'] = 'DB name empty';
				exit(json_encode($result));
			}

			if(trim($_POST['input_db_user']) === '')
			{
				$result['message'] = 'DB user empty';
				exit(json_encode($result));
			}

			if(trim($_POST['input_db_host']) === '')
			{
				$result['message'] = 'DB host empty';
				exit(json_encode($result));
			}
			
			//error_reporting(0);
			$database = new Mysqli($_POST['input_db_host'], $_POST['input_db_user'], $_POST['input_db_password'], $_POST['input_db_name']);
			if ($database->connect_error)
			{
				$result['message'] = 'Unable to connect to database';
				exit(json_encode($result));
			}

			$this->BuildResources($database, array(
				'path' => filter_var($_POST['input_scriptname'], FILTER_SANITIZE_STRING),
				'db_name' => filter_var($_POST['input_db_name'], FILTER_SANITIZE_STRING),
				'db_host' => filter_var($_POST['input_db_host'], FILTER_SANITIZE_STRING),
				'db_user' => filter_var($_POST['input_db_user'], FILTER_SANITIZE_STRING),
				'db_pass' => $_POST['input_db_password'],
				'baseuri' => filter_var($_POST['input_baseuri'], FILTER_SANITIZE_STRING),
				'user_name' => filter_var($_POST['input_user_name'], FILTER_SANITIZE_STRING),
				'user_pass' => $_POST['input_user_password'],
			));

			$result['status'] = 'success';
			exit(json_encode($result));
		}

		/**
		* BuildResources
		* Creates config file and database tables
		*
		* @param	Mysqli $database
		* @param	array $args
		* @access   private
		*/
		private function BuildResources($database, $args) : void
		{
			$this->BuildHtaccess($args['path']);
			$this->BuildConfig($args);
			$this->BuildTables($database, $args);
		}

		/**
		* SetAlgo
		* Defines Password hash type
		*
		* @access   private
		* @return   void
		*/
		private function SetAlgo() : string
		{
			/** Password hash type */
			if(defined('PASSWORD_ARGON2ID'))
				return 'PASSWORD_ARGON2ID';
			else if(defined('PASSWORD_ARGON2I'))
				return 'PASSWORD_ARGON2I';
			else if(defined('PASSWORD_BCRYPT'))
				return 'PASSWORD_BCRYPT';
			else if(defined('PASSWORD_DEFAULT'))
				return 'PASSWORD_DEFAULT';
		}

		/**
		* BuildHtaccess
		* Creates a .htaccess file
		*
		* @access   private
		* @param	string $dir
		* @return   void
		*/
		private function BuildHtaccess(string $dir = '/') : void
		{
			if($dir == '/')
				$dir = '';

			$htaccess  = "";
			$htaccess .= "Options All -Indexes\n\n";
			$htaccess .= "<IfModule mod_rewrite.c>\n";
			$htaccess .= "RewriteEngine On\nRewriteBase /\nRewriteCond %{REQUEST_URI} ^(.*)$\nRewriteCond %{REQUEST_FILENAME} !-f\n";
			$htaccess .= "RewriteRule .* $dir/index.php [L]\n</IfModule>";

			$path = ABSPATH . '.htaccess';
			file_put_contents( $path, $htaccess );
		}

		/**
		* BuildConfig
		* Creates config file
		*
		* @access   private
		* @param	array $args
		* @return   void
		*/
		private function BuildConfig($args) : void
		{

			$config  = "";
			$config .= "<?php\n/**\n * @package Forward\n *\n * @author RapidDev\n * @copyright Copyright (c) 2019-2020, RapidDev\n * @link https://www.rdev.cc/forward\n * @license https://opensource.org/licenses/MIT\n */\n\tnamespace Forward;\n\tdefined('ABSPATH') or die('No script kiddies please!');";

			$config .= "\n\n\t/** Passwords hash type */\n\tdefine( 'FORWARD_ALGO', " . $this->SetAlgo() . " );";

			$config .= "\n\n\t/** Database table */\n\tdefine( 'FORWARD_DB_NAME', '" . $args['db_name'] . "' );";
			$config .= "\n\t/** Database table */\n\tdefine( 'FORWARD_DB_HOST', '" . $args['db_host'] . "' );";
			$config .= "\n\t/** Database table */\n\tdefine( 'FORWARD_DB_USER', '" . $args['db_user'] . "' );";
			$config .= "\n\t/** Database table */\n\tdefine( 'FORWARD_DB_PASS', '" . $args['db_pass'] . "' );";

			$config .= "\n\n\t/** Session salt */\n\tdefine( 'SESSION_SALT', '" . Crypter::DeepSalter(50) . "' );";
			$config .= "\n\t/** Passowrd salt */\n\tdefine( 'PASSWORD_SALT', '" . Crypter::DeepSalter(50) . "' );";
			$config .= "\n\t/** Nonce salt */\n\tdefine( 'NONCE_SALT', '" . Crypter::DeepSalter(50) . "' );";

			$config .= "\n\n\t/** Debugging */\n\tdefine( 'FORWARD_DEBUG', FALSE );";

			$config .= "\n\n?>\n";

			$path = APPPATH . 'config.php';
			file_put_contents( $path, $config );
		}

		/**
		* BuildTables
		* Creates database tables
		*
		* @access   private
		* @param	Mysqli $database
		* @param	array $args
		* @return   void
		*/
		private function BuildTables($database, $args) : void
		{
			$database->set_charset('utf8');

			$dbFile = file( APPPATH . 'system/rdev-database.sql' );
			$queryLine = '';

			// Loop through each line
			foreach ($dbFile as $line)
			{
				//Skip comments and blanks
				if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 1) == '#')
					continue;
				
				$queryLine .= $line;

				if (substr(trim($line), -1, 1) == ';')
				{
					$database->query($queryLine);
					$queryLine = '';
				}
			}

			$this->FillData($database, $args);
		}

		/**
		* BuildTables
		* Creates database tables
		*
		* @access   private
		* @param	Mysqli $db
		* @param	array $args
		* @return   void
		*/
		private function FillData($database, $args)
		{
			//$stmt = $db->prepare("SELECT * FROM myTable WHERE name = ? AND age = ?");

			require_once APPPATH . 'config.php';

			//Static
			$database->query("INSERT IGNORE INTO forward_options (option_name, option_value) VALUES " . 
				"('version', '" . FORWARD_VERSION . "'), " .
				"('site_name', 'Forward'),  " .
				"('site_description', 'Create your own link shortener'),  " .
				"('dashboard', 'dashboard'),  " .
				"('login', 'login'),  " .
				"('date_format', 'j F Y'), " .
				"('time_format', 'H:i'), " .
				"('charset', 'UTF8'), " .
				"('dashboard_links', '30'), " .
				"('dashboard_sort', 'date'), " .
				"('timezone', 'UTC'), " .
				"('cache', 'false'), " .
				"('dashboard_captcha', 'false'), " .
				"('dashboard_captcha_public', ''), " .
				"('dashboard_captcha_secret', ''), " .
				"('force_dashboard_ssl', 'false'), " .
				"('store_ip_addresses', 'true'), " .
				"('force_redirect_ssl', 'false'), " .
				"('non_existent_record', 'error404'), " .
				"('js_redirect_after', '2000'), " .
				"('js_redirect', 'false')"
			);

			$q1 = Crypter::BaseSalter(6);
			$q2 = Crypter::BaseSalter(6);
			$q3 = Crypter::BaseSalter(6);

			$database->query("INSERT IGNORE INTO forward_records (record_name, record_display_name, record_url) VALUES " . 
				"('" . strtolower( $q1 ) . "', '" . strtoupper( $q1 ) . "', 'https://github.com/rapiddev/Forward'), " .
				"('" . strtolower( $q2 ) . "', '" . strtoupper( $q2 ) . "', 'https://rdev.cc/'),  " .
				"('" . strtolower( $q3 ) . "', '" . strtoupper( $q3 ) . "', 'https://4geek.co/')"
			);

			//Binded
			if($query = $database->prepare("INSERT IGNORE INTO forward_options (option_name, option_value) VALUES ('base_url', ?)"))
			{
				$query->bind_param('s', $args['baseuri']);
				$query->execute();
			}

			if($query = $database->prepare("INSERT IGNORE INTO forward_options (option_name, option_value) VALUES ('ssl', ?)"))
			{
				$ssl = $this->Forward->Path->ssl ? 'true' : 'false';
				$query->bind_param('s', $ssl);
				$query->execute();
			}

			if($query = $database->prepare("INSERT IGNORE INTO forward_users (user_name, user_display_name, user_password, user_token, user_role, user_status) VALUES (?, ?, ?, ?, ?, ?)"))
			{

				$password = Crypter::Encrypt($args['user_pass'], 'password');
				$token = '';
				$role = 'admin';
				$status = 1;

				$query->bind_param('ssssss',
					$args['user_name'],
					$args['user_name'],
					$password,
					$token,
					$role,
					$status
				);
				$query->execute();
			}

			$this->Forward->User->LogIn(array('user_id' => 1, 'user_role' => 'admin'));

			$database->close();
		}

		/**
		* Footer
		* Prints data in footer
		*
		* @access   private
		*/
		public function Footer()
		{
			//echo 'script';
		}
	}