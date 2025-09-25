<?php
session_start();

require "app/app.php";

if (is_user_authenticated()) {
  redirect("admin/index.php");
}

$status = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[\w]+$/']]);

  if ($email == false) {
    array_push($status, 'Bitte eine gültige Email angeben! z.B. max@gmail.com');
  }
  if ($password == false) {
    array_push($status, 'Das Passwort erlaubt nur folgende Zeichen: a-zA-Z0-9_');
  }

  if (authenticate_user($email, $password)) {
    session_regenerate_id(true);
    $_SESSION['email'] = $email;
    redirect('admin/index.php');
  } else {
    array_push($status, 'Login fehlgeschlagen!');
  }
}

$view_data = [
  'title' => "Login",
  'status' => $status
];

view('login', $view_data);
