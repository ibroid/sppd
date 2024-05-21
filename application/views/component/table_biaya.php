<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Untuk Keperluan</th>
            <th>Biaya</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody id="rowForm">
        <?php $total = null; ?>
        <?php if (isset($data)) { ?>
            <?php foreach ($data as $key => $value) { ?>
                <tr>
                    <td>
                        <?= $value->keperluan ?>
                    </td>
                    <td>
                        <?= rupiah($value->biaya) ?>
                    </td>
                    <td>
                        x<?= $value->jumlah ?>
                    </td>
                    <td>
                        <?= $value->keterangan ?>
                    </td>
                    <td>
                        <?= rupiah($value->biaya * $value->jumlah);
                        $total += $value->biaya * $value->jumlah ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        <tr>
            <td colspan="4">
                <div class="text-end">Total</div>
            </td>
            <td>
                <?= rupiah($total)  ?>
            </td>
        </tr>
    </tbody>
</table>