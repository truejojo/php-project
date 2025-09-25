<?php
function authenticate_user($email, $password)
{
  $users = CONFIG['users'];

  if (!isset($users[$email])) {
    return false;
  }

  return $users[$email] == $password;
}

function ensure_user_is_authenticated()
{
  if (!is_user_authenticated()) {
    redirect("../login.php");
  }
}

function is_user_authenticated()
{
  return isset($_SESSION['email']);
}
