<?php

function view($template, $data = []): void
{
  extract($data);
  require "./views/layout.view.php";
}
