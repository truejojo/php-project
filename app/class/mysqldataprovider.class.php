<?php
declare(strict_types=1);

require_once 'game.class.php';

class DatabaseConnectionException extends RuntimeException {}

class MySqlDataProvider extends DataProvider
{
  protected string $source;
  protected string $dbUser;
  protected string $dbPassword;
  private ?PDO $connection = null; // Lazy-initialisierte, wiederverwendete Verbindung
  public function __construct(string $source, string $dbUser, string $dbPassword)
  {
    $this->source = $source;
    $this->dbUser = $dbUser;
    $this->dbPassword = $dbPassword;
  }
  public function getGame(int $id): ?Game
  {
    return $this->fetchOneGame(
      'SELECT id, name, genre, description FROM games WHERE id = :id LIMIT 1',
      [':id' => $id]
    );
  }

  public function editGame(int $id, string $name, string $genre, string $description): bool
  {
    $affected = $this->execOperation(
      'UPDATE games SET name = :name, genre = :genre, description = :description WHERE id = :id LIMIT 1',
      [
        ':id' => $id,
        ':name' => $name,
        ':genre' => $genre,
        ':description' => $description
      ]
    );
    
    return $affected === 1;
  }

  public function deleteGame(int $id): bool
  {
    $affected = $this->execOperation(
      'DELETE FROM games WHERE id = :id LIMIT 1',
      [':id' => $id]
    );
    
    return $affected === 1;
  }

  public function addGame(string $name, string $genre, string $description): bool
  {
    $affected = $this->execOperation(
      'INSERT INTO games (name, genre, description) VALUES (:name, :genre, :description)',
      [
        ':name' => $name,
        ':genre' => $genre,
        ':description' => $description
      ]
    );

    return $affected === 1;
  }

  public function getSearchGames(string $searchGame): array
  {
    $pattern = '%' . $searchGame . '%';
    return $this->fetchGames(
      'SELECT id, name, genre, description FROM games
       WHERE name LIKE :namePattern OR genre LIKE :genrePattern OR description LIKE :descriptionPattern',
      [
        ':namePattern' => $pattern,
        ':genrePattern' => $pattern,
        ':descriptionPattern' => $pattern,
      ]
    );
  }

  public function getAllGames(): array
  {
    return $this->fetchGames('SELECT id, name, genre, description FROM games');
  }

  /**
   * Liefert mehrere Game-Objekte entsprechend der Query.
   * @return Game[]
   */
  private function fetchGames(string $sql, array $params = []): array
  {
    $db = $this->dbConnect();

    if (empty($params)) {
      $stmt = $db->query($sql);
    } else {
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return array_map(fn(array $row) => $this->hydrateGame($row), $rows);
  }

  /**
   * Liefert genau ein Game oder null.
   */
  private function fetchOneGame(string $sql, array $params): ?Game
  {
    $db = $this->dbConnect();
    $stmt = $db->prepare($sql);    
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $this->hydrateGame($row) : null;
  }

  /**
   * Baut ein Game-Objekt aus einer Datenbankzeile.
   */
  private function hydrateGame(array $row): Game
  {
    return new Game(
      $row['id'],
      $row['name'],
      $row['genre'],
      $row['description']
    );
  }

  /**
   * Führt schreibende Operationen (INSERT/UPDATE/DELETE) aus und gibt betroffene Zeilen zurück.
   * Mutationen der Datenbank.
   */
  private function execOperation(string $sql, array $params): int
  {
    $db = $this->dbConnect();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->rowCount();
  }

  private function dbConnect(): PDO {
    if ($this->connection instanceof PDO) {
      return $this->connection;
    }
    try {
      $this->connection = new PDO($this->source, $this->dbUser, $this->dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]);
      
      return $this->connection;
    } catch (PDOException $e) {
      error_log('[DB] Verbindung fehlgeschlagen: ' . $e->getMessage());
      throw new DatabaseConnectionException('Verbindungsfehler zur Datenbank');
    }
  }
}