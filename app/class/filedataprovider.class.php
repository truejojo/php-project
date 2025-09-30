<?php
require_once 'game.class.php';

class FileDataProvider extends DataProvider
{
  public function getGame(int $id): ?Game  // Rückgabetyp auf Game-Objekt ändern
  {
    $games = $this->getAllGames();
    foreach ($games as $game) {
      if ($game->getId() === $id) {  // Getter verwenden
        return $game;
      }
    }
    
    return null;
  }

  public function editGame(int $id, string $name, string $genre, string $description): bool
  {
    $games = $this->getAllGames();

    foreach ($games as $game) {
      if ($game->getId() === $id) {  // Getter verwenden
        // Setter verwenden (diese musst du in der Game-Klasse hinzufügen)
        $game->setName($name);
        $game->setGenre($genre);
        $game->setDescription($description);
        break;
      }
    }

    $this->setGamesData($games);

    return $games ? true : false;
  }

  public function deleteGame(int $id): bool
  {
    $games = $this->getAllGames();

    foreach ($games as $i => $game) {
      if ($game->getId() === $id) {  // Getter verwenden
        array_splice($games, $i, 1);
        return true;
      }
    }

    $this->setGamesData($games);
    return false;
  }

  public function addGame(string $name, string $genre, string $description): bool
  {
    $gameList = $this->getAllGames();
    $id = uniqid();

    $newGame = new Game($id, $name, $genre, $description);
    $gameList[] = $newGame;

    $this->setGamesData($gameList);

    return $gameList && $newGame ? true : false;
  }

  public function getSearchGames(string $searchGame): array
  {
    $allGames = $this->getAllGames();

    $results = array_filter($allGames, function ($game) use ($searchGame) {
      return stripos($game->getName(), $searchGame) !== false ||
        stripos($game->getGenre(), $searchGame) !== false ||
        stripos($game->getDescription(), $searchGame) !== false;
    });

    return array_values($results);  // Index zurücksetzen
  }

  public function getAllGames(): array
  {
    $data = $this->getGamesData() ?? [];
    $gameList = [];
    
    foreach ($data as $gameData) {
      // Game-Objekte aus den Array-Daten erstellen
      $gameList[] = new Game(
        $gameData['id'],
        $gameData['name'],
        $gameData['genre'],
        $gameData['description']
      );
    }
    
    return $gameList;
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

    return json_decode($json, true) ?? [];
  }

  private function setGamesData(array $gameList): void
  {
    $filename = $this->source;
    $data = [];
    
    foreach ($gameList as $game) {
      // Game-Objekte zurück in Arrays konvertieren für JSON
      $data[] = [
        'id' => $game->getId(),
        'name' => $game->getName(),
        'genre' => $game->getGenre(),
        'description' => $game->getDescription()
      ];
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
  }
}