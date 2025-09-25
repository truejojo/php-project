<?php
session_start();

require("../app/app.php");

ensure_user_is_authenticated();

$status = [];
$game = [];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
  // ID beim POST aus dem Formular lesen (hidden field)
  $gameId = validateDetail(INPUT_POST, 'id');
  $gameName = validate(INPUT_POST, 'game');
  $gameGenre = validate(INPUT_POST, 'genre');
  $gameDescription = validate(INPUT_POST, 'description');

  if (
    $gameName === null || trim((string)$gameName) === ''
    || $gameGenre === null || trim((string)$gameGenre) === ''
    || $gameDescription === null || trim((string)$gameDescription) === ''
  ) {
    $status[] = 'Angegebene Werte sind ungültig!';
    // Bereits eingegebene Werte für die View sichern
    $game = [
      'id' => (string)($gameId ?? ''),
      'game' => (string)($gameName ?? ''),
      'genre' => (string)($gameGenre ?? ''),
      'description' => (string)($gameDescription ?? ''),
    ];
  } else {
    editGame($gameId, $gameName, $gameGenre, $gameDescription);
    redirect('index.php');
  }
} else {
  // GET (oder erster Aufruf): Datensatz laden
  $gameId = validateDetail(INPUT_GET, 'id');
  if ($gameId === null || $gameId === false) {
    redirect('index.php');
  }

  $game = getGame($gameId);
  if (!$game) {
    view('404');
    exit;
  }
}

$viewData = [
  'title' => 'Admin: Edit',
  'headline' => 'Edit Game - Admin',
  'game' => $game,
  'status' => $status,
];

view('admin/edit', data: $viewData);
