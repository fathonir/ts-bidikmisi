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
			<h3 style="margin-top: 10px">Hal yang perlu diperhatikan</h3>
			<ul>
				<li>Username & password yang resmi hanya yang berasal dari Kemenristekdikti.</li>
				<li>Pastikan mengisi isian captcha agar bisa login</li>
				<li>Ketika mengganti password selalu gunakan password yang sulit ditebak</li>
				<li>Jangan membagikan password ke sembarang orang</li>
				<li>Selalu Logout setelah menggunakan sistem</li>
			</ul>
		</div>
    </div>
{/block}