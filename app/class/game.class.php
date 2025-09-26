<?php

class Game
{
  public string $id;
  public string $game;
  public string $genre;
  public string $description;

  public function __construct(string $id, string $game, string $genre, string $description)
  {
    $this->id = $id;
    $this->game = $game;
    $this->genre = $genre;
    $this->description = $description;
  }
}
