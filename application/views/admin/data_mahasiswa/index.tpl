{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	
	<h2 class="page-header">Data Mahasiswa</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<table class="table table-bordered table-condensed table-striped" id="mahasiswaTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode PT</th>
						<th>Nama</th>
						<th>Tahun Masuk</th>
						<th>Tahun Lulus</th>
						<th>Email</th>
						<th>Telpon</th>
						<th>Username</th>
						<th>Password</th>
						<th>Status Tracer</th>
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
				ajax: '{site_url('admin/data-mahasiswa/data')}',
				columns:
				[
					{ data: null, defaultContent: '' },
					{ data: 'kode_pt' },
					{ data: 'nama_mahasiswa' },
					{ data: 'tahun_masuk' },
					{ data: 'tahun_lulus' },
					{ data: 'email' },
					{ data: 'no_hp' },
					{ data: 'username' },
					{ data: 'password_plain' },
					{
						data: function(row, type, val, meta) {
							if (row.waktu_pelaksanaan !== null)
								return '<label class="label label-success">SUDAH</label>';
							else
								return '<label class="label label-default">BELUM</label>';
						}
					}
				],
				ordering: false
			});
			
		});
	</script>
{/block}