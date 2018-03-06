{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Selamat Datang di Tracer Study Bidikmisi</h2>
	
	<div class="row">
		<div class="col-lg-8 col-md-10 col-sm-12">
			
			<table class="table table-condensed table-striped">
				<tbody>
					<tr>
						<td>NIM</td>
						<td>{$mahasiswa->nim}</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>{$mahasiswa->nama_mahasiswa}</td>
					</tr>
					<tr>
						<td>Kode Lulusan</td>
						<td>{$mahasiswa->kode_lulusan}</td>
					</tr>
					<tr>
						<td>Kode PT</td>
						<td>{$mahasiswa->kode_pt}</td>
					</tr>
					<tr>
						<td>Kode Prodi</td>
						<td>{$mahasiswa->kode_prodi}</td>
					</tr>
					<tr>
						<td>Tahun Masuk</td>
						<td>{$mahasiswa->tahun_masuk}</td>
					</tr>
					<tr>
						<td>Tahun Lulus</td>
						<td>{$mahasiswa->tahun_lulus}</td>
					</tr>
				</tbody>
			</table>
			
		</div>
	</div>
	
{/block}