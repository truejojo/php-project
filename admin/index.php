<?php
session_start();

require "../app/app.php";

ensure_user_is_authenticated();

$searchGame = validate(INPUT_GET, 'search-game');
// Pagination Parameter
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]) ?: 1;
$perPage = filter_input(INPUT_GET, 'perPage', FILTER_VALIDATE_INT, ['options' => ['default' => 4, 'min_range' => 1, 'max_range' => 10]]) ?: 4;

if ($searchGame) {
  // Für Suche momentan keine eigene Pagination (könnte später ergänzt werden)
  $list = Data::getSearchGames($searchGame);
  $pagination = [
    'items' => $list,
    'total' => count($list),
    'page' => 1,
    'perPage' => count($list),
    'pages' => 1,
    'hasPrev' => false,
    'hasNext' => false,
  ];
} else {
  $pagination = Data::getAllGamesPaginated($page, $perPage);
}

$viewData = [
  'title' => 'Admin',
  'headline' => 'Spieleübersicht - Admin',
  'gameList' => $pagination['items'],
  'searchGame' => $searchGame,
  'pagination' => $pagination,
];

view('admin/index', $viewData);