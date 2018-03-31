{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Pengaturan Email Login</h2>
	
	{if isset($success)}
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Berhasil disimpan !
		</div>
	{/if}
	
	<form action="{current_url()}" method="post">
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label for="email_username">SMTP Username</label>
					<input name="email_username" type="text" class="form-control" value="{$email_username}">
				</div>
				<div class="form-group">
					<label for="email_password">SMTP Password</label>
					<input name="email_password" type="password" class="form-control" value="{$email_password}">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</div>
		
	</form>
	
{/block}