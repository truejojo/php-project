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

function addGame($name, $genre, $description): void
{
  $gameList = getAllGames();
  array_push($gameList, [
    'id' => getIdNumber(),
    'game' => $name,
    'genre' => $genre,
    'description' => $description,
  ]);

  saveAllGames($gameList);
}

function saveAllGames($gameList): void
{
  $filename = CONFIG['filename'];
  $json = json_encode($gameList, JSON_PRETTY_PRINT);
  file_put_contents($filename, $json);
}

function getIdNumber(): int
{
  return random_int(1, 1000000);
}
