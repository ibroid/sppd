<?php

$templateProc = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . 'template/uploads/' . $data->filename);

?>
<div class="content-wrapper container-fluid">
	<div class="page-heading">
		<h3>Generate Template</h3>
	</div>
	<div class="page-content">
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
				<h5 class="card-title">Silahkan isi variabel yang tertera pada template</h5>
			</div>
			<div class="card-body">
				<form action="<?= base_url('surat/generate_surat_from_template') ?>" method="POST">
					<input type="hidden" name="template_name" value="<?= $data->filename ?>">
					<?php foreach ($templateProc->getVariables() as $tp) { ?>
						<?php if (
							$tp != 'logo'
							and $tp != 'nama_satker'
							and $tp != 'web_satker'
							and $tp != 'fax_satker'
							and $tp != 'telp_satker'
							and $tp != 'email_satker'
							and $tp != 'alamat_satker'
							and $tp != 'penanda_tangan'
							and $tp != 'nama_penanda_tangan'
							and $tp != 'nip_penanda_tangan'
						) { ?>
							<div class="row mb-3">
								<div class="col-md-2">
									<label for="<?= $tp ?>"><?= ucfirst(str_replace('_', ' ', $tp))  ?></label>
								</div>
								<div class="col-md-7">
									<textarea id="input_<?= $tp ?>" required placeholder="<?= $tp ?>" name="<?= $tp ?>" id="<?= $tp ?>" class="form-control" rows="1"></textarea>
								</div>
								<div class="col-md-3">

									<div class="row">
										<div class="col-md-6 col-sm-6">
											<button onclick="steadyVariableUmum('<?= $tp ?>')" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary btn-sm">Referensi Umum</button>
										</div>
										<div class="col-md-6 col-sm-6">
											<button class="btn btn-success btn-sm">Referensi Surat Keluar</button>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<hr>
					<div class="row mb-3">
						<div class="col-md-2">
							<label for="penanda_tagan">Penanda Tangan</label>
						</div>
						<div class="col-md-2">
							<select id="select_penanda_tangan" required name="penanda_tangan" id="penanda_tangan" class="form-control">
								<option data-nama="<?= pengaturan()->nama_ketua ?>" data-nip="<?= pengaturan()->nip_ketua ?>" selected value="Ketua">Ketua (Default)</option>
								<option data-nama="<?= pengaturan()->nama_wakil ?>" data-nip="<?= pengaturan()->nip_wakil ?>">Wakil</option>
								<option data-nama="<?= pengaturan()->nama_panitera ?>" data-nip="<?= pengaturan()->nip_panitera ?>">Panitera</option>
								<option data-nama="<?= pengaturan()->nama_sekretaris ?>" data-nip="<?= pengaturan()->nip_sekretaris ?>">Sekretaris</option>
							</select>
						</div>
						<div class="col-md-4">
							<input id="input_nama_penanda_tangan" type="text" readonly class="form-control" name="nama_penanda_tangan" value="<?= pengaturan()->nama_ketua ?>">
						</div>
						<div class="col-md-4">
							<input id="input_nip_penanda_tangan" type="text" readonly class="form-control" name="nip_penanda_tangan" value="<?= pengaturan()->nip_ketua ?>">
						</div>
					</div>
					<center>
						<button type="submit" class="btn btn-success">Generate</button>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MODAL REFRENSI UMUM -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Referensi variable Umum</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					<strong>Info</strong>
					Klik referensi dibawah ini untuk mengisi kolom yang akan di isi.
				</div>
				<div class="row">
					<table class="table table-bordered table-hovered">
						<thead>
							<?php foreach ($this->db->get('pengaturan')->result() as $ppk => $ppv) { ?>
								<tr>
									<th><?= ucfirst(str_replace('_', ' ', $ppv->name))  ?></th>
									<th><?= $ppv->value ?></th>
									<th><button onclick="fetchVariableUmum('<?= $ppv->value ?>')" data-value="<?= $ppv->value ?>" data-bs-dismiss="modal" type="button" class="btn btn-sm btn-warning">Pilih</button></th>
								</tr>
							<?php } ?>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script>
	var globalSelectedInput = null;

	document.querySelector("#select_penanda_tangan").addEventListener('change', (e) => {
		document.querySelector("#input_nama_penanda_tangan").value = e.target.options[e.target.selectedIndex].dataset.nama

		document.querySelector("#input_nip_penanda_tangan").value = e.target.options[e.target.selectedIndex].dataset.nip
	})


	const steadyVariableUmum = (id) => {
		// document.querySelector("#input_" + id).value
		globalSelectedInput = "#input_" + id;
	}

	const fetchVariableUmum = (value) => {
		document.querySelector(globalSelectedInput).value = value
	}
</script>