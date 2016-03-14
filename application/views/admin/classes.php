<div class="col-md-12">
	<h3><?=$this->lang->line('select_course')?></h3>
	<select name='id_course' id='id_course' class='form-control'>
		<option value=""></option>
		<?php foreach ($courses as $c): ?>
			<option value="<?=$c->id?>"><?=$c->description?></option>
		<?php endforeach ?>
	</select>
	<hr>
	<input name='update_lang' id='update_lang' type='hidden' value='<?=$this->lang->line('update_label')?>'> 
	<div class="row">
		<div class="col-md-6" style='text-align:center;'>
			<h2><?=$this->lang->line('all_students')?></h2>
			<small><?=$this->lang->line('inst_add_class')?></small>
		</div>
		<div class="col-md-6" style='text-align:center;'>
			<h2><?=$this->lang->line('students_in_class')?></h2>
		</div>
	</div>
	<div class="class_content">
		
	</div>
</div>