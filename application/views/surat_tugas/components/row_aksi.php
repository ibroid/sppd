<a onclick="fetchBeforePrint(<?= $data->id ?>)" data-bs-toggle="modal" data-bs-target="#modalConfigPrint" class="btn btn-sm btn-success">
    <i class="bi bi-printer"></i>
</a>
<a href="<?= base_url('penugasan/edit/' . $data->id) ?>" class="btn btn-sm btn-info"><i class="bi bi-info"></i></a>
<a href="<?= base_url('penugasan/delete/' . $data->id) ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>