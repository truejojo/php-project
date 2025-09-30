<?php
// Fallback: Falls APP_PATH (normalerweise in app/app.php definiert) noch nicht gesetzt ist,
// definieren wir ihn hier, damit das Config-File auch standalone eingebunden werden kann
// (z.B. in Tests wie tests/manual/provider_test.php).
if (!defined('APP_PATH')) {
  define('APP_PATH', dirname(__DIR__, 2));
}

const CONFIG = [
  'filename' => APP_PATH . '/data/data.json',
  'db_source' => 'mysql:dbname=phpgrundlagen;host=localhost;port=3306;charset=utf8',
  'db_user' => 'root',
  'db_password' => 'root',
  'users' => [
    'max@text.de' => 'test1234',
    'jo@jo.de' => 'jo1234',
    'jojo@jojo.de' => 'jojo1234',
  ]
];