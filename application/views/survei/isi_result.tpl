{extends file='layout.tpl'}
{block name='content'}
	
	{$result = $ci->session->flashdata('result')}
	<h1 class="page-header">{$result['page_title']}</h1>
	<div class="row">
		<div class="col-lg-12">
			
			{if $result['message']}
				{if $result['is_success']}
					<div class="alert alert-success" role="alert">
						<p>{$result['message']}</p>
						{if isset($result['link_1'])}<p>{$result['link_1']}</p>{/if}
						{if isset($result['link_2'])}<p>{$result['link_2']}</p>{/if}
					</div>
				{else}
					<div class="alert alert-danger" role="alert">
						<p>{$result['message']}</p>
						{if isset($result['link_1'])}<p>{$result['link_1']}</p>{/if}
						{if isset($result['link_2'])}<p>{$result['link_2']}</p>{/if}
					</div>
				{/if}
				
			{/if}
			
		</div>
	</div>
	
{/block}