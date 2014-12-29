<div class="file-names-filter tcenter">
	<form id="resFormFilter">
	<input type="text" class="qs-file-browser-search-text" name="searchFileName" value="<?=req('searchFileName', 'GET')?>">
	 <img src="/programming_fundamentals/img/search32.png" class="btn qs-br-search-btn" id="btnSearchRes">
	</form>
	<hr style="color:gray">
</div>

<? if (o($handler, 'file_list')):?>
<ul class="inline">
	<? foreach($handler->file_list as $task): ?>
	<li class="res_item">
			<div class="left">
				<div class="img_area"><img src="<?=($task['is_image'] == 1 ? WEB_ROOT . $task['file_path'] : WEB_ROOT . '/img/midi64.png')?>" class="res_img_sz"></div>
				<div class="rev_sens_title tcenter"><?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : $task['src_file_name']  )  ?></div>
			</div>
			<div class="left file_actions">
				<a href="#" <?=H::imgtitle($lang['update']) ?> data-id="<?=$task['id']?>" data-name="<?=utils_capitalize($task['display_file_name'] ? $task['display_file_name'] : str_replace('.js', '', $task['src_file_name'])  )  ?>" class="j-upres  acticons"><img src="<?=WEB_ROOT?>/img/update.png"/></a>
				<a href="#" <?=H::imgtitle($lang['remove']) ?> data-id="<?=$task['id']?>" class="j-remres acticons"><img src="<?=WEB_ROOT?>/img/remove.png"/></a>
			</div>
			<div class="clearfix"></div>
			<div class="rev_sens_ta tcenter"><textarea class="j-taselall "><?=WEB_ROOT . $task['file_path']  ?></textarea></div>
	</li>
	<?endforeach?>
</ul>
<? else:?>
<ul class="scroll-y">
	<li><p class="task-info"><?=$lang['no_res_files_message']?></p></li>
</ul>
<? endif?>


<? include APP_ROOT . '/tpl/paging.tpl.php'; ?>


<div class="addscript">
	<input type="button" id="uploadResShowForm" value="+ <?=$lang['Append_file']?>" class="qbtn"/>
</div>
<? include APP_ROOT . '/tpl/res_upload_form.tpl.php';?>
