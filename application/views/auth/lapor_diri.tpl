{extends file='layout.tpl'}
{block name='head'}
	<link href="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css')}" rel='stylesheet' />
{/block}
{block name='content'}
	<h2 class="page-header">Lapor Diri</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			{if $smarty.server.REQUEST_METHOD == 'POST'}
				{if $search_result == 'NOT_FOUND'}
					<div class="alert alert-warning alert-dismissable" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<p>"{$smarty.post.nama}" tidak ditemukan di forlap. Silahkan ulangi pencarian.</p>
					</div>
				{else if $search_result == 'FORLAP_FOUND'}
					<div class="alert alert-success alert-dismissable" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<p>{$mahasiswa->nama} ditemukan. Silahkan klik Lanjut dibawah ini untuk meneruskan proses lapor diri.</p>
						<p><a href="{site_url('auth/registration-from-forlap')}?id={$mahasiswa->id}" class="btn btn-sm btn-default">Lanjut</a></p>
					</div>
				{else if $search_result == 'LOCAL_FOUND'}
					<div class="alert alert-info alert-dismissable" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<p>{$mahasiswa_local->nama_mahasiswa} ({$mahasiswa_local->nim}) sudah terdaftar dalam sistem. Silahkan klik Akunku untuk mendapatkan user login.</p>
						<p><a href="{site_url('akunku')}" class="btn btn-sm btn-default">Akunku</a></p>
					</div>
				{/if}
			{/if}
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				
				<div class="form-group">
					<label class="control-label col-md-2">Perguruan Tinggi</label>
					<div class="col-md-8">
						<input type="hidden" name="kode_pt" />
						<div class="input-group">
							<input type="text" class="form-control" id="pt" name="pt" required="" placeholder="Kata kunci nama perguruan tinggi" />
							<span class="input-group-btn">
								<button class="btn btn-default" id="btnClearPT">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</span>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-2">Program Studi</label>
					<div class="col-md-8">
						<select class="form-control" name="kode_prodi" required="">
							<option value="">-- Pilih Program Studi --</option>
							{foreach $pt_set as $pt}
								<option value="{$pt->kode_perguruan_tinggi}" {set_select('kode_perguruan_tinggi', $pt->kode_perguruan_tinggi)}>{$pt->nama_institusi}</option>
							{/foreach}
						</select>
					</div>
				</div>
					
				<div class="form-group">
					<label class="control-label col-md-2">Nama Lengkap</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="nama" value="{set_value('nama')}" required="" placeholder="Nama lengkap sesuai data forlap / ijazah" />
					</div>
				</div>
								
				<div class="form-group">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<input type="submit" class="btn btn-primary" value="Submit" />
					</div>
				</div>
					
			</form>
					
			<p>Apabila pencarian tidak mendapatkan hasil yang sesuai, Anda bisa melakukan pengecekan nama yang terdaftar di forlap dengan 
				membuka link <a href="https://forlap.ristekdikti.go.id">https://forlap.ristekdikti.go.id</a></p>
			
		</div>
		
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')}"></script>
	<script type="text/javascript">
		var inputKodePT = 'input[name="kode_pt"]';
		var inputKodeProdi = 'select[name="kode_prodi"]';
		
		$(document).ready(function() {
			
			$('#btnClearPT').on('click', function() {
				$(inputKodePT).val('');
				$('#pt').val('');
				$(inputKodeProdi).html('<option value="">-- Pilih Program Studi --</option>');
				return false;
			});
			
			$('#pt').autocomplete({
				source: '{site_url('auth/search-pt')}',
				minLength: 3,
				select: function(event, ui) {
					$(inputKodePT).val(ui.item.id);
					
					$.getJSON('{site_url('auth/get-list-prodi')}', 'kode_pt=' + ui.item.id, function(data) {
						
						$(inputKodeProdi).html('<option value="">-- Pilih Program Studi --</option>');
						$.each(data, function(key, val) {
							$(inputKodeProdi).append(new Option(val.value, val.id));
						});
					});
				}
			});
			
			
		});
	</script>
{/block}