<div class="max-w-2xl mx-auto my-5">
  <h1 class="text-3xl font-bold text-center mb-5"><?= $headline ?></h1>
  <a href="index.php" class="py-1 px-3 bg-transparent border border-white text-white rounded">zurück</a>

  <div class="p-2 bg-slate-100 rounded-lg text-black mt-5">
    <h2 class="text-2xl font-semibold text-blue-800"><?= htmlspecialchars($game->getName()); ?></h2>
    <div>Genre: <?= htmlspecialchars($game->getGenre()); ?></div>
    <p>Beschreibung: <?= htmlspecialchars($game->getDescription()); ?></p>
  </div>
</div>