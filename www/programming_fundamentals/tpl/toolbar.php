<? if(sess('uid')):?>
<ul class="inline left">
	<li><a href="#" onclick="alert('In process...')"><?=$lang['CurrentTask']?></a></li>
	<li><a href="<?=WEB_ROOT?>/tasklist"><?=$lang['TaskList']?></a></li>
	<li><a href="<?=WEB_ROOT?>/quick_start"><?=$lang['QuickStart']?></a></li>
</ul>
<div class="right">
	<ul class="inline">
		<li><?=$app->user_name?> <?=$app->user_surname ?></li>
		<li><a href="<?=WEB_ROOT?>/login?action=logout"><?=$lang['Exit']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? else: ?>
<ul class="inline left">
	<li><a href="<?=WEB_ROOT?>/tasklist"><?=$lang['TaskList']?></a></li>
	<li><a href="<?=WEB_ROOT?>/quick_start/"><?=$lang['QuickStart']?></a></li>
</ul>
<div class="right">
	<ul class="inline">
		<li><a href="javascript:;" id="regLink"><?=$lang['SignUp']?></a></li>
		<li><a href="<?=WEB_ROOT?>/signin" id="bSignin"><?=$lang['SignIn']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? endif?>
