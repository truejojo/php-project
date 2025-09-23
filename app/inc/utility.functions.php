<?php

function view($template, $data = []): void
{
  extract($data);
  require "./views/layout.view.php";
}

function redirect($url): void
{
  header("Location: $url");
  exit;
}
