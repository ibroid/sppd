<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper container-fluid">
    <div class="page-heading">
        <h3>Kelola Surat Keluar</h3>
    </div>
    <div class="page-content ">
        <?php if (pengaturan()->maintenance == 1) { ?>
            <div class="alert alert-danger">
                <strong>
                    MAINTENANCE. TOLONG JANGAN DI PAKAI
                </strong>
            </div>
        <?php } ?>
        <div id="notif-socket"></div>
        <?php if ($this->session->flashdata('notif') or $this->session->flashdata('notif_file')) { ?>
            <div class="alert alert-info">
                <strong>
                    <?= $this->session->flashdata('notif') ?><br>
                    <?= $this->session->flashdata('notif_file') ?>
                </strong>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Kontrol Surat Keluar</h5>
            </div>
            <div class="card-body">
                <h6>Tabel Surat Masuk</h6>
                <table id="tableSuratKeluar" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tujuan</th>
                            <th>Klasifikasi</th>
                            <th>Kode Surat</th>
                            <th>Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Aksi</th>
                            <th>Log</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/js/autocomplete.js') ?>"></script>
<script src="https://socket.pajakartautara.id/socket.io/socket.io.js"></script>
<script>
    var socket = null;
    $(document).ready(() => {

        $('#tableSuratKeluar').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": '<?= base_url('penomoran/datatable') ?>',
                "type": "POST"
            },
            "drawCallback": () => {
                $('.input-kode').each((n, e) => {
                    $(e).on("input", () => {
                        const nilaiInput = $(e).val();
                        const nilaiTanpaSpasi = nilaiInput.replace(/\s/g, '');
                        $(e).val(nilaiTanpaSpasi);
                    })
                });

                const formsRealtime = document.querySelectorAll('.form-realtime');
                for (const form of formsRealtime) {
                    form.addEventListener('input', () => {
                        if (socket == null) {
                            Swal.fire('Tidak terhubung ke jaringan socket. User lain tidak akan tahu anda sedang mengisi nomor surat keluar')
                        }

                        const inputan = form.value
                        const filterRgx = inputan.replace(/[^0-9]/g, '');
                        form.value = filterRgx

                        const logInput = document.getElementById(String(form.dataset.id).replace('input-nomor', 'log'))
                        if (form.value) {
                            socket.emit('input-focus', {
                                input: form.dataset.id,
                                value: form.value,
                                user: '<?= auth()->pegawai['nama'] ?>'
                            })
                            logInput.textContent = '<?= auth()->pegawai['nama'] ?> Sedang mengetik...'
                        } else {
                            socket.emit('input-unfocus', {
                                input: form.dataset.id,
                                value: '',
                                user: '<?= auth()->pegawai['nama'] ?>'
                            })

                            logInput.textContent = 'Log Here'
                        }
                    })
                }

            }
        });

        try {
            socket = io('https://socket.pajakartautara.id/penomoran');

            socket.on('connect', () => {
                $('#notif-socket').html('<div class="alert alert-light-success color-success"><i class="bi bi-exclamation-circle"></i> Berhasil terkoneksi ke jaringan socket. Penomoran secara realtime berhasil dijalankan</div>')
            })

            socket.on('reconnecting', () => {
                $('#notif-socket').html('<div class="alert alert-light-warning color-warning"><i class="bi bi-exclamation-circle"></i> Menghubungkan kembali ke jaringan socket</div>')
            })

            socket.on('disconnect', function() {
                $('#notif-socket').html('<div class="alert alert-light-danger color-danger"><i class="bi bi-exclamation-circle"></i> Terputus dari Jaringan Socket. Penomoran realtime tidak berfungsi</div>')
            });

            socket.on('someone-input', ({
                input,
                value,
                user
            }) => {
                const form = document.getElementById(input)
                form.disabled = true
                form.value = value
                form.classList.remove('is-valid')
                form.classList.add('is-invalid')

                feedbackText = document.getElementById(String(input).replace('input', 'feedback'))
                feedbackText.classList.remove('valid-feedback')
                feedbackText.classList.add('invalid-feedback')
                feedbackText.textContent = 'Tidak Tersedia'

                const logInput = document.getElementById(String(input).replace('input-nomor', 'log'))
                logInput.textContent = user + ' Sedang mengetik...'

                const buttonSubmit = document.getElementById(String(input).replace('input-nomor', 'button-submit'))
                buttonSubmit.disabled = true
            })

            socket.on('someone-leave', ({
                input,
                value,
                user
            }) => {
                const form = document.getElementById(input)
                form.disabled = false
                form.value = ''
                form.classList.add('is-valid')
                form.classList.remove('is-invalid')

                feedbackText = document.getElementById(String(input).replace('input', 'feedback'))
                feedbackText.classList.add('valid-feedback')
                feedbackText.classList.remove('invalid-feedback')
                feedbackText.textContent = 'Tersedia'

                const logInput = document.getElementById(String(input).replace('input-nomor', 'log'))
                logInput.textContent = 'Loge Here'

                const buttonSubmit = document.getElementById(String(input).replace('input-nomor', 'button-submit'))
                buttonSubmit.disabled = false
            })

        } catch (error) {
            $('#notif-socket').html('<div class="alert alert-light-danger color-danger"><i class="bi bi-exclamation-circle"></i> Gagal GagalTerkoneksi Ke Jaringan Socket. Penomoran realtime tidak berfungsi</div>')
        }
    })

    const saveNomorSurat = (id) => {

        const inputKodeSurat = document.getElementById('input-kode-' + id)
        if (!inputKodeSurat.value) {
            return Swal.fire('Kode Surat Masih Kosong')
        }
        const inputNomorSurat = document.getElementById('input-nomor-' + id)
        if (!inputNomorSurat.value) {
            return Swal.fire('Nomor Surat Masih Kosong')
        }
        Swal.fire({
            title: 'Mohon Tunggu',
            willOpen: () => Swal.showLoading(),
            backdrop: true,
            allowOutsideClick: false,
            showConfirmButton: false
        })

        const body = new FormData();
        body.append('id', id);
        body.append('nomor_surat', inputNomorSurat.value);
        body.append('kode_surat', inputKodeSurat.value);
        body.append('klasifikasi_surat', $("#select-klasifikasi-surat-" + id).val());
        fetch('<?= base_url('penomoran/save_surat_keluar') ?>', {
                method: 'POST',
                body
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(res.statusText)
                }
                return res.json()
            })
            .then(res => Swal.fire(res).then(() => location.reload()))
            .catch(err => Swal.fire('Terjadi Kesalahan', err.message, 'error'))
    }

    function cek_nomor_surat_terakhir(elm) {
        const kode = $(elm).val()
        $.ajax({
            url: "<?= base_url("penomoran/nomor_surat_terakhir/") ?>" + kode,
            success(response) {
                const id = $(elm).data("suratId")
                // console.log(id)
                $("#input-nomor-" + id)
                    .attr("disabled", false)
                    .val(response)
                    .removeClass("is-invalid")
                    .addClass("is-valid")
            },
            error(error) {
                Swal.fire("Terjadi kesalahan saat mencari nomor surat terakhir", error.responseText, "error")
            }
        })
    }
</script>