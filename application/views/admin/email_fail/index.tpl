{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Data Email Gagal Kirim</h2>
	
	<a href="{site_url('admin/email-fail/add')}" class="btn btn-sm btn-success" style="margin-bottom: 10px">Tambah</a>
	
	<table class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Email</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $data_set as $data}
				<tr>
					<td>{$data@index + 1}</td>
					<td>{$data->email}</td>
					<td>
						<a href="{site_url('admin/email-fail/delete')}/{urlencode($data->email)}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	
{/block}