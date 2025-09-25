<div class="max-w-2xl mx-auto my-5  py-5">
  <h1 class="text-3xl font-bold text-center mb-5"><?= $headline ?></h1>
  <a href="index.php" class="py-1 px-3 bg-transparent border border-white text-white rounded">Zurück zum Admin Bereich</a>

  <div class="p-2 bg-slate-100 rounded-lg text-black mt-10">
    <form action="" method="post" novalidate>
      <div class="mb-4">
        <label for="game" class="block text-sm font-medium mb-1">Game Title:</label>
        <input type="text" id="game" name="game" class="w-full p-2 border border-slate-300 rounded">
      </div>
      <div class="mb-4">
        <label for="genre" class="block text-sm font-medium mb-1">Genre:</label>
        <input type="text" id="genre" name="genre" class="w-full p-2 border border-slate-300 rounded">
      </div>
      <div class="mb-4">
        <label for="description" class="block text-sm font-medium mb-1">Beschreibung:</label>
        <input type="text" id="description" name="description" class="w-full p-2 border border-slate-300 rounded">
      </div>
      <input type="submit" value="Create Game" class="py-1 px-3 bg-green-500 text-white rounded hover:bg-green-300 hover:text-black">
    </form>
    <p class="mt-4 text-red-600">
      <?= isset($status) && is_array($status) ? implode("", $status) : "" ?>
    </p>
  </div>
</div>