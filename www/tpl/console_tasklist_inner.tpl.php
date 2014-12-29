<? if (o($handler, 'file_list')):?>
<ul class="scroll-y">
	<? foreach($handler->file_list as $task): ?>
	<li>
		<a href="#" class="taskname" data-id="<?=$task['id']?>" data-srcfn="<?=$task['src_file_name']?>" data-fn="<?=str_replace('.js', '', $task['src_file_name'])?>"><?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : str_replace('.js', '', $task['src_file_name'])  )  ?></a>
		<a href="#" <?=H::imgtitle($lang['update']) ?> data-id="<?=$task['id']?>" data-name="<?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : str_replace('.js', '', $task['src_file_name'])  )  ?>" class="j-update-task acticons"><img src="<?=WEB_ROOT?>/img/update.png"/></a>
		<a href="#" <?=H::imgtitle($lang['remove']) ?> data-id="<?=$task['id']?>" class="j-remove-task acticons"><img src="<?=WEB_ROOT?>/img/remove.png"/></a>
	</li>
	<?endforeach?>
</ul>
<? else:?>
<ul class="scroll-y">
	<li><p class="task-info">У вас пока нет ни одного загруженного скрипта/</p></li>
	<li><p class="task-info">Выберите задание и загрузите файл</p></li>
</ul>
<? endif?>
<div class="addscript">
	<input type="button" id="uploadScriptShowForm" value="+ Добавить программу" class="qbtn"/>
</div>
