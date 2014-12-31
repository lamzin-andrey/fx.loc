<div class="vd_content">
	<div id="taskPlace">There is task</div>
	<? foreach ($handler->data as $user_decision):?>
		<div class="vd_item">
			<div class="user_data"><?=$user_decision['name']?> <?=$user_decision['surname']?> <span class="iblock tright vd_rating_group"><img class="btn incPlus" data-id="<?="{$user_decision['uid']}:{$user_decision['var']}:{$user_decision['task']}"?>" src="<?=WEB_ROOT?>/img/cmplus.png"> <span class="vdRating" data-id="<?="{$user_decision['uid']}:{$user_decision['var']}:{$user_decision['task']}"?>"><?=$user_decision['rating']?></span> <img data-id="<?="{$user_decision['uid']}:{$user_decision['var']}:{$user_decision['task']}"?>" class="btn decMinus" src="<?=WEB_ROOT?>/img/minus.png"> </span></div>
			<? foreach ($user_decision['code'] as $row): ?>
				<div class="vd_file_title"><img src="/img/js64.png" class="vd_jsicon"> <span class="vd_filename"><?=$row['title']?>.js</span> </div>
				<div class="vd_content">
					<pre class="no_copy"><?=$row['text']?></pre>
				</div>
			<? endforeach ?>
		</div>
	<? endforeach?>
</div>
