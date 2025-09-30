<?php
require_once 'game.class.php';

class MySqlDataProvider extends DataProvider
{
  protected string $source;
  protected string $dbUser;
  protected string $dbPassword;
  public function __construct($source, $dbUser, $dbPassword)
  {
    $this->source = $source;
    $this->dbUser = $dbUser;
    $this->dbPassword = $dbPassword;
  }
  public function getGame(string $id): ?Game
  {
    $data = $this->dpOperation(
      'SELECT id, name, genre, description FROM games WHERE id = :id LIMIT 1', 
      [
        ':id' => $id
      ]
    );

    return $data[0] ?? null;
  }

  public function editGame($id, $name, $genre, $description): bool
  {
    $affected = $this->execOperation(
      'UPDATE games SET name = :name, genre = :genre, description = :description WHERE id = :id',
      [
        ':id' => $id,
        ':name' => $name,
        ':genre' => $genre,
        ':description' => $description
      ]
    );
    // true genau dann, wenn genau eine Zeile aktualisiert wurde (id existierte & Änderung möglich)
    return $affected === 1;
  }

  public function deleteGame($id): bool
  {
    $affected = $this->execOperation(
      'DELETE FROM games WHERE id = :id LIMIT 1',
      [':id' => $id]
    );
    return $affected === 1; // genau eine Zeile gelöscht
  }

  public function addGame($name, $genre, $description): bool
  {
    $affected = $this->execOperation(
      'INSERT INTO games (name, genre, description) VALUES (:name, :genre, :description)',
      [
        ':name' => $name,
        ':genre' => $genre,
        ':description' => $description
      ]
    );
    return $affected === 1; // Ein Datensatz eingefügt
  }

  public function getSearchGames(string $searchGame): array
  {
     $data = $this->dpOperation(
      'SELECT id, name, genre, description FROM games WHERE name LIKE :searchGame OR genre LIKE :searchGame OR description LIKE :searchGame', 
      [
        ':searchGame' => '%' . $searchGame . '%'
      ]
    );

    return $data ?? [];
  }

  public function getAllGames(): array
  {
    $data = $this->dpOperation(
      'SELECT id, name, genre, description FROM games',       
    );

    return $data ?? [];
  }

  private function dpOperation($sql, $params = null): array {
    $db = $this->dbConnect();
    if(!$db) return [];

    if(!$params){
      $statement = $db->query($sql);      
    }else {
      $statement = $db->prepare($sql);
      $statement->execute($params);
    }

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $item => $row) {
      $data[$item] = new Game(...$row);
    }

    return $data;
  }

  /**
   * Führt schreibende Operationen (INSERT/UPDATE/DELETE) aus und gibt betroffene Zeilen zurück.
   */
  private function execOperation(string $sql, array $params): int
  {
    $db = $this->dbConnect();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
  }

  private function dbConnect(): PDO {
    try {
      $pdo = new PDO($this->source, $this->dbUser, $this->dbPassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
    } catch (PDOException $e) {      
      die("Datenbankverbindungsfehler: " . $e->getMessage());
    }
  }
}