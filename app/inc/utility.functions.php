<?php

function view($template, $data = []): void
{
  extract($data);
  require APP_PATH . "/views/layout.view.php";
}

function redirect($url): void
{
  header("Location: $url");
  exit;
}

function validate($type, $value)
{
  return filter_input(
    $type,
    $value,
    FILTER_SANITIZE_SPECIAL_CHARS
  );
}
