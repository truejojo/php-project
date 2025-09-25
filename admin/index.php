<?php
session_start();

require("../app/app.php");

ensure_user_is_authenticated();

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
