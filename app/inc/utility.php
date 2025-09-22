<?php

function view($template, $data = []): void {
  extract($data);
  require("./views/layout.view.php");
}

function getAllGames(): array {
  $filename = CONFIG['filename'];

  $json = "";

  if(!file_exists($filename)) {
   file_put_contents($filename, "");
  } else {
   $json = file_get_contents($filename);
  }

  return json_decode($json, true);
}

function getGame(int $id): array {
  $games = getAllGames();
  foreach ($games as $game) {
    if ($game['id'] === $id) {
      return $game;
    }
  }
  return [];
} 