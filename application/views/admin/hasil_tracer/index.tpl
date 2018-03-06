{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	
	<h2 class="page-header">Hasil Tracer Study</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<table class="table table-bordered table-condensed table-striped" id="mahasiswaTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode PT</th>
						<th>NIM</th>
						<th>Nama</th>
						<th>Waktu Tracer</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			
		</div>
	</div>
	
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/js/jquery.dataTables.min.js')}"></script>
	<script type="text/javascript" src="{base_url('assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			$('#mahasiswaTable').dataTable({
				lengthMenu: [ 100, 250, 500, 1000 ],
				ajax: '{site_url('admin/hasil-tracer/data')}',
				columns:
				[
					{ data: null, defaultContent: '' },
					{ data: 'kode_pt' },
					{ data: 'nim' },
					{ data: 'nama_mahasiswa' },
					{ data: 'waktu_pelaksanaan' }
				],
				ordering: false
			});

		});
	</script>
{/block}