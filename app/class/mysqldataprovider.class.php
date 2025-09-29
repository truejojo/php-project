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
    $db = $this->dbConnect();
    if(!$db) return null;

    $sql = 'SELECT * FROM games WHERE id = :id LIMIT 1';

    $statement = $db->prepare($sql);
    $statement->execute([':id' => $id]);
    $data = $statement->fetch(PDO::FETCH_ASSOC);

    return $data ? new Game($data['id'], $data['name'], $data['genre'], $data['description']) : null;
  }

  public function editGame($id, $name, $genre, $description): void
  {
    $db = $this->dbConnect();
    if(!$db) return;

    $sql = 'UPDATE games SET name = :name, genre = :genre, description = :description WHERE id = :id';

    $statement = $db->prepare($sql);
    $statement->execute([':id' => $id, ':name' => $name, ':genre' => $genre, ':description' => $description]);
  }

  public function deleteGame($id): void
  {
    $db = $this->dbConnect();
    if(!$db) return; 

    $sql = 'DELETE FROM games WHERE id = :id LIMIT 1';
    $statement = $db->prepare($sql);
    $statement->execute([':id' => $id]);
  }

  public function addGame($name, $genre, $description): void
  {
    $db = $this->dbConnect();
    if(!$db) return;

    $sql = 'INSERT INTO games (name, genre, description) VALUES (:name, :genre, :description)';

    $statement = $db->prepare($sql);
    $statement->execute([':name' => $name, ':genre' => $genre, ':description' => $description]);
    // $statement->bindParam(':name', $name);
    // $statement->bindParam(':genre', $genre);
    // $statement->bindParam(':description', $description);
    // $statement->execute();
  }

  public function getSearchGames(string $searchGame): array
  {
    $db = $this->dbConnect();
    if(!$db) return [];

    $sql = 'SELECT * FROM games WHERE name LIKE :searchGame OR genre LIKE :searchGame OR description LIKE :searchGame';
    $statement = $db->prepare($sql);
    $statement->execute([':searchGame' => '%' . $searchGame . '%']);
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    return array_map(fn($item) => new Game($item['id'], $item['name'], $item['genre'], $item['description']), $data);
  }

  public function getAllGames(): array
  {
    $db = $this->dbConnect();
    if(!$db) return [];

    $sql = 'SELECT * FROM games';
    
    $statement = $db->query($sql);

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($item) => new Game($item['id'], $item['name'], $item['genre'], $item['description']), $data);
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