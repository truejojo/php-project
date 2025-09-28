<?php
require_once "./app/app.php";

$gameId = validate(type: INPUT_GET, value: "id");

if (!isset($gameId)) {
  redirect("index.php");
}

$game = Data::getGame($gameId);

if (!$game instanceof Game) {
  view("404");
  exit;
}

$viewData = [
  'title' => 'Detailansicht',
  'headline' => 'Game: ' . $game->getName(),
  'game' => $game,
];

view(template: 'detail', data: $viewData);