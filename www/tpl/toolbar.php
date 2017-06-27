<? if(sess('uid')):?>
<ul class="inline left"><?
	$links = array(
		'/'  => 'Main_page',
		WEB_ROOT . '/console' => 'your_programs',
		'current_task' => 'CurrentTask',
		WEB_ROOT . '/tasklist' => 'TaskList',
		WEB_ROOT . '/quick_start' => 'QuickStart',
		WEB_ROOT . '/text_editor' => 'text_editor',
		WEB_ROOT . '/resources' => 'resources'
	);
?><? foreach ($links as $link => $langkey): ?>
<? if ('/' . $app->base_url != $link):?>
	<? if ($link != 'current_task'):?>
		<li><a href="<?=$link?>" <?if ($link == '#'):?>onclick="alert('In process...'); return false;"<? endif?>><?=$lang[$langkey]?></a></li>
	<?else:?>
		<li><a href="#" id="getCurrentTask"><?=$lang[$langkey]?></a></li>
	<?endif?>
<? endif?>
<? endforeach?>
</ul>
<div class="right">
	<ul class="inline">
		<li><?=$app->user_name?> <?=$app->user_surname ?></li>
		<li><a href="<?=WEB_ROOT?>/login?action=logout"><?=$lang['Exit']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? else: ?>
<ul class="inline left"><?
	$links = array(
		'/'  => 'Main_page',
		WEB_ROOT . '/console' => 'your_programs',
		'current_task' => 'CurrentTask',
		WEB_ROOT . '/tasklist' => 'TaskList',
		WEB_ROOT . '/quick_start' => 'QuickStart',
		WEB_ROOT . '/text_editor' => 'text_editor'
	);
?><? foreach ($links as $link => $langkey): ?>
<? if ('/' . $app->base_url != $link):?>
	<? if ($link != 'current_task'):?>
		<li><a href="<?=$link?>" <?if ($link == '#'):?>onclick="alert('In process...'); return false;"<? endif?>><?=$lang[$langkey]?></a></li>
	<?else:?>
		<li><a href="#" id="getCurrentTask"><?=$lang[$langkey]?></a></li>
	<?endif?>
<? endif?>
<? endforeach?>
</ul>
<div class="right">
	<ul class="inline">
		<li><a href="javascript:;" id="regLink"><?=$lang['SignUp']?></a></li>
		<li><a href="<?=WEB_ROOT?>/signin" id="bSignin"><?=$lang['SignIn']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? endif?>
