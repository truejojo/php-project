<?php
session_start();

require("../app/app.php");

ensure_user_is_authenticated();

$status = [];
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

  $gameName = validate(type: INPUT_POST, value: 'game');
  $gameGenre = validate(type: INPUT_POST, value: 'genre');
  $gameDescription = validate(type: INPUT_POST, value: 'description');

  if (
    $gameName === null || trim((string)$gameName) === ''
    || $gameGenre === null || trim((string)$gameGenre) === ''
    || $gameDescription === null || trim((string)$gameDescription) === ''
  ) {
    array_push($status, "Angegebene Werte sind ungültig!");
  } else {
    Data::addGame($gameName, $gameGenre, $gameDescription);
    redirect("index.php");
  }
}

$viewData = [
  'title' => 'Admin: Create',
  'headline' => 'Create new Game - Admin',
  'status' => $status,
];

view('admin/create', data: $viewData);
