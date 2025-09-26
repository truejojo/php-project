<?php
require_once "./app/app.php";

$searchGame = validate(INPUT_GET, 'search-game');

$listData = $searchGame
  ? Data::getSearchGames($searchGame)
  : Data::getAllGames();

$viewData = [
  'title' => 'Startseite',
  'headline' => 'Spieleübersicht',
  'gameList' => $listData,
  'searchGame' => $searchGame,
];

view('index', $viewData);
