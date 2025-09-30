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
try {
  Data::initialize(new MySqlDataProvider(CONFIG['db_source'], CONFIG['db_user'], CONFIG['db_password']));
} catch (DatabaseConnectionException $e) {
  echo '<h1 style="font-family: sans-serif; color:#b00;">Datenbank aktuell nicht erreichbar.</h1>';
  echo '<p>Bitte versuche es später erneut.</p>';
  // Optional: Wechsel auf File Provider wieder aktivierbar
  // Data::initialize(new FileDataProvider(CONFIG['filename']));
  exit;
}