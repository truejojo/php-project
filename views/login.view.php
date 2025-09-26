<div class="max-w-2xl mx-auto my-5 py-5">
  <h1 class="text-3xl font-bold text-center mb-5"><?= $data['title'] ?></h1>

  <div class="p-2 bg-slate-100 rounded-lg text-black mt-10">
    <form action="" method="POST">
      <div class="mb-3">
        <label class="block text-sm font-medium mb-1" for="email">Email:</label>
        <input class="w-full p-2 border border-slate-300 rounded" type="text" name="email" id="email">
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium mb-1" for="password">Passwort:</label>
        <input class="w-full p-2 border border-slate-300 rounded" type="password" name="password" id="password">
      </div>
      <input type="submit" value="Login" class="py-1 px-3 bg-orange-500 text-white rounded hover:bg-orange-300 hover:text-black">

    </form>
    <?= isset($data['status']) && is_array($data['status']) ? implode('<br>', $data['status']) : '' ?>
  </div>
</div>