<?php
require_once "../app/app.php";

$gameId = validateDetail(type: INPUT_GET, value: "id");

if (!isset($gameId)) {
  redirect("index.php");
}

$game = getGame($gameId);

if (!$game) {
  view("404");
  exit;
}

$viewData = [
  'title' => 'Detailansicht - Admin',
  'headline' => "Admin: Game: {$game['game']}",
  'game' => $game,
];

view(template: 'admin/detail', data: $viewData);
