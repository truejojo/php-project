<?php
require_once "./app/app.php";

$listData = getAllGames();

$viewData = [
  'title' => 'Startseite',
  'headline' => 'Moin Welt!',
  'gameList' => $listData,
];

view('index', $viewData);
