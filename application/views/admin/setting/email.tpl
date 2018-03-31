{extends file='layout.tpl'}
{block name='content'}
	
	<h2 class="page-header">Pengaturan Email</h2>
	
	{if isset($success)}
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Berhasil disimpan !
		</div>
	{/if}
	
	<form action="{current_url()}" method="post">
		<div class="form-group">
			<label for="subject">Subjek</label>
			<input name="subject" type="text" class="form-control" value="{$email_subject}">
		</div>
		<div class="form-group">
			<label for="body">Isi Email</label>
			<div class="row">
				<div class="col-md-8">
					<textarea name="body" class="form-control" rows="10">{$email_body}</textarea>
				</div>
				{literal}
				<div class="col-md-4">
					<ul class="list-unstyled">
						<li><code>{NAMA}</code> : Nama mahasiswa</li>
						<li><code>{NIM}</code> : NIM mahasiswa</li>
						<li><code>{PROGRAM STUDI}</code> : Program studi mahasiswa</li>
						<li><code>{PERGURUAN TINGGI}</code> : Perguruan tinggi asal</li>
						<li><code>{USERNAME}</code> : Username untuk login</li>
						<li><code>{PASSWORD}</code> : Password untuk login</li>
					</ul>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#testEmailModal">Test Email</button>
				</div>
				{/literal}
			</div>
		</div>
			
		<legend>SMTP Server</legend>
		
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<label for="smtp_host">SMTP Host</label>
					<input name="smtp_host" type="text" class="form-control" value="{$smtp_host}">
				</div>
				<div class="col-md-1">
					<label for="smtp_port">Port</label>
					<input name="smtp_port" type="text" class="form-control" value="{$smtp_port}">
				</div>
				<div class="col-md-1">
					<label for="smtp_timeout">Timeout</label>
					<input name="smtp_timeout" type="text" class="form-control" value="{$smtp_timeout}">
				</div>
				<div class="col-md-2">
					<label for="smtp_crypto">Encryption</label>
					<select name="smtp_crypto" class="form-control">
						<option value="ssl" {if $smtp_crypto == 'ssl'}selected{/if}>SSL</option>
						<option value="tls" {if $smtp_crypto == 'tls'}selected{/if}>TLS</option>
					</select>
				</div>
			</div>
		</div>
					
		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Simpan" />
		</div>
	</form>
						
	<div class="modal fade" id="testEmailModal" tabindex="-1" role="dialog" aria-labelledby="testEmailModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tes Pengiriman Email</h4>
				</div>
				<div class="modal-body">
					<form action="" method="post" id="testEmailForm">
						<div class="form-group">
							<label for="email_to" class="control-label">Tujuan:</label>
							<input type="email" class="form-control" name="email_to">
						</div>
						<div class="form-group">
							<label for="email_username" class="control-label">SMTP Username :</label>
							<input type="text" class="form-control" name="email_username">
						</div>
						<div class="form-group">
							<label for="email_password" class="control-label">SMTP Password :</label>
							<input type="password" class="form-control" name="email_password">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="sendMessageButton">Send message</button>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script type="text/javascript">
		$('#sendMessageButton').on('click', function() {
			var dataPengiriman = $('#testEmailForm').serialize();
			$.ajax({
				type: 'POST',
				url: "{site_url('admin/setting/test-email')}",
				data: dataPengiriman,
				beforeSend: function() {
					$('#sendMessageButton').prop('disabled', true);
                },
				success: function (data, textStatus, jqXHR) {
                    if (data === '1') {
						alert('Pengiriman berhasil, Silahkan cek inbox email tujuan');
						$('#testEmailModal').modal('toggle');
						$('#sendMessageButton').prop('disabled', false);
					}
					else {
						alert('Pengiriman Gagal'); 
					}
                }
			});
		});
	</script>
{/block}