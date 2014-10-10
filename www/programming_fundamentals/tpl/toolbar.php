<? if(sess('uid')):?>
<ul class="inline left">
	<li><a href="#" onclick="alert('In process...')"><?=$lang['CurrentTask']?></a></li>
	<li><a href="#" onclick="alert('In process...')"><?=$lang['TaskList']?></a></li>
	<li><a href="#" onclick="alert('In process...')"><?=$lang['QuickStart']?></a></li>
</ul>
<div class="right">
	<ul class="inline">
		<li>Иванов Иван</li>
		<li><a href="#" onclick="alert('In process...')"><?=$lang['Exit']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? else: ?>
<ul class="inline left">
	<li><a href="#" onclick="alert('In process...')"><?=$lang['TaskList']?></a></li>
	<li><a href="<?=WEB_ROOT?>/quick_start/"><?=$lang['QuickStart']?></a></li>
</ul>
<div class="right">
	<ul class="inline">
		<!--li><a href="#" onclick="alert('In process...')"><?=$lang['SignUp']?></a></li-->
	</ul>
</div>
<div class="clearfix"></div>
<? endif?>
