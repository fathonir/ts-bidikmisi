{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Master Survei</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama Tracer</th>
						<th>Keterangan</th>
						<th class="text-center">Jumlah Pertanyaan</th>
						<th class="text-center">Kode Tabel</th>
						<TH class="text-center">Status Tabel</TH>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->nama_survei}</td>
							<td>{$data->deskripsi}</td>
							<td class="text-center">{$data->jumlah_pertanyaan}</td>
							<td class="text-center">{$data->kode_tabel}</td>
							<td class="text-center">
								{if $data->tabel_exists == 't'}
									<span class="label label-success">ADA</span>
								{else}
									<span class="label label-default">TIDAK ADA</span>
								{/if}
							</td>
							<td>
								{if $data->tabel_exists == 'f'}
									<a href="{site_url('admin/master-survei/generate-table-ts')}?id={$data->id}" class="btn btn-xs btn-warning">Generate Tabel TS</a>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
	</div>
	
{/block}