<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<style>
		.hello, .ddt {text-align:center; font-weight:bold;margin-top:12px;}
		
	</style>
	<title>Welcome!</title><?
	if (isset($handler->css) && is_array($handler->css) && count($handler->css)) {
		foreach ($handler->css as $css){
		?><link rel="stylesheet" type="text/css" href="<?=WEB_ROOT ?>/css/<?=$css?>.css?v=<?=STATIC_VERSION?>" /><?
		}
	}
	?>
	<?
	if (isset($handler->js) && is_array($handler->js) && count($handler->js)) {
		foreach ($handler->js as $js){
		?><script type="text/javascript" charset="UTF-8" src="<?=WEB_ROOT ?>/js/<?=$js?>?v=<?=STATIC_VERSION?>"></script>
	<?
		}
	}
	?>
</head>
<body>
	<div class="main center relative">
		<? if ($handler->info !== false):?>
			<? $r = $handler->info;?>
			<p>Загружено с url:</p>
			<p><?=$r['url']?></p>
			<hr>
			<p>Catalog:</p>
			<p><?=$r['catalog_id']?></p>
			<hr>
			<p>Data:</p>
			<p><textarea id="datas" style="width:99%" onclick="document.getElementById('datas').select()"><?=$r['datas']?></textarea></p>
			<hr>
			<p>Logs:</p>
			<p><?=$r['log']?></p>
			<hr>
		<? endif?>
	</div>
</body>
</html> 
