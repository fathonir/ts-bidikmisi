{extends file='layout.tpl'}
{block name='head'}
	<style type="text/css">
		.width-50 { width: 50px; }
		.width-350 { width: 350px; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Form {$survei->nama_survei}</h2>
	
	<form action="{current_url()}" method="post" id="survei">
		
		<table class="table table-striped" style="margin-bottom: 0">
			<thead>
				<tr>
					<th colspan="3">IDENTITAS</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><span style="color: red">F1</span></td>
					<td style="width: 40%">Nomor Mahasiswa</td>
					<td>{$mahasiswa->nim}</td>
				</tr>
				<tr>
					<td></td>
					<td>Kode PT</td>
					<td>{$mahasiswa->kode_pt}</td>
				</tr>
				<tr>
					<td></td>
					<td>Tahun Lulus</td>
					<td>{$mahasiswa->tahun_lulus}</td>
				</tr>
				<tr>
					<td></td>
					<td>Kode Prodi</td>
					<td>{$mahasiswa->kode_prodi}</td>
				</tr>
				<tr>
					<td></td>
					<td>Nama</td>
					<td>{$mahasiswa->nama_mahasiswa}</td>
				</tr>
				<tr>
					<td></td>
					<td>Nomer Telp / HP</td>
					<td>{$mahasiswa->no_hp}</td>
				</tr>
				<tr>
					<td></td>
					<td>Alamat Email</td>
					<td>{$mahasiswa->email}</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table">
			<thead>
				<tr>
					<th colspan="3">TRACER STUDY</th>
				</tr>
			</thead>
			<tbody>
				{foreach $survei->pertanyaan_set as $pertanyaan}
					<tr>
						<td style="vertical-align: top">
							{if !empty($pertanyaan->no_view)}
								<span style="color: red">{$pertanyaan->no_view}</span>
							{else}
								<span style="color: red">{$pertanyaan->no}</span>
							{/if}
						</td>
						<td style="vertical-align: top; width: 40%">
							{$pertanyaan->pertanyaan}
						</td>
						<td style="vertical-align: top;">
							{foreach $pertanyaan->jawaban_set as $jawaban}
								{if $jawaban->jenis_jawaban == 'SINGLE'}
									{$input = $jawaban->input_set[0]}
									{$input->html}
								{else if $jawaban->jenis_jawaban == 'MULTI_CHOICE_LR'}
									<table class="table table-condensed" style="font-size: 13px">
										<thead>
											<tr>
												<th class="text-center" colspan="5">A</th>
												<th></th>
												<th class="text-center" colspan="5">B</th>
											</tr>
											<tr>
												<th class="text-center" colspan="2">Sangat<br/>Rendah</th>
												<th></th>
												<th class="text-center" colspan="2">Sangat<br/>Tinggi</th>
												<th></th>
												<th class="text-center" colspan="2">Sangat<br/>Rendah</th>
												<th></th>
												<th class="text-center" colspan="2">Sangat<br/>Tinggi</th>
											</tr>
											<tr>
												<th style="width: 6%">1</th>
												<th style="width: 6%">2</th>
												<th style="width: 6%">3</th>
												<th style="width: 6%">4</th>
												<th style="width: 6%">5</th>
												<th style="width: 40%"></th>
												<th style="width: 6%">1</th>
												<th style="width: 6%">2</th>
												<th style="width: 6%">3</th>
												<th style="width: 6%">4</th>
												<th style="width: 6%">5</th>
											</tr>
										</thead>
										<tbody>
											{foreach $jawaban->input_set as $input}
												{$input->html}
											{/foreach}
										</tbody>
									</table>
								{else}
									<table class="table table-condensed" style="font-size: 13px">
										{if $jawaban->keterangan != ''}
											<thead>
												<tr>
													<th>{$jawaban->keterangan}</th>
												</tr>
											</thead>
										{/if}
										<tbody>
											{foreach $jawaban->input_set as $input}
												<tr>
													{if $input->jenis_input == 'RADIO' or $input->jenis_input == 'RADIO_TEXT'}
														<td class="radio" style="margin: 0; padding: 2px">
															<label>
																{$input->html}
															</label>
														</td>
													{/if}
													{if $input->jenis_input == 'CHECKBOX' or $input->jenis_input == 'CHECKBOX_TEXT'}
														<td class="checkbox" style="margin: 0; padding: 2px">
															<label>
																{$input->html}
															</label>
														</td>
													{/if}
													{if $input->jenis_input == 'TEXT' or $input->jenis_input == 'TEXT_TEXT'}
														<td style="margin: 0; padding: 2px">
															{$input->html}
														</td>
													{/if}
												</tr>
											{/foreach}
										</tbody>
									</table>
								{/if}
									
							{/foreach}
						</td>
					</tr>					
				{/foreach}
				<tr>
					<td colspan="3" class="text-center"><input type="submit" value="Simpan" class="btn btn-primary"/></td>
				</tr>
			</tbody>
		</table>
				
	</form>
{/block}
{block name='footer-script'}
	<script src="{base_url()}assets/jquery-validation/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/* Validation */
			/*
			$('#survei').validate({
				rules: {
					"f[1][1][F21]": 'required'
				},
				errorPlacement: function(error, element) {
					// element.parent().parent().append(error);
					var tbody = element.parentsUntil('table')[3];
					var tr = $(tbody).append('<tr><td></td></tr>');
					$(tr).append(error);
				}
			});
			*/
		});
	</script>
{/block}