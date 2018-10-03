{extends file='layout.tpl'}
{block name='content'}
	
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Rekap per Tahun Lulus</h2>
			
			<canvas id="myChart" width="100" height="40"></canvas>
		</div>
	</div>
	
{/block}
{block name='footer-script'}
	{if ENVIRONMENT == 'development'}
		<script src="{base_url('assets/Chart.js/Chart.js')}"></script>
	{/if}
	{if ENVIRONMENT == 'production'}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	{/if}
	<script type='text/javascript'>
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: {$labels},
				datasets: [{
					label: 'Mahasiswa',
					data: {$dataset_1},
					backgroundColor: 'rgba(100, 100, 255, 1)'
				},
				{
					label: 'Tracer',
					data: {$dataset_2},
					backgroundColor: 'rgba(255, 255, 0, 1)'
				}]
			}
		});
	</script>
{/block}