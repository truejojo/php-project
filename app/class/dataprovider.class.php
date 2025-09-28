<?php
abstract class DataProvider
{
  protected string $source;
  public function __construct($source)
  {
    $this->source = $source;
  }

  abstract public function getGame(string $id): ?Game; // Rückgabe als Game-Objekt oder null
  abstract public function editGame($id, $name, $genre, $description): void;
  abstract public function deleteGame($id): void;
  abstract public function addGame($name, $genre, $description): void;
  abstract public function getSearchGames(string $searchGame): array; // Rückgabe als Array von Game-Objekten?
  abstract public function getAllGames(): array; // Rückgabe als Array von Game-Objekten?
}