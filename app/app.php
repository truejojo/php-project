<?php
define('APP_PATH', dirname(__FILE__, 2));

require_once 'inc/config.php';
require_once 'inc/utility.functions.php';
require_once 'inc/auth.functions.php';

require_once 'class/dataprovider.class.php';
require_once 'class/filedataprovider.class.php';
require_once 'class/mysqldataprovider.class.php';
require_once 'class/data.class.php';

// Data::initialize(new FileDataProvider(CONFIG['filename']));
Data::initialize(new MySqlDataProvider(CONFIG['db_source'], CONFIG['db_user'], CONFIG['db_password']));