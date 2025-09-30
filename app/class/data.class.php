 <?php
  class Data
  {
    private static $provider;

    public static function initialize($dataProvider): void
    {
      self::$provider = $dataProvider;
    }

    public static function getGame(string $id): ?Game
    {
      return self::$provider->getGame($id);
    }

    public static function editGame($id, $name, $genre, $description): void
    {
      self::$provider->editGame($id, $name, $genre, $description);
    }
    public static function deleteGame($id): void
    {
      self::$provider->deleteGame($id);
    }

    public static function addGame($name, $genre, $description): void
    {
      self::$provider->addGame($name, $genre, $description);
    }

    public static function getSearchGames(string $searchGame): array
    {
      return self::$provider->getSearchGames($searchGame);
    }

    public static function getAllGames(): array
    {
      return self::$provider->getAllGames();
    }

    public static function getAllGamesPaginated(int $page, int $perPage): array
    {
      return self::$provider->getAllGamesPaginated($page, $perPage);
    }
  }