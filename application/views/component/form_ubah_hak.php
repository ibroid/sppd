<form action="<?= base_url("penomoran/tambah_hak") ?>" method="post">
  <div class="form-group">
    <label for="role_name">Nama Role</label>
    <input type="text" disabled id="role_name" class="form-control" value="<?= $role->role_name ?>">
    <input type="hidden" id="role_id" name="role_id" value="<?= $role->id ?>">
  </div>
  <table class="table">
    <?php foreach ($jenis_nomor as $jn) { ?>
      <tr>
        <td><?= $jn->kode ?></td>
        <td>
          <?php
          $filtered = $role->hak_penomoran->where('kode', $jn->kode);
          if ($filtered->first()) { ?>
            <input type="checkbox" value="<?= $jn->kode ?>" checked name="kode[]">
          <?php } else { ?>
            <input type="checkbox" value="<?= $jn->kode ?>" name="kode[]">
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
  <button class="btn btn-primary">Simpan</button>
</form>