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
  
    /**
     * Basis-Pagination (Fallback für Provider ohne native LIMIT-Unterstützung).
     * Rückgabe-Struktur: [items=>Game[], total=>int, page=>int, perPage=>int, pages=>int, hasPrev=>bool, hasNext=>bool]
     */
    public function getAllGamesPaginated(int $page, int $perPage): array
    {
      $page = max(1, $page);
      $perPage = max(1, min(100, $perPage));
      $all = $this->getAllGames();
      $total = count($all);
      $pages = max(1, (int)ceil($total / $perPage));
      if ($page > $pages) { $page = $pages; }
      $offset = ($page - 1) * $perPage;
      $slice = array_slice($all, $offset, $perPage);
      return [
        'items' => $slice,
        'total' => $total,
        'page' => $page,
        'perPage' => $perPage,
        'pages' => $pages,
        'hasPrev' => $page > 1,
        'hasNext' => $page < $pages,
      ];
    }
}