<?php
require_once "./app/app.php";

$searchGame = validate(INPUT_GET, 'search-game');

$data = new FileDataProvider(CONFIG['filename']);

$listData = $searchGame
  ? $data->getSearchGames($searchGame)
  : $data->getAllGames();

$viewData = [
  'title' => 'Startseite',
  'headline' => 'Spieleübersicht',
  'gameList' => $listData,
  'searchGame' => $searchGame,
];

view('index', $viewData);
