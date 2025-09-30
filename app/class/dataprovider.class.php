<?php
abstract class DataProvider
{
  protected string $source;
  public function __construct($source)
  {
    $this->source = $source;
  }

  abstract public function getGame(string $id): ?Game;
  abstract public function editGame($id, $name, $genre, $description): bool;
  abstract public function deleteGame($id): bool;
  abstract public function addGame($name, $genre, $description): bool;
  abstract public function getSearchGames(string $searchGame): array;
  abstract public function getAllGames(): array;
}