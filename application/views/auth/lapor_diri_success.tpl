{extends file='layout.tpl'}
{block name='content'}
	<h2 class="page-header">Lapor Diri</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<div class="alert alert-success" role="alert">Data anda telah masuk ke sistem. Berikut akun tracer bidikmisi anda. <a href="{site_url()}">Klik disini</a> untuk kembali ke halaman login</div>
					
			<div class="panel panel-success">
				<div class="panel-body">

					<div class="form-horizontal">

						<div class="form-group">
							<label class="control-label col-md-4">Nama</label>
							<div class="col-md-4">
								<p class="form-control-static">{$mahasiswa->nama_mahasiswa}</p>
							</div>
						</div>
							
						<div class="form-group">
							<label class="control-label col-md-4">NIM</label>
							<div class="col-md-4">
								<p class="form-control-static">{$mahasiswa->nim}</p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-4">Username</label>
							<div class="col-md-4">
								<p class="form-control-static">{$new_user->username}</p>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Password</label>
							<div class="col-md-4">
								<p class="form-control-static">{$new_user->password_plain}</p>
							</div>
						</div>

					</div>

				</div>
			</div>
			
		</div>
	</div>
{/block}