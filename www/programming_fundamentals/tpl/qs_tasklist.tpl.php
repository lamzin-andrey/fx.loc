<ul class="scroll-y">
	<li><a class="" href="<?=WEB_ROOT?>/quick_start/"><?=$lang['intro']?></a></li>
	<li><a class="" href="<?=WEB_ROOT?>/quick_start/wtf/"><?=$lang['wtf']?></a></li>
	<li><a class="" href="<?=WEB_ROOT?>/quick_start/security/"><?=$lang['security']?></a></li>
	<li><a class="" href="<?=WEB_ROOT?>/quick_start/keywords/"><?=$lang['keywords']?></a></li>
	<?=QuickStartHandler::part('variables')?>
	<?=QuickStartHandler::part('datatypes')?>
	<?=QuickStartHandler::part('functions')?>
	<?=QuickStartHandler::part('begin')?>
	<?=QuickStartHandler::part('arithmetic')?>
	<?=QuickStartHandler::part('branching')?>
	<?=QuickStartHandler::part('cycles')?>
	<?=QuickStartHandler::part('strings')?>
	<?=QuickStartHandler::part('arrays')?>
	<?=QuickStartHandler::part('function_tasks')?>
</ul>

