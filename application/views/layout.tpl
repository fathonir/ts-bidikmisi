{doctype('html5')}
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Tracer Study Bidikmisi</title>
		{if ENVIRONMENT == 'development'}
			<link href="{base_url('assets/css/bootstrap.min.css')}" rel="stylesheet"/>
		{/if}
		{if ENVIRONMENT == 'production'}
			<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		{/if}
		<link href="{base_url('assets/css/site.css')}" rel="stylesheet"/>
		{block name='head'}
		{/block}
	</head>
	<body>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{base_url()}"><img src="{base_url()}assets/img/logo-ts.png" style="height: 30px" /></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					
					{if $ci->session->user}
						
						{if $ci->session->user->tipe_user == 99}
							<ul class="nav navbar-nav">
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengaturan <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="{site_url('admin/master-survei')}">Survei</a></li>
										<li><a href="{site_url('admin/setting/email')}">Email</a></li>
										<li><a href="{site_url('admin/setting/email-login')}">Email Login</a></li>
										<li><a href="#">SMS</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bidikmisi <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="{site_url('admin/data-mahasiswa')}">Data Mahasiswa</a></li>
										<li><a href="{site_url('admin/hasil-tracer')}">Data Hasil Tracer</a></li>
										<li class="divider" role="separator"></li>
										<li><a href="{site_url('admin/email-fail')}">Data Email Gagal</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="{site_url('admin/reporting/per-program-studi')}">Per Program Studi</a></li>
										<li><a href="{site_url('admin/reporting/per-perguruan-tinggi')}">Per Perguruan Tinggi</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utility <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="{site_url('admin/utility/generate-user-login')}">Generate User Login</a></li>
									</ul>
								</li>
							</ul>
						{/if}
						
						{if $ci->session->user->tipe_user == 1}
							<ul class="nav navbar-nav">
								<li><a href="{site_url('home')}">Biodata</a></li>
								<li><a href="{site_url('survei/isi')}">Isi Tracer</a></li>
							</ul>
						{/if}
						
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="{site_url('auth/logout')}">Logout ({$ci->session->user->username})</a>
							</li>
						</ul>	
					{/if}

				</div><!--/.nav-collapse -->
			</div>
		</nav>

		<!-- Begin page content -->
		<div class="container">
			{block name='content'}
			{/block}
		</div>

		<footer class="footer">
			<div class="container">
				<p class="text-center">&copy; {date('Y')} Direktorat Jenderal Pembelajaran dan Kemahasiswaan<br/>
					Gedung D Lt 7, Jl. Jenderal Sudirman, Pintu I Senayan, Daerah Khusus Ibukota Jakarta 10270, Indonesia</p>
			</div>
		</footer>

		{if ENVIRONMENT == 'development'}
			<script src="{base_url('assets/js/jquery-3.3.1.min.js')}"></script>
			<script src="{base_url('assets/js/bootstrap.min.js')}"></script>
		{/if}
		{if ENVIRONMENT == 'production'}
			<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		{/if}
		{block name='footer-script'}
		{/block}
	</body>
</html>