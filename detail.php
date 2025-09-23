<?php
require_once "./app/app.php";

// $gameId = filter_input(type: INPUT_GET, var_name: "id", filter: FILTER_VALIDATE_INT);

// if (!isset($gameId)) {
//   redirect("index.php");
// }

$game = getGame($gameId);

if (!$game) {
  view("404");
  exit;
}

$viewData = [
  'title' => 'Detailansicht',
  'headline' => "Game: {$game['game']}",
  'game' => $game,
];

view(template: 'detail', data: $viewData);
