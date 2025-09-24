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
    FILTER_VALIDATE_REGEXP,
    [
      'options' => [
        'regexp' => '/^[\p{L}\p{N}\s:<>-]+$/u',
      ],
    ]
  );
}
function validateDetail($type, $value)
{
  return filter_input(type: $type, var_name: $value, filter: FILTER_VALIDATE_INT);
}
