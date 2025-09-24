<div class="my-5 mx-4">
  <h1 class="text-3xl font-bold text-center"><?= $headline ?></h1>

  <div class="my-5 flex justify-between gap-2  max-w-2xl mx-auto text-black">
    <form action="" class="space-x-2">
      <input
        type="text"
        name="search-game"
        placeholder="Search for a game"
        class="py-1 px-2 rounded-md bg-white text-black placeholder-slate-500 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="<?= isset($data['searchGame']) ? htmlspecialchars($data['searchGame']) : '' ?>"
        maxlength="30">
      <input type="submit" value="Search" class="py-1 px-3 bg-blue-500 text-white rounded">
    </form>
    <a href="index.php" class="py-1 px-3 bg-transparent border border-white text-white rounded">Alle Spiele</a>
  </div>
</div>

<ul class="my-5 space-y-2 max-w-2xl mx-auto">
  <?php if (!empty($data['gameList']) && is_array($data['gameList'])): ?>
    <?php foreach ($data['gameList'] as $game): ?>
      <li class="bg-slate-300 hover:bg-slate-100 rounded-lg text-black">
        <a href="detail.php?id=<?= htmlspecialchars($game['id']); ?>" class="block p-3">
          <h2 class="text-2xl font-semibold text-blue-800"><?= htmlspecialchars($game['game']); ?></h2>
          <div>Genre: <?= htmlspecialchars($game['genre']); ?></div>
          <p>Beschreibung: <?= htmlspecialchars($game['description']); ?></p>
        </a>
      </li>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center">Keine Spiele gefunden.</p>
  <?php endif; ?>
</ul>
</div>