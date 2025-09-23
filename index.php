<?php
require_once "./app/app.php";

$searchGame = filter_input(
  INPUT_GET,
  'search-game',
  FILTER_VALIDATE_REGEXP,
  [
    'options' => [
      'regexp' => '/^[\p{L}\p{N}\s:<>-]+$/u',
    ],
  ]
);

$listData = $searchGame
  ? getSearchGames($searchGame)
  : getAllGames();

$viewData = [
  'title' => 'Startseite',
  'headline' => 'Spieleübersicht',
  'gameList' => $listData,
  'searchGame' => $searchGame,
];

view('index', $viewData);
