<?php
class Game
{
  private int $id;
  private string $name;
  private string $genre;
  private string $description;

  public function __construct(int $id, string $name, string $genre, string $description)
  {
    $this->id = $id;
    $this->name = $name;
    $this->genre = $genre;
    $this->description = $description;
  }

  // Getter
  public function getId(): int
  {
    return $this->id;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function getGenre(): string
  {
    return $this->genre;
  }
  public function getDescription(): string
  {
    return $this->description;
  }

  // Setter für editGame()
  public function setName(string $name): void
  {
    $this->name = $name;
  }
  public function setGenre(string $genre): void
  {
    $this->genre = $genre;
  }
  public function setDescription(string $description): void
  {
    $this->description = $description;
  }
}