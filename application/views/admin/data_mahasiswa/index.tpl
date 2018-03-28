{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/css/dataTables.bootstrap.min.css')}" />
	<style type="text/css">
		/* Rekayasa Container */
		body > .container { margin-left: 20px; margin-right: 20px; width: auto; }
		#mahasiswaTable {
			font-size: 13px;
		}
		#mahasiswaTable thead tr th,
		#mahasiswaTable tbody tr td { padding: 3px 4px; }
		#mahasiswaTable tbody tr td:nth-last-child(2),
		#mahasiswaTable tbody tr td:nth-last-child(3) {
			text-align: center;
		}
		span.angkatan {
			font-size: 12px;
			color: #777;
		}
	</style>
{/block}
{block name='content'}
	
	<h2 class="page-header">Data Mahasiswa</h2>
	
	<div class="row">
		<div class="col-lg-12">
			
			<table class="table table-bordered table-condensed table-striped table-hover" id="mahasiswaTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode PT</th>
						<th>Prodi</th>
						<th>Mahasiswa</th>
						<th>Masuk</th>
						<th>Lulus</th>
						<th>Email</th>
						<th>Telpon</th>
						<th>Username</th>
						<th>Password</th>
						<th>Tracer</th>
						<th>Notif</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			
		</div>
	</div>
	
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Kirim Notifikasi ke </h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Jenis Notif</label>
					<select name="jenis_notifikasi" class="form-control">
						<option value="email" id="emailMahasiswa">Email</option>
						<option value="telp" id="telpMahasiswa">Telp</option>
						<option value="sms" id="smsMahasiswa">SMS</option>
						<option value="lainnya">Lainnya</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="kirimButton">Kirim</button>
				<input type="hidden" name="id" value="" id="idMahasiswa"/>
			</div>
		</div>
	</div>
</div>
	
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/js/jquery.dataTables.min.js')}"></script>
	<script type="text/javascript" src="{base_url('assets/js/dataTables.bootstrap.min.js')}"></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			$('#mahasiswaTable').dataTable({
				stateSave: true,
				lengthMenu: [ 25, 50, 100, 250 ],
				ajax: '{site_url('admin/data-mahasiswa/data')}',
				columns:
				[
					{ data: 'no' },
					{ data: 'kode_pt' },
					{ data: 'kode_prodi' },
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
								return null;
						}
					},
					{ data: 'jumlah_notif' },
					{
						data: function(row) {
							return '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal" ' +
								'data-id="'+row.id+'" data-nama="'+row.nama_mahasiswa+'" data-email="'+row.email+'" data-telp="'+row.no_hp+'">' +
								'Kirim Notif</button>';
						}
					}
				],
				createdRow: function(row, data, dataIndex) {
					$(row).attr('id', 'mahasiswa_'+data.id);
				},
				ordering: false
			});
			
			$('#exampleModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget); // Button that triggered the modal
				var modal = $(this);
				modal.find('.modal-title').text('Kirim Notifikasi ke ' + button.data('nama'));
				modal.find('#emailMahasiswa').html('Email (' + button.data('email') + ')');
				modal.find('#telpMahasiswa').html('Telp (' + button.data('telp') + ')');
				modal.find('#smsMahasiswa').html('SMS (' + button.data('telp') + ')');
				modal.find('#idMahasiswa').val(button.data('id'));
			});
			
			$('#kirimButton').on('click', function() {
				$.ajax({
					type: 'POST',
					url: "{site_url('admin/data-mahasiswa/update-notifikasi')}",
					data: 'id='+$('#idMahasiswa').val()+'&jenis='+$('select[name="jenis_notifikasi"]').val(),
					success: function() {
						var notifTD = $('#mahasiswa_' + $('#idMahasiswa').val()).children('td:nth-child(11)');
						var notifCount = notifTD.html();
						notifTD.html(parseInt(notifCount) + 1);
						$('#exampleModal').modal('toggle');
					}
				});
				
			});
			
		});
	</script>
{/block}