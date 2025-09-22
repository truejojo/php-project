<div class="container mx-auto my-5">
  <h1 class="text-3xl font-bold text-center"><?= $headline ?></h1>
  <span><a href="index.php">zurück</a></span>
  <div class="p-2 block bg-slate-300 hover:bg-slate-100 rounded-lg text-black mt-5">
              <a href="detail.php?id=<?= htmlspecialchars($game['id']); ?>">
              <h2 class="text-2xl font-semibold text-blue-800"><?= htmlspecialchars($game['game']); ?></h2>
                <div>Genre: <?= htmlspecialchars($game['genre']); ?></div>
              <p>Beschreibung: <?= htmlspecialchars($game['description']); ?></p>
  
  </div>
</div>