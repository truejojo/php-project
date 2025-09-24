<?php
if (!isset($title) || $title === '') {
  $title = "PHP - Projekt";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title><?= htmlspecialchars($title); ?></title>
</head>

<body class="bg-slate-900 text-white">

  <?php require "$template.view.php"; ?>

</body>

</html>