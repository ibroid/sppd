<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Pilihan
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="<?= base_url('sppd/edit/' . $v->id) ?>">Edit</a></li>
        <li><a class="dropdown-item" href="<?= base_url('sppd/biaya/' . $v->id) ?>">Rincian Biaya</a></li>
        <li><a class="dropdown-item" href="<?= base_url('sppd/riil/' . $v->id) ?>">Pengeluaran Riil</a></li>
        <li><a class="dropdown-item" href="javascript:void(0)" onclick="hapusData(<?= $v->id ?>)">Hapus</a></li>
    </ul>
</div>