


  <div class="my-5 mx-4">

    <h1 class="text-3xl font-bold text-center"><?=$headline ?></h1>
    
     <ul class="mt-5 space-y-2 max-w-2xl mx-auto">
      <?php if (!empty($data['gameList']) && is_array($data['gameList'])): ?>
        <?php foreach ($data['gameList'] as $game): ?>
          <li class="p-2 bg-slate-300 rounded-lg shadow-md text-black">
            <h2 class="text-2xl font-semibold text-blue-800"><?= htmlspecialchars($game['game']); ?></h2>
            <div>Genre: <?= htmlspecialchars($game['genre']); ?></div>
            <p>Beschreibung: <?= htmlspecialchars($game['description']); ?></p>
          </li>
        <?php endforeach; ?>
      <?php else: ?>
        <li>No games available.</li>
      <?php endif; ?>
  </div>
  
