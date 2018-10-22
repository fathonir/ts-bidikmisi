{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/datatables.min.css')}" />
	<style type="text/css">
		/* Rekayasa Container */
		body > .container { margin-left: 20px; margin-right: 20px; width: auto; }
		#mahasiswaTable {
			font-size: 13px;
		}
		#mahasiswaTable tbody tr td:nth-child(2),
		#mahasiswaTable tbody tr td:nth-child(9),
		#mahasiswaTable tbody tr td:nth-child(11),
		#mahasiswaTable tbody tr td:nth-child(12){
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
						<th></th>
						<th>#</th>
						<th>Kode PT</th>
						<th>Prodi</th>
						<th>Mahasiswa</th>
						<th>Masuk</th>
						<th>Lulus</th>
						<th>Email</th>
						<th>Gagal</th>
						<th>Telpon</th>
						<th>Tracer</th>
						<th>Notif</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			
			<div class="text-center">
				<a href="{site_url('admin/reporting/data-csv/1')}" class="btn btn-default" target="_blank">Export CSV</a>
				<a href="{site_url('admin/reporting/data-csv/2')}" class="btn btn-default" target="_blank">Export CSV Format 2</a>
			</div>
			
		</div>
	</div>
	
	<div class="modal" id="editMahasiswaModal" tabindex="-1" role="dialog" aria-labelledby="editMahasiswaModal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4>Detail Mahasiswa</h4>
				</div>
				<div class="modal-body">
					<form id="editMahasiswaForm">
						<input type="hidden" name="id" value="" id="idMahasiswa2" />
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nama" class="control-label">Nama</label>
									<input type="text" class="form-control" name="nama_mahasiswa" />
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">NIM</label>
									<p class="form-control-static" name="nim"></p>
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">Perguruan Tinggi</label>
									<p class="form-control-static" name="nama_pt"></p>
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">Program Studi</label>
									<select name="program_studi" class="form-control"></select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nama" class="control-label">Username</label>
									<p class="form-control-static" name="username"></p>
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">Password</label>
									<p class="form-control-static" name="password_plain"></p>
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">No HP / Telp</label>
									<input type="text" class="form-control" name="no_hp" />
								</div>
								<div class="form-group">
									<label for="nama" class="control-label">Email</label>
									<input type="email" class="form-control" name="email" />
								</div>
							</div>
						</div>
					</form>		
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<button type="button" class="btn btn-danger" id="deleteButton">Hapus</button>
					</div>
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="saveButton">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="sendNotifModal" tabindex="-1" role="dialog" aria-labelledby="sendNotifModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Kirim Notifikasi ke </h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="jenis_notifikasi" class="control-label">Jenis Notif</label>
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
	
	<div class="modal" id="failNotifModal" tabindex="-1" role="dialog" aria-labelledby="failNotifModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Gagal Email </h4>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" >Kirim</button>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/dataTables.min.js')}"></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			var mahasiswaTable = $('#mahasiswaTable').DataTable({
				stateSave: true,
				lengthMenu: [ 10, 25, 50, 100, 250 ],
				processing: true,
				serverSide: true,
				ajax: {
					url: '{site_url('admin/data-mahasiswa/data')}',
					type: 'POST'
				},
				searchDelay: 1800,
				language: {
					processing: 'Loading gan...'
				},
				columns:
				[
					{ data: null, className: 'select-checkbox', defaultContent: '', orderable: false, searchable: false },
					{ data: 'no', orderable: true, searchable: false },
					{ data: 'nama_pt', orderable: true },
					{ data: 'nama_prodi', orderable: true },
					{ data: 'nama_mahasiswa', orderable: true },
					{ data: 'tahun_masuk', orderable: false, searchable: false },
					{ data: 'tahun_lulus', orderable: false, searchable: false },
					{ data: 'email', orderable: false },
					{ data: 'email_fail', orderable: false, searchable: false },
					{ data: 'no_hp', orderable: false, searchable: false },
					{
						data: function(row, type, val, meta) {
							if (row.waktu_pelaksanaan !== null)
								return '<i class="glyphicon glyphicon-ok"></i>';
							else
								return null;
						},
						orderable: false
					},
					{ data: 'jumlah_notif', orderable: false },
					{
						data: function(row) {
							return '<button class="btn btn-xs btn-success" data-toggle="modal" data-target="#editMahasiswaModal" data-id="'+row.id+'">'+
								'<i class="glyphicon glyphicon-pencil"></i></button>';
						},
						orderable: false
					},
					{
						data: function(row) {
							return '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#sendNotifModal" ' +
								'data-id="'+row.id+'" data-nama="'+row.nama_mahasiswa+'" data-email="'+row.email+'" data-telp="'+row.no_hp+'">' +
								'<i class="glyphicon glyphicon-envelope"></i></button>';
						},
						orderable: false
					}
				],
				createdRow: function(row, data, dataIndex) {
					$(row).attr('id', 'mahasiswa_'+data.id);
				},
				select: {
					style: 'multi',
					selector: 'td:first-child'
				},
				deferRender: true
			});
			
			$('#sendNotifModal').on('show.bs.modal', function (event) {
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
						var notifTD = $('#mahasiswa_' + $('#idMahasiswa').val()).children('td:nth-last-child(3)');
						var notifCount = notifTD.html();
						notifTD.html(parseInt(notifCount) + 1);
						$('#sendNotifModal').modal('toggle');
					}
				});
			});
			
			$('#editMahasiswaModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				
				$.ajax({
					type: 'GET',
					url: "{site_url('admin/data-mahasiswa/get-mahasiswa')}/" + button.data('id'),
					dataType: 'json',
					success: function(data) {
						$('#idMahasiswa2').val(button.data('id'));
						$('input[name="nama_mahasiswa"]').val(data.nama_mahasiswa);
						$('p[name="nim"]').html(data.nim);
						$('p[name="nama_pt"]').html(data.nama_pt);
						$('input[name="email"]').val(data.email);
						$('input[name="no_hp"]').val(data.no_hp);
						$('p[name="username"]').html(data.username);
						$('p[name="password_plain"]').html(data.password_plain);
						
						// Kosongi
						$('select[name="program_studi"]').html(null);
						// Ambil data Prodi
						$.getJSON('{site_url('auth/get-list-prodi')}', 'kode_pt=' + data.kode_perguruan_tinggi, function(dataProdi) {
							$.each(dataProdi, function(key, val) {
								$('select[name="program_studi"]').append(new Option(val.value, val.id, false, (val.id.trim() == data.kode_prodi)));
							});
						});
					}
				});
				
			});
			
			$('#saveButton').on('click', function() {
				$.ajax({
					type: 'POST',
					url: "{site_url('admin/data-mahasiswa/update-mahasiswa')}",
					data: $('#editMahasiswaForm').serialize(),
					success: function(data) {
						if (data === '1') {
							var namaCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(5)');
							var prodiCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(4)');
							var emailCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(8)');
							var nohpCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(10)');
							namaCell.html($('input[name="nama_mahasiswa"]').val());
							prodiCell.html($('select[name="program_studi"] option:selected').text());
							emailCell.html($('input[name="email"]').val());
							nohpCell.html($('input[name="no_hp"]').val());
							alert('Data berhasil di update');
						}
						else {
							alert('Ada kesalahan sistem ketika update');
						}
						$('#editMahasiswaModal').modal('toggle');
					}
				});
			});
			
			$('#deleteButton').on('click', function() {
				if (confirm("Apakah data ini akan dihapus ?")) {
					$.ajax({
						type: 'POST',
						url: "{site_url('admin/data-mahasiswa/delete-mahasiswa')}",
						data: $('#editMahasiswaForm').serialize(),
						success: function(data) {
							if (data === '1') {
								alert('Data berhasil di hapus');
								mahasiswaTable.row($('#mahasiswa_' + $('#idMahasiswa2').val())).remove().draw();
							}
							else {
								alert('Ada kesalahan sistem ketika hapus');
							}
							$('#editMahasiswaModal').modal('toggle');
						}
					});
				}
			});
			
		});
	</script>
{/block}