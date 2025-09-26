 <?php

  class Data
  {
    private static $dataSourse;

    public static function initialize($dataProvider): void
    {
      self::$dataSourse = $dataProvider;
    }

    public static function getGame(string $id): array
    {
      return self::$dataSourse->getGame($id);
    }

    public static function editGame($id, $name, $genre, $description): void
    {
      self::$dataSourse->editGame($id, $name, $genre, $description);
    }
    public static function deleteGame($id): void
    {
      self::$dataSourse->deleteGame($id);
    }

    public static function addGame($name, $genre, $description): void
    {
      self::$dataSourse->addGame($name, $genre, $description);
    }

    public static function getSearchGames(string $searchGame): array
    {
      return self::$dataSourse->getSearchGames($searchGame);
    }

    public static function getAllGames(): array
    {
      return self::$dataSourse->getAllGames();
    }
  }
