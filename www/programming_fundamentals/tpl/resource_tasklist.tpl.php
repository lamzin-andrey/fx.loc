<? if (o($handler, 'file_list')):?>
<ul class="scroll-y">
	<? foreach($handler->file_list as $task): ?>
	<li>
		<a href="#" class="taskname" data-id="<?=$task['id']?>" data-path="<?=$task['file_path']?>"><img src="<?=WEB_ROOT . $task['file_path']?>" width="100"><?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : $task['src_file_name']  )  ?></a>
		<a href="#" <?=H::imgtitle($lang['update']) ?> data-id="<?=$task['id']?>" data-name="<?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : str_replace('.js', '', $task['src_file_name'])  )  ?>" class="j-update-task acticons"><img src="<?=WEB_ROOT?>/img/update.png"/></a>
		<a href="#" <?=H::imgtitle($lang['remove']) ?> data-id="<?=$task['id']?>" class="j-remove-task acticons"><img src="<?=WEB_ROOT?>/img/remove.png"/></a>
	</li>
	<?endforeach?>
</ul>
<? else:?>
<ul class="scroll-y">
	<li><p class="task-info"><?=$lang['no_res_files_message']?></p></li>
</ul>
<? endif?>
<div class="addscript">
	<input type="button" id="uploadResShowForm" value="+ <?=$lang['Append_file']?>" class="qbtn"/>
</div>
<? include APP_ROOT . '/tpl/res_upload_form.tpl.php';?>
