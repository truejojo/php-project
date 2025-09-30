<?php
declare(strict_types=1);

abstract class DataProvider
{
  protected string $source;
  public function __construct(string $source)
  {
    $this->source = $source;
  }

  abstract public function getGame(int $id): ?Game;
  abstract public function editGame(int $id, string $name, string $genre, string $description): bool;
  abstract public function deleteGame(int $id): bool;
  abstract public function addGame(string $name, string $genre, string $description): bool;
  abstract public function getSearchGames(string $searchGame): array;
  abstract public function getAllGames(): array;
}