<?php
// Lightweight manueller Provider-Test (Schritt D)
// Aufruf im Browser oder CLI: php tests/manual/provider_test.php

declare(strict_types=1);

require __DIR__ . '/../../app/inc/config.php';
require __DIR__ . '/../../app/inc/utility.functions.php';
require __DIR__ . '/../../app/inc/auth.functions.php';
require __DIR__ . '/../../app/class/dataprovider.class.php';
require __DIR__ . '/../../app/class/game.class.php';
require __DIR__ . '/../../app/class/filedataprovider.class.php';
require __DIR__ . '/../../app/class/mysqldataprovider.class.php';

function assertTrue(bool $cond, string $message): void {
  if (!$cond) {
    throw new RuntimeException("ASSERTION FAILED: $message");
  }
}

function section(string $title): void {
  echo "\n==== $title ====\n";
}

$results = [];
$errors = [];

// Test-Szenario: CRUD
function runCrudTest(DataProvider $provider, string $label): array {
  $log = [];
  $log[] = "Provider: $label";

  // 1. Create
  $created = $provider->addGame('TestGame_'.uniqid(), 'TestGenre', 'TestDescription');
  assertTrue($created === true, 'Add Game sollte true liefern');
  $all = $provider->getAllGames();
  assertTrue(count($all) > 0, 'Liste nach Add sollte > 0 sein');

  // Letztes Spiel annehmen als neues (da kein Rückgabe-ID Layer)
  $game = end($all);
  assertTrue($game instanceof Game, 'Neues Element ist kein Game Objekt');
  $id = $game->getId();
  $log[] = "Created Game ID: $id";

  // 2. Read single
  $fetched = $provider->getGame($id);
  assertTrue($fetched instanceof Game, 'getGame liefert kein Game');

  // 3. Update
  $updated = $provider->editGame($id, 'EditedName', 'EditedGenre', 'EditedDescription');
  assertTrue($updated === true, 'editGame sollte true liefern (ID vorhanden)');
  $again = $provider->getGame($id);
  assertTrue($again instanceof Game && $again->getName() === 'EditedName', 'Edit wurde nicht übernommen');

  // 4. Search (nur einfache Prüfung)
  $searchList = $provider->getSearchGames('EditedName');
  assertTrue(is_array($searchList), 'Search liefert kein Array');

  // 5. Delete
  $deleted = $provider->deleteGame($id);
  assertTrue($deleted === true, 'deleteGame sollte true liefern (ID vorhanden)');
  $gone = $provider->getGame($id);
  assertTrue($gone === null, 'Gelöschtes Game noch auffindbar');

  $log[] = 'CRUD Flow OK';
  return $log;
}

section('FILE PROVIDER TEST');
try {
  $fileProvider = new FileDataProvider(CONFIG['filename']);
  $results[] = runCrudTest($fileProvider, 'FileDataProvider');
} catch (Throwable $e) {
  $errors[] = 'File Provider Fehler: ' . $e->getMessage();
}

section('MYSQL PROVIDER TEST');
try {
  $mysqlProvider = new MySqlDataProvider(CONFIG['db_source'], CONFIG['db_user'], CONFIG['db_password']);
  $results[] = runCrudTest($mysqlProvider, 'MySqlDataProvider');
} catch (Throwable $e) {
  $errors[] = 'MySQL Provider Fehler: ' . $e->getMessage();
}

section('ERGEBNIS');
if ($errors) {
  echo "FEHLER aufgetreten:\n" . implode("\n", $errors) . "\n";
} else {
  echo "ALLE TESTS PASSIERT\n";
}

foreach ($results as $block) {
  echo implode("\n", $block) . "\n";
}

// Exit-Code für CLI Verwendungen
exit($errors ? 1 : 0);
