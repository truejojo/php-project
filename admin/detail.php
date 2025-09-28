<?php
session_start();

require("../app/app.php");

ensure_user_is_authenticated();

$gameId = validate(INPUT_GET, 'id');

if (!isset($gameId)) {
  redirect("index.php");
}

$game = Data::getGame($gameId);

if (!$game instanceof Game) {
  view("404");
  exit;
}

$viewData = [
  'title' => 'Detailansicht - Admin',
  'headline' => "Admin: Game: {$game->getName()}",
  'game' => $game,
];

view(template: 'admin/detail', data: $viewData);