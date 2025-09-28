<div class="my-5 mx-4">
  <h1 class="text-3xl font-bold text-center"><?= $headline ?></h1>

  <div class="my-5 flex justify-between gap-2  max-w-2xl mx-auto text-black">
    <form action="" class="space-x-2">
      <input type="text" name="search-game" placeholder="Search for a game"
        class="py-1 px-2 rounded-md bg-white text-black placeholder-slate-500 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="<?= isset($data['searchGame']) ? htmlspecialchars($data['searchGame']) : '' ?>" maxlength="30">
      <input type="submit" value="Search" class="py-1 px-3 bg-blue-500 text-white rounded">
    </form>
    <div class="space-x-2">
      <a href="index.php" class="py-1 px-3 bg-transparent border border-white text-white rounded">Alle Spiele</a>
      <a href="create.php" class="py-1 px-3 bg-green-500 hover:bg-green-300 text-white hover:text-black rounded">ADD</a>
    </div>
  </div>
</div>

<ul class="my-5 space-y-2 max-w-2xl mx-auto">
  <?php if (!empty($data['gameList']) && is_array($data['gameList'])): ?>
  <?php foreach ($data['gameList'] as $game): ?>
  <li class="bg-slate-300 rounded-lg text-black p-3">
    <div class="flex justify-between">
      <a href="detail.php?id=<?= isset($game) && $game instanceof Game ? htmlspecialchars($game->getId()) : '' ?>"
        class="block ">
        <h2 class="text-2xl font-semibold hover:font-bold hover:underline text-blue-800">
          <?= htmlspecialchars($game->getName()); ?>
        </h2>
      </a>
      <div class="space-x-2">
        <a href="edit.php?id=<?= isset($game) && $game instanceof Game ?  htmlspecialchars($game->getId()) : '' ?>"
          class="text-blue-700 hover:font-bold">EDIT</a>
        <a href="delete.php?id=<?= isset($game) && $game instanceof Game ?  htmlspecialchars($game->getId()) : '' ?>"
          class="text-red-700 hover:font-bold">DELETE</a>
      </div>
    </div>
    <div>Genre: <?= isset($game) && $game instanceof Game ?  htmlspecialchars($game->getGenre()) : '' ?></div>
    <p>Beschreibung: <?= isset($game) && $game instanceof Game ?  htmlspecialchars($game->getDescription()) : '' ?></p>
  </li>
  <?php endforeach; ?>
  <?php else: ?>
  <p class="text-center">Keine Spiele gefunden.</p>
  <?php endif; ?>
</ul>
</div>