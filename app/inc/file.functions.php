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

  // return array_map('normalizeGameRecord', json_decode($json, true) ?: []);
  return json_decode($json, true);
}

function getGame(string $id): array
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

function editGame($id, $name, $genre, $description): void
{
  $games = getAllGames();

  foreach ($games as $i => $game) {
    if ((string)$game['id'] === (string)$id) {
      $games[$i]['game'] = $name;
      $games[$i]['genre'] = $genre;
      $games[$i]['description'] = $description;
    }
  }

  saveAllGames($games);
  return;
}
function deleteGame($id): void
{
  $games = getAllGames();

  foreach ($games as $i => $game) {
    if ((string)$game['id'] === (string)$id) {
      // unset($games[$i]);
      array_splice($games, $i, 1);
      break;
    }
  }

  saveAllGames($games);
  return;
}

function addGame($name, $genre, $description): void
{
  $gameList = getAllGames();
  $id = uniqid();

  $newGame = new Game($id, $name, $genre, $description);
  array_push($gameList, (array)$newGame);

  saveAllGames($gameList);
}

function saveAllGames($gameList): void
{
  $filename = CONFIG['filename'];
  $json = json_encode($gameList, JSON_PRETTY_PRINT);
  file_put_contents($filename, $json);
}
