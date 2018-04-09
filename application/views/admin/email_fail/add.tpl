{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Tambah Email Gagal Kirim</h2>
	
	<form action="{current_url()}" method="post">
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<label for="email">Email</label>
					<input name="email" type="text" class="form-control" value="">
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Simpan</button>
			<a href="{site_url('admin/email-fail')}" class="btn btn-default">Kembali</a>
		</div>
	</form>
	
{/block}