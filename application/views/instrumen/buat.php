<div class="content-wrapper container">
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h4>Instrumen Penugasan</h4>
                    <form action="<?= base_url('instrumen') ?>" method="POST">
                        <div class="row">
                            <div class="form-group">
                                <label for="tujuan"><strong> Tujuan Penugasan</strong></label>
                                <input type="text" class="form-control" name="tujuan">
                            </div>
                            <div class="form-group">
                                <label><strong>Pilih Pegawai Yang Akan Ditugaskan</strong></label>
                                <br>
                                <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success" type="button">Pilih Pegawai</button>
                                <br><br>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="4">Pegawai Yang Ditugaskan</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Nomor</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for=""><strong> Tanggal Penugasan</strong></label>
                                <input type="date" class="form-control" name="tanggal_penugasan">
                            </div>
                            <div class="form-group">
                                <label for=""><strong> Maksud Penugasan</strong></label>
                                <input type="text" required class="form-control" name="maksud">
                            </div>
                            <div class="form-group">
                                <label for=""><strong> Perihal Tentang</strong></label>
                                <input type="text" required class="form-control" name="perihal">
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Referensi Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="daftar" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Pangkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pegawai as $n => $p) { ?>
                            <tr>
                                <td><?= $p->nama ?></td>
                                <td><?= $p->jabatan->nama_jabatan ?></td>
                                <td><?= $p->golongan->nama_golongan ?></td>
                                <td><button data-json='<?= $p ?>' type="button" class="btn btn-pilih btn-warning btn-sm">Pilih</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {


        var listPegawai = [];

        const dataTable = new simpleDatatables.DataTable("#daftar");

        function addListenerMulti(element, eventNames, listener) {
            var events = eventNames.split(' ');
            for (var i = 0, iLen = events.length; i < iLen; i++) {
                element.on(events[i], listener);
            }
        }
        dataTable.on('datatable.search', () => {
            setPilihButton()
        });

        addListenerMulti(dataTable, 'datatable.page', function() {
            setPilihButton()
        });



        function setPilihButton() {
            const btnPilih = document.querySelectorAll('.btn-pilih');
            if (btnPilih.length == 0) {
                return;
            }
            for (const element of btnPilih) {
                element.addEventListener('click', () => {
                    const data = JSON.parse(element.dataset.json)
                    if (listPegawai.findIndex(row => row.id == data.id) !== -1) {
                        return;
                    }
                    listPegawai.push(data)
                    renderTable()
                })
            }
        }

        function setHapusButton(callback) {
            const btnHapus = document.querySelectorAll('.btn-hapus');

            for (const element of btnHapus) {
                element.addEventListener('click', () => {
                    const indexed = listPegawai.findIndex(row => row.id == element.dataset.id)
                    console.log(listPegawai.length)
                    listPegawai.splice(indexed, 1)
                    console.log(listPegawai.length)
                    callback()
                })
            }
        }

        function renderTable() {
            if (listPegawai.length == 0) {
                $('#tbody').html('')
            }
            let tableDataRow = '';
            let num = 1;
            listPegawai.forEach(row => {
                tableDataRow += `<tr>`;
                tableDataRow += `<td>${num}</td>`;
                tableDataRow += `<td>${row.nama}</td>`;
                tableDataRow += `<td>${row.jabatan.nama_jabatan}
                <input type="hidden" value="${row.id}" name="pegawai[]"></td>`;
                tableDataRow += `<td><button type="button" data-id="${row.id}" class="btn btn-danger btn-hapus">Hapus</button></td>`;
                tableDataRow += `</tr>`;
                $('#tbody').html(tableDataRow)
                num++;
            })

            setHapusButton(renderTable)
        }

        setPilihButton()


        dataTable.on('datatable.page', () => {})
    })
</script>