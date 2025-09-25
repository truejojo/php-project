<div class="max-w-2xl mx-auto my-5  py-5">
  <h1 class="text-3xl font-bold text-center mb-5"><?= $headline ?></h1>
  <a href="index.php" class="py-1 px-3 bg-transparent border border-white text-white rounded">Zurück zum Admin Bereich</a>

  <div class="p-2 bg-slate-100 rounded-lg text-black mt-10">
    <form action="" method="post" novalidate>
      <div class="mb-4">
        <h2><?= isset($game) ? htmlspecialchars($game['game']) : '' ?>, jetzt löschen?</h2>
      </div>
      <input type="hidden" name="id" value="<?= isset($game['id']) ? htmlspecialchars((string)$game['id']) : '' ?>">
      <input type="submit" value="Delete Game" class="py-1 px-3 bg-red-500 text-white rounded hover:bg-red-300 hover:text-black">
    </form>
    <p class="mt-4 text-red-600">
      <?= isset($status) && is_array($status) ? implode("", $status) : "" ?>
    </p>
  </div>
</div>