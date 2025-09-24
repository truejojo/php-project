<?php
require_once "../app/app.php";

$searchGame = validate(INPUT_GET, 'search-game');

$listData = $searchGame
  ? getSearchGames($searchGame)
  : getAllGames();

$viewData = [
  'title' => 'Admin',
  'headline' => 'Spieleübersicht - Admin',
  'gameList' => $listData,
  'searchGame' => $searchGame,
];

view('admin/index', $viewData);
