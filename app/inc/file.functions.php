<?php
function getAllGames(): array
{
  $filename = CONFIG['filename'];

  $json = "";

  if (!file_exists($filename)) {
    file_put_contents($filename, "");
  } else {
    $json = file_get_contents($filename);
  }

  return json_decode($json, true);
}

function getGame(int $id): array
{
  $games = getAllGames();
  foreach ($games as $game) {
    if ($game['id'] === $id) {
      return $game;
    }
  }
  return [];
}

function getSearchGames(string $searchGame): array
{
  $allGames = getAllGames();

  $results = array_filter(array: $allGames, callback: function ($game) use ($searchGame) {
    return stripos($game['game'], $searchGame) !== false ||
      stripos($game['genre'], $searchGame) !== false ||
      stripos($game['description'], $searchGame) !== false;
  });

  return $results;
}
