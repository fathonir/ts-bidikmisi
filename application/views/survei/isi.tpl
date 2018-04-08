{extends file='layout.tpl'}
{block name='head'}
	<style type="text/css">
		.row-pertanyaan { border-top: 1px solid #ddd; }
		.table-pertanyaan > tbody > tr > td { border-top: none; vertical-align: top }
		.width-50 { width: 50px; }
		.width-350 { width: 350px; }
		span.error { color: red; }
		input.error { border: 1px solid red; }
	</style>
{/block}
{block name='content'}
	<h2 class="page-header">Form {$survei->nama_survei}</h2>
	
	<form action="{current_url()}" method="post" id="survei" class="form-horizontal">
		
		<legend><span style="color: red; font-size: 14px">F1</span> IDENTITAS</legend>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Nama</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->nama_mahasiswa}</p>
			</div>
			<label class="col-sm-2 control-label">Perguruan Tinggi</label>
			<div class="col-sm-4">
				<p class="form-control-static">
					{if $mahasiswa->perguruan_tinggi}
						{$mahasiswa->perguruan_tinggi->nama_institusi}
					{/if}
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Nomor Mahasiswa</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->nim}</p>
			</div>
			<label class="col-sm-2 control-label">Program Studi</label>
			<div class="col-sm-4">
				<p class="form-control-static">
					{if $mahasiswa->program_studi}
						{$mahasiswa->program_studi->nama_program_studi}
					{/if}
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">No Telp / HP</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->no_hp}</p>
			</div>
			<label class="col-sm-2 control-label">Tahun masuk</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->tahun_masuk}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Email</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->email}</p>
			</div>
			<label class="col-sm-2 control-label">Tahun Lulus</label>
			<div class="col-sm-4">
				<p class="form-control-static">{$mahasiswa->tahun_lulus}</p>
			</div>
		</div>
			
		<legend>TRACER STUDY</legend>
			
		<table class="table">
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
												<tr>
													{foreach $input->left_html_set as $html}
														<td>{$html}</td>
													{/foreach}
													<td>{$input->keterangan}</td>
													{foreach $input->right_html_set as $html}
														<td>{$html}</td>
													{/foreach}
												</tr>
												<tr>
													<td colspan="5" style="padding: 1px; text-align: center" id="jawabanErrorPlaceholder_{$input->name1}"></div></td>
													<td style="padding: 1px"></td>
													<td colspan="5" style="padding: 1px; text-align: center" id="jawabanErrorPlaceholder_{$input->name2}"></div></td>
												</tr>
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
										<tfoot>
											<tr>
												<td id='jawabanErrorPlaceholder_{$jawaban->id}'></td>
											</tr>
										</tfoot>
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
			$('#survei').validate({
				rules: {
					
					// Pertanyaan F2
					'f[1][1][F21]': { required: true },
					'f[1][2][F22]': { required: true },
					'f[1][3][F23]': { required: true },
					'f[1][4][F24]': { required: true },
					'f[1][5][F25]': { required: true },
					'f[1][6][F26]': { required: true },
					'f[1][7][F27]': { required: true },
					
					// Pertanyaan F3
					'f[2][8][F301]': { required: true },
					'f[2][8][F302]': {
						required: function() {
							return $('input[name="f[2][8][F301]"]:checked').val() === '1';
						},
						digits: true, min: 0
					},
					'f[2][8][F303]': {
						required: function() {
							return $('input[name="f[2][8][F301]"]:checked').val() === '2';
						},
						digits: true, min: 0
					},
					
					// Pertanyaan F18
					'f[3][9][F181]': { required: true, digits: true },
					'f[3][9][F182]': { required: true, digits: true },
					'f[3][9][F183]': { required: true, digits: true },
					'f[3][9][F183b]': {
						required: function() {
							return $('input[name="f[3][9][F183]"]').val() > 0;
						}
					},
					'f[3][10][F184]': { required: true, digits: true },
					'f[3][10][F185]': { required: true, digits: true },
					'f[3][10][F186]': { required: true, digits: true },
					'f[3][10][F187]': { required: true, digits: true },
					'f[3][10][F187b]': {
						required: function() {
							return $('input[name="f[3][10][F187]"]').val() > 0;
						}
					},
					
					// Pertanyaan F20
					// - Olahraga
					'f[4][11][F201]': { digits: true },
					'f[4][11][F202]': { digits: true },
					'f[4][11][F203]': { digits: true },
					// - Seni
					'f[4][12][F204]': { digits: true },
					'f[4][12][F205]': { digits: true },
					'f[4][12][F206]': { digits: true },
					// - Penalaran / Sains
					'f[4][13][F207]': { digits: true },
					'f[4][13][F208]': { digits: true },
					'f[4][13][F209]': { digits: true },
					
					// Pertanyaan F21 
					// - Olah raga
					'f[5][14][F211]': { digits: true },
					'f[5][14][F212]': { digits: true },
					'f[5][14][F213]': { digits: true },
					// - Seni
					'f[5][15][F214]': { digits: true },
					'f[5][15][F215]': { digits: true },
					'f[5][15][F216]': { digits: true },
					// - Penalaran
					'f[5][16][F217]': { digits: true },
					
					// Pertanyaan F22
					'f[6][17][F221]': { required: true },
					'f[6][18][F222]': { required: true },
					
					// Pertanyaan F4
					'f[7][19][F416]': {
						required: function() {
							return $('input[name="f[7][19][F415]"]:checked').length > 0;
						}
					},
					
					'f[8][20][F502]': {
						required: function() {
							return $('input[name="f[8][20][F501]"]:checked').val() === '1';
						}, 
						digits: true
					},
					'f[8][20][F503]': {
						required: function() {
							return $('input[name="f[8][20][F501]"]:checked').val() === '2';
						},
						digits: true
					},
					
					// Pertanyaan F6-F7
					'f[9][21][F6]': { digits: true },
					'f[10][22][F7]': { digits: true },
					'f[11][23][F7a]': { digits: true },
					
					// Pertanyan F8
					'f[12][24][F8]': { required: true },
					
					// Pertanyaan F9
					'f[13][25][F906]': {
						required: function() {
							return $('input[name="f[13][25][F905]"]:checked').length > 0;
						}
					},
					
					'f[14][26][F1002]': {
						required: function() {
							return $('input[name="f[14][26][F1001]"]:checked').val() === '5';
						}
					},
					
					'f[15][27][F1102]': {
						required: function() {
							return $('input[name="f[15][27][F1101]"]:checked').val() === '5';
						}
					},
					
					// Pertanyaan F13
					'f[16][28][F1301]': { digits: true },
					'f[16][28][F1302]': { digits: true },
					'f[16][28][F1303]': { digits: true },
					
					'f[17][29][F14]': { required: true },
					'f[18][30][F15]': { required: true },
					
					'f[19][31][F1614]': {
						required: function() {
							return $('input[name="f[19][31][F1613]"]:checked').length > 0;
						}
					},
					
					// Pertanyaan Radio 5 LR
					'f[20][32][F171]': { required: true }, 'f[20][32][F172b]': { required: true }, 
					'f[20][32][F173]': { required: true }, 'f[20][32][F174b]': { required: true }, 
					'f[20][32][F175]': { required: true }, 'f[20][32][F176b]': { required: true }, 
					'f[20][32][F175a]': { required: true }, 'f[20][32][F176ba]': { required: true }, 
					'f[20][32][F177]': { required: true }, 'f[20][32][F178b]': { required: true }, 
					'f[20][32][F179]': { required: true }, 'f[20][32][F1710b]': { required: true }, 
					'f[20][32][F1711]': { required: true }, 'f[20][32][F1712b]': { required: true }, 
					'f[20][32][F1713]': { required: true }, 'f[20][32][F1714b]': { required: true }, 
					'f[20][32][F1715]': { required: true }, 'f[20][32][F1716b]': { required: true }, 
					'f[20][32][F1717]': { required: true }, 'f[20][32][F1718b]': { required: true }, 
					'f[20][32][F1719]': { required: true }, 'f[20][32][F1720b]': { required: true }, 
					'f[20][32][F1721]': { required: true }, 'f[20][32][F1722b]': { required: true }, 
					'f[20][32][F1723]': { required: true }, 'f[20][32][F1724b]': { required: true }, 
					'f[20][32][F1725]': { required: true }, 'f[20][32][F1726b]': { required: true }, 
					'f[20][32][F1727]': { required: true }, 'f[20][32][F1728b]': { required: true }, 
					'f[20][32][F1729]': { required: true }, 'f[20][32][F1730b]': { required: true }, 
					'f[20][32][F1731]': { required: true }, 'f[20][32][F1732b]': { required: true }, 
					'f[20][32][F1733]': { required: true }, 'f[20][32][F1734b]': { required: true }, 
					'f[20][32][F1735]': { required: true }, 'f[20][32][F1736b]': { required: true }, 
					'f[20][32][F1737]': { required: true }, 'f[20][32][F1738b]': { required: true }, 
					'f[20][32][F1737a]': { required: true }, 'f[20][32][F1738ba]': { required: true }, 
					'f[20][32][F1739]': { required: true }, 'f[20][32][F1740b]': { required: true }, 
					'f[20][32][F1741]': { required: true }, 'f[20][32][F1742b]': { required: true }, 
					'f[20][32][F1743]': { required: true }, 'f[20][32][F1744b]': { required: true }, 
					'f[20][32][F1745]': { required: true }, 'f[20][32][F1746b]': { required: true }, 
					'f[20][32][F1747]': { required: true }, 'f[20][32][F1748b]': { required: true }, 
					'f[20][32][F1749]': { required: true }, 'f[20][32][F1750b]': { required: true }
				},
				errorElement: 'span',
				errorPlacement: function(error, element) {
					
					// Inputan di Radio
					if (element.data('jenis') === 'RADIO_TEXT' || 
						element.data('jenis') === 'TEXT' || 
						element.data('jenis') === 'TEXT_TEXT' ||
						element.data('jenis') === 'CHECKBOX_TEXT') {
						error.appendTo(element.parent());
					}
					else if (element.data('jenis') === 'RADIO_5_LR') {
						var jawabanErrorPlaceholder = $('#jawabanErrorPlaceholder_' + element.data('name'));
						error.appendTo(jawabanErrorPlaceholder);
					}
					else {
						var jawabanErrorPlaceholder = $('#jawabanErrorPlaceholder_' + element.data('id-jawaban'));
						error.appendTo(jawabanErrorPlaceholder);
					}
				}
			});
		});
	</script>
{/block}
