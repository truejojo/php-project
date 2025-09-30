<?php
require_once 'game.class.php';

class FileDataProvider extends DataProvider
{
  public function getGame(int $id): ?Game
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
    $found = false;
    foreach ($games as $game) {
      if ($game->getId() === $id) {  // Treffer -> ändern & markieren
        $game->setName($name);
        $game->setGenre($genre);
        $game->setDescription($description);
        $found = true;
        break;
      }
    }
    if ($found) {
      $this->setGamesData($games); // Nur speichern wenn wirklich geändert
    }
    return $found; // false wenn ID nicht existierte
  }

  public function deleteGame(int $id): bool
  {
    $games = $this->getAllGames();
    foreach ($games as $i => $game) {
      if ($game->getId() === $id) {  // gefunden
        array_splice($games, $i, 1);
        $this->setGamesData($games); // Änderung persistieren
        return true;
      }
    }
    return false; // kein Treffer -> nichts gespeichert
  }

  public function addGame(string $name, string $genre, string $description): bool
  {
    $gameList = $this->getAllGames();
    // Simple Auto-Increment Simulation (max id + 1)
    $nextId = 1 + max(array_map(fn(Game $g) => $g->getId(), $gameList) ?: [0]);
    $newGame = new Game($nextId, $name, $genre, $description);
    $gameList[] = $newGame;

    $this->setGamesData($gameList);
    return true;
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
      if (!isset($gameData['id'], $gameData['name'], $gameData['genre'], $gameData['description'])) {
        continue; // unvollständiger Datensatz
      }
      $gameList[] = new Game(
        (int)$gameData['id'],
        (string)$gameData['name'],
        (string)$gameData['genre'],
        (string)$gameData['description']
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
  'id' => $game->getId(), // als int gespeichert – JSON speichert numerisch
        'name' => $game->getName(),
        'genre' => $game->getGenre(),
        'description' => $game->getDescription()
      ];
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
  }
}