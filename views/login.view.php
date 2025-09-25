<div class="container">
  <div class="row">
    <div class="col-12">
      <h1><?= $data['title'] ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-3">
      <form action="" method="POST">
        <div class="mb-3">
          <label class="form-label" for="email">Email:</label>
          <input class="form-control" type="text" name="email" id="email">
        </div>
        <div class="mb-3">
          <label class="form-label" for="password">Passwort:</label>
          <input class="form-control" type="password" name="password" id="password">
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
      <?= isset($data['status']) && is_array($data['status']) ? implode('<br>', $data['status']) : '' ?>
    </div>
  </div>
</div>