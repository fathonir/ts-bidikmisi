{extends file='layout.tpl'}
{block name='content'}
	<h2 class="page-header">Login Tracer Study Bidikmisi</h2>

	<div class="row">
        <div class="col-lg-5">
			<form action="{current_url()}" method="post">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><strong>Login</strong></h3></div>
					<div class="panel-body">
						{if $ci->session->flashdata('failed_login')}
							<div class="alert alert-danger" role="alert">{$ci->session->flashdata('failed_login')}</div>
						{/if}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<div class="form-group">
							<label for="captcha">Captcha</label>
							<p class="form-control-static">{$img_captcha}</p>
							<input type="text" class="form-control" id="captcha" name="captcha">
						</div>
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				</div>
			</form>
        </div>
				
		<div class="col-lg-5">
			
			<h3>Kontak Person</h3>
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td>Adi</td>
						<td>0858 7897 7702</td>
					</tr>
					<tr>
						<td>Jehan</td>
						<td>0853 5979 1896</td>
					</tr>
					<tr>
						<td>Ryan</td>
						<td>0823 6396 3028</td>
					</tr>
					<tr>
						<td>Cecep</td>
						<td>0856 2423 2692</td>
					</tr>
					<tr>
						<td>Yeni</td>
						<td>0838 7662 6802</td>
					</tr>
					<tr>
						<td>Andri</td>
						<td>0823 8572 1293</td>
					</tr>
					<tr>
						<td>Ghio</td>
						<td>0852 7258 2224</td>
					</tr>
				</tbody>
			</table>
			
			<h3 style="margin-top: 10px">Hal yang perlu diperhatikan</h3>
			<ul>
				<li>Jika tidak mengetahui akun login, silahkan buka link berikut ini : <a href="{site_url('/akunku')}">{site_url('/akunku')}</a></li>
				<li>Username & password yang resmi hanya yang berasal dari Kemenristekdikti yang dikirim melalui email.</li>
				<li>Pastikan mengisi isian captcha agar bisa login</li>
			</ul>
		</div>
    </div>
{/block}