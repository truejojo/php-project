<?php
require_once 'game.class.php';
class FileDataProvider
{
  private $source;
  public function __construct($source)
  {
    $this->source = $source;
  }


  public function getGame(string $id): array
  {
    $games = $this->getAllGames();
    foreach ($games as $game) {
      if ($game['id'] === $id) {
        return $game;
      }
    }
    return [];
  }



  public function editGame($id, $name, $genre, $description): void
  {
    $games = $this->getAllGames();

    foreach ($games as $i => $game) {
      if ((string)$game['id'] === (string)$id) {
        $games[$i]['game'] = $name;
        $games[$i]['genre'] = $genre;
        $games[$i]['description'] = $description;
      }
    }

    $this->setGamesData($games);
    return;
  }
  public function deleteGame($id): void
  {
    $games = $this->getAllGames();

    foreach ($games as $i => $game) {
      if ((string)$game['id'] === (string)$id) {
        // unset($games[$i]);
        array_splice($games, $i, 1);
        break;
      }
    }

    $this->setGamesData($games);
    return;
  }

  public function addGame($name, $genre, $description): void
  {
    $gameList = $this->getAllGames();
    $id = uniqid();

    $newGame = new Game($id, $name, $genre, $description);
    array_push($gameList, (array)$newGame);

    $this->setGamesData($gameList);
  }

  public function getSearchGames(string $searchGame): array
  {
    $allGames = $this->getAllGames();

    $results = array_filter(array: $allGames, callback: function ($game) use ($searchGame) {
      return stripos($game['game'], $searchGame) !== false ||
        stripos($game['genre'], $searchGame) !== false ||
        stripos($game['description'], $searchGame) !== false;
    });

    return $results;
  }

  public function getAllGames(): array
  {
    return $this->getGamesData() ?? [];
  }

  private function getGamesData(): array
  {
    $filename = $this->source;
    $json = "";

    if (!file_exists($filename)) {
      file_put_contents($filename, "");
    } else {
      $json = file_get_contents($filename);
    }

    return json_decode($json, true);
  }

  private function setGamesData($gameList): void
  {
    $filename = $this->source;
    $json = json_encode($gameList, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
  }
}
