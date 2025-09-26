<?php
abstract class DataProvider
{
  protected string $source;
  public function __construct($source)
  {
    $this->source = $source;
  }

  abstract public function getGame(string $id): array|null;

  abstract public function editGame($id, $name, $genre, $description): void;

  abstract public function addGame($name, $genre, $description): void;

  abstract public function getSearchGames(string $searchGame): array|null;

  abstract public function getAllGames(): array|null;
}
