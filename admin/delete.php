<?php
require_once "../app/app.php";

$status = [];
$game = [];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
  // ID beim POST aus dem Formular lesen (hidden field)
  $gameId = validateDetail(INPUT_POST, 'id');

  if (empty($gameId)) {
    $status[] = 'Angegebene Werte sind ungültig!';
  } else {
    deleteGame($gameId);
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
  'title' => 'Admin: Delete',
  'headline' => 'Delete Game - Admin',
  'game' => $game,
  'status' => $status,
];

view('admin/delete', data: $viewData);
