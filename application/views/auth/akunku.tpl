{extends file='layout.tpl'}
{block name='content'}
	<h2 class="page-header">Ambil Akun Tracer Study</h2>

	{if $smarty.post}
		{if !isset($account)}
			<div class="alert alert-danger alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Akun tidak ditemukan.
			</div>
		{/if}
	{/if}
	
	<div class="row">
		<div class="col-lg-6">
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				
				<div class="form-group">
					<label class="control-label col-md-4">Perguruan Tinggi</label>
					<div class="col-md-8">
						<select class="form-control" name="kode_perguruan_tinggi">
							<option value="">-- Pilih PT --</option>
							{foreach $pt_set as $pt}
								<option value="{$pt->kode_perguruan_tinggi}" {set_select('kode_perguruan_tinggi', $pt->kode_perguruan_tinggi)}>{$pt->nama_institusi}</option>
							{/foreach}
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-4">NIM / NPM</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="nim" value="{set_value('nim')}" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-4">Nama Lengkap</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="nama" value="{set_value('nama')}" />
					</div>
				</div>
	
				
					<div class="form-group">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							{if $smarty.post}
								{if !isset($account)}
									<a href="{current_url()}" class="btn btn-default">Ulangi</a>
								{/if}
							{else}
								<input type="submit" class="btn btn-primary" value="Ambil" />
							{/if}
						</div>
					</div>
				
				
			</form>
			
			{if $smarty.post}
				{if isset($account)}
					
					<div class="alert alert-success" role="alert">Berikut akun tracer bidikmisi anda. <a href="{site_url()}">Klik disini</a> untuk kembali ke halaman login</div>
					
					<div class="panel panel-success">
						<div class="panel-body">

							<div class="form-horizontal">

								<div class="form-group">
									<label class="control-label col-md-4">Username</label>
									<div class="col-md-4">
										<p class="form-control-static">{$account->username}</p>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-4">Password</label>
									<div class="col-md-4">
										<p class="form-control-static">{$account->password}</p>
									</div>
								</div>

							</div>

						</div>
					</div>
				{/if}
			{/if}
			
		</div>
			
		<div class="col-lg-6">
			<ul>
				<li>Isi nama lengkap bukan nama panggilan</li>
				<li>Jika data anda tidak ditemukan, maka data kelulusan anda belum terlaporkan ke pddikti. Silahkan menghubungi pihak pengelola bidikmisi di perguruan tinggi anda.</li>
				<li><a href="{site_url()}">Klik disini</a> untuk kembali ke halaman login</li>
			</ul>
		</div>
	</div>
	
{/block}