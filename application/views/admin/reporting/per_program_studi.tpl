{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/datatables.min.css')}" />
{/block}
{block name='content'}
	
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Rekap per Program Studi</h2>
			
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Program Studi</th>
						<th>Sudah</th>
						<th>Belum</th>
						<th>Total</th>
						<th></th>
						<th>30%</th>
						<th>Target</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data->nama_program_studi} <a href="{site_url('admin/reporting/per-perguruan-tinggi')}?kode_ps={$data->kode_program_studi}">[...]</a></td>
							<td class="text-center">{$data->sudah}</td>
							<td class="text-center">{$data->belum}</td>
							<td class="text-center"><strong>{$data->total}</strong></td>
							<td></td>
							<td class="text-center">{$data->t30}</td>
							<td class="text-center">{$data->target}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			
		</div>
	</div>
	
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/dataTables.min.js')}"></script>
	<script>
		$(document).ready(function() {
			$('.table').dataTable({
				stateSave: true,
				lengthMenu: [ 50, 100, 250 ]
			});
		});
	</script>
{/block}