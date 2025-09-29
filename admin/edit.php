<?php
session_start();

require("../app/app.php");

ensure_user_is_authenticated();

$status = [];
$game = null;

$method = $_SERVER['REQUEST_METHOD'] ?? '';

if ($method === 'POST') {
  // ID & Felder einlesen
  $gameId = validate(INPUT_POST, 'id');
  $name = validate(INPUT_POST, 'name');
  $genre = validate(INPUT_POST, 'genre');
  $description = validate(INPUT_POST, 'description');

  // Minimale Normalisierung
  $name = is_string($name) ? trim($name) : '';
  $genre = is_string($genre) ? trim($genre) : '';
  $description = is_string($description) ? trim($description) : '';

  if (empty($gameId) || $name === '' || $genre === '' || $description === '') {
    $status[] = 'Angegebene Werte sind ungültig!';
    // Platzhalter-Objekt für Wiederbefüllung
    $game = new Game((string)$gameId, (string)$name, (string)$genre, (string)$description);
  } else {
    Data::editGame($gameId, $name, $genre, $description);
    redirect('index.php');
  }
} else { // GET
  $gameId = validate(INPUT_GET, 'id');
  if ($gameId === null || $gameId === false) {
    redirect('index.php');
  }
  
  $game = Data::getGame($gameId);
  if (!$game instanceof Game) {
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