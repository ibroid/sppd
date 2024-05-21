<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Pengaturan</h3>
	</div>
	<div class="page-content">
		<section class="section">
			<div class="card">
				<div class="card-body">
					<!-- <div class="alert alert-info">
						<strong>Perhatian</strong>
						<ul>
							<li>
								<p>Untuk format penomoran surat dimohon untuk menambahkan kata "{nomor}" Hal ini dibutuhkan untuk digantikan dengan nomor surat asli</p>
							</li>
						</ul>
					</div> -->
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th width="400px">Name</th>
								<th>Value</th>
								<th width="200px">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Nama Satuan Kerja</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Alamat Satuan Kerja</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->alamat_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="alamat_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Telepon Satuan Kerja</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->telp_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="telp_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Faxmail Satuan Kerja</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->fax_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="fax_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Logo Satuan Kerja</td>
								<td>
									<input type="file" class="form-control" id="inputLogo">
								</td>
								<td>
									<button class="btn btn-success" id="saveLogo">Update</button>
									<button onclick="showLogo()" class="btn btn-warning">Lihat</button>
								</td>
							</tr>
							<tr>
								<td>Nama Ketua</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_ketua ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_ketua">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Ketua</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_ketua ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_ketua">Update</button>
								</td>
							</tr>
							<tr>
								<td>Nama Wakil</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_wakil ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_wakil">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Wakil</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_wakil ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_wakil">Update</button>
								</td>
							</tr>
							<tr>
								<td>Nama Panitera</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_panitera ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_panitera">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Panitera</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_panitera ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_panitera">Update</button>
								</td>
							</tr>
							<tr>
								<td>Nama Sekretaris</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_sekretaris ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_sekretaris">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Sekretaris</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_sekretaris ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_sekretaris">Update</button>
								</td>
							</tr>
							<tr>
								<td>Pejabat Pembuat Komitmen</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_ppk ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_ppk">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Pejabat Pembuat Komitmen</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_ppk ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_ppk">Update</button>
								</td>
							</tr>
							<!-- <tr>
								<td>Penomoran Surat</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nomor_surat ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nomor_surat">Update</button>
								</td>
							</tr> -->
							<tr>
								<td>Referensi Biaya DIPA 01</td>
								<td>
									<textarea name="referensi_dipa_01" class="form-control form-value" cols="3" rows="3"><?= $st->referensi_dipa_01 ?>
									</textarea>
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="referensi_dipa_01">Update</button>
								</td>
							</tr>
							<tr>
								<td>Referensi Biaya DIPA 04</td>
								<td>
									<textarea name="referensi_dipa_04" class="form-control form-value" cols="3" rows="3"><?= $st->referensi_dipa_04 ?>
									</textarea>
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="referensi_dipa_04">Update</button>
								</td>
							</tr>
							<tr>
								<td>Nama Bendahara</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nama_bendahara ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nama_bendahara">Update</button>
								</td>
							</tr>
							<tr>
								<td>NIP Bendahara</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nip_bendahara ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nip_bendahara">Update</button>
								</td>
							</tr>
							<tr>
								<td>PLT Sekretaris</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->plt_sekretaris ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="plt_sekretaris">Update</button>
								</td>
							</tr>
							<tr>
								<td>Nomor Register Terakhir Surat Masuk</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nrt_surat_masuk ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nrt_surat_masuk">Update</button>
								</td>
							</tr>
							<!-- <tr>
								<td>Nomor Register Terakhir Surat Keluar</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->nrt_surat_keluar ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="nrt_surat_keluar">Update</button>
								</td>
							</tr> -->
							<tr>
								<td>Website Satker</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->web_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="web_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Email Satker</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->email_satker ?>">
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="email_satker">Update</button>
								</td>
							</tr>
							<tr>
								<td>Maintenance</td>
								<td>
									<select name="maintenance" class="form-control form-value">
										<option value="0" <?= ($st->maintenance == 0 ? "selected" : "") ?>>Production</option>
										<option value="1" <?= ($st->maintenance == 1 ? "selected" : "") ?>>Maintenance</option>
									</select>
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="maintenance">Update</button>
								</td>
							</tr>
							<tr>
								<td>Mobile Allowed IP</td>
								<td>
									<input type="text" class="form-control form-value" value="<?= $st->mobile_allowed_ip ?>">
									<details>
										Gunakan titik koma (;) untuk memisahkan ip lainnya
									</details>
								</td>
								<td>
									<button class="btn btn-success btn-save" data-name="mobile_allowed_ip">Update</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<script>
	const formValues = document.querySelectorAll(".form-value");
	const saveButtons = document.querySelectorAll(".btn-save");

	const showLogo = () => {
		Swal.fire({
			title: 'Logo Satuan Kerja',
			text: 'Logo ini akan tertera di bagian atas suart',
			imageUrl: '<?= base_url('logo/' . $st->logo_satker) ?>',
			// imageWidth: width,
			// imageHeight: height,
			imageAlt: 'imageAlt,',
		})
	}

	for (let i = 0; i < saveButtons.length; i++) {
		const saveButton = saveButtons[i];
		const formValue = formValues[i];
		saveButton.addEventListener('click', async () => {
			swal.showLoading();
			const body = new FormData();
			body.append('name', saveButton.dataset.name);
			body.append('value', formValue.value);
			try {
				const saveReq = await fetch("<?= base_url() ?>/app/setting", {
					method: 'POST',
					body: body
				}).then(res => res.json());
				swal.fire("Berhasil Di Update").then(() => location.reload())
			} catch (error) {
				swal.fire("error :" + error);
			}
		});
	}

	$(document).ready(() => {
		$('#saveLogo').on('click', async () => {
			const body = new FormData();
			const file = $('#inputLogo')[0].files[0]
			if (!file) {
				return Swal.fire("File kosong");
			}
			try {
				body.append("logo", file)
				const postLogo = await fetch("<?= base_url('app/logo') ?>", {
					method: "POST",
					body: body
				}).then(res => res.json());
				if (postLogo.msg) {
					return Swal.fire(postLogo.msg);
				}
			} catch (error) {
				return Swal.fire("Error :" + error);
			}


			console.log(postLogo);
		})
	})
</script>