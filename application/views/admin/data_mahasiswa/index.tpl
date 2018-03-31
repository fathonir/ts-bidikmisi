{extends file='layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/datatables.min.css')}" />
	<style type="text/css">
		/* Rekayasa Container */
		body > .container { margin-left: 20px; margin-right: 20px; width: auto; }
		#mahasiswaTable {
			font-size: 13px;
		}
		#mahasiswaTable thead tr th,
		#mahasiswaTable tbody tr td { }
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
						<th></th>
						<th>#</th>
						<th>Kode PT</th>
						<th>Prodi</th>
						<th>Mahasiswa</th>
						<th>Masuk</th>
						<th>Lulus</th>
						<th>Email</th>
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
								<p class="form-control-static" name="nama_mahasiswa"></p>
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">NIM</label>
								<p class="form-control-static" name="nim"></p>
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">Email</label>
								<input type="email" class="form-control" name="email" />
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">No HP / Telp</label>
								<input type="text" class="form-control" name="no_hp" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama" class="control-label">Perguruan Tinggi</label>
								<p class="form-control-static" name="pt"></p>
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">Program Studi</label>
								<p class="form-control-static" name="prodi"></p>
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">Tahun masuk</label>
								<p class="form-control-static" name="tahun_masuk"></p>
							</div>
							<div class="form-group">
								<label for="nama" class="control-label">Tahun Lulus</label>
								<p class="form-control-static" name="tahun_lulus"></p>
							</div>
						</div>
					</div>
				</form>		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="saveButton">Simpan</button>
			</div>
		</div>
	</div>
</div>
	
{/block}
{block name='footer-script'}
	<script type="text/javascript" src="{base_url('assets/dataTables.min.js')}"></script>
	<script type='text/javascript'>
		$(document).ready(function() {
			
			$('#mahasiswaTable').dataTable({
				stateSave: true,
				lengthMenu: [ 10, 25, 50, 100, 250 ],
				ajax: '{site_url('admin/data-mahasiswa/data')}',
				columns:
				[
					{ data: null, className: 'select-checkbox', defaultContent: '' },
					{ data: 'no' },
					{ data: 'kode_pt' },
					{ data: 'kode_prodi' },
					{ data: 'nama_mahasiswa' },
					{ data: 'tahun_masuk' },
					{ data: 'tahun_lulus' },
					{ data: 'email' },
					{ data: 'no_hp' },
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
							return '<button class="btn btn-xs btn-success" data-toggle="modal" data-target="#editMahasiswaModal" data-id="'+row.id+'">'+
								'<i class="glyphicon glyphicon-pencil"></i></button>';
						}
					},
					{
						data: function(row) {
							return '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#sendNotifModal" ' +
								'data-id="'+row.id+'" data-nama="'+row.nama_mahasiswa+'" data-email="'+row.email+'" data-telp="'+row.no_hp+'">' +
								'<i class="glyphicon glyphicon-envelope"></i></button>';
						}
					}
				],
				createdRow: function(row, data, dataIndex) {
					$(row).attr('id', 'mahasiswa_'+data.id);
				},
				ordering: false,
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
						var notifTD = $('#mahasiswa_' + $('#idMahasiswa').val()).children('td:nth-child(11)');
						var notifCount = notifTD.html();
						notifTD.html(parseInt(notifCount) + 1);
						$('#sendNotifModal').modal('toggle');
					}
				});
			});
			
			$('#editMahasiswaModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				var modal = $(this);
				
				$.ajax({
					type: 'GET',
					url: "{site_url('admin/data-mahasiswa/get-mahasiswa')}/" + button.data('id'),
					dataType: 'json',
					success: function(data) {
						$('#idMahasiswa2').val(button.data('id'));
						$('p[name="nama_mahasiswa"]').html(data.nama_mahasiswa);
						$('p[name="nim"]').html(data.nim);
						$('input[name="email"]').val(data.email);
						$('input[name="no_hp"]').val(data.no_hp);
						$('p[name="pt"]').html(data.kode_pt);
						$('p[name="prodi"]').html(data.kode_prodi);
						$('p[name="tahun_masuk"]').html(data.tahun_masuk);
						$('p[name="tahun_lulus"]').html(data.tahun_lulus);
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
							var emailCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(8)');
							var nohpCell = $('#mahasiswa_' + $('#idMahasiswa2').val()).children('td:nth-child(9)');
							emailCell.html($('input[name="email"]').val());
							nohpCell.html($('input[name="no_hp"]').val());
						}
						else {
							alert('Ada kesalahan sistem ketika update');
						}
						$('#editMahasiswaModal').modal('toggle');
					}
				});
			});
			
		});
	</script>
{/block}