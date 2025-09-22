<?php
require_once('inc/utility.php');

$viewData = [
  'title' => 'Startseite',
  'headline' => 'Moin Welt!'
];

view('index', $viewData);
