<div class="row">
	<div class="col-md-6">
		<h3><?=$this->lang->line('change_pass')?></h3>
		<form class="form" action="<?=base_url('admin/my_info')?>" method='POST'>
			<input type="text" value="admin" name='user' style='display: none;'><!-- to avoid firefox user dialog -->
			<input class="form-control" type="password" name='old_pass' placeholder='<?=$this->lang->line('old_pass')?>' required='required'><br>
			<input class="form-control" type="password" name='new_pass' placeholder='<?=$this->lang->line('new_pass')?>' required='required'><br>
			<input class="form-control" type="password" name='new_pass2' placeholder='<?=$this->lang->line('new_pass2')?>' required='required'><br>
			<input type="submit" class="btn btn-success pull-right" value="<?=$this->lang->line('edit_label')?>">
		</form>
	</div>
	<div class="col-md-6">
		<h3><?=$this->lang->line('company_data')?></h3>
		<form action="<?=base_url('admin/my_info')?>" method='POST'>

			<input class='form-control' name='company_name' maxlength="30" value='<?=$admin_data[0]->company_name?>' placeholder='<?=$this->lang->line('company_name')?>' required='required'><br>
			<div class="col-md-9" style="padding: 0;">
				<input type="text" name='company_city' class='form-control' value='<?=$admin_data[0]->company_city?>' placeholder='<?=$this->lang->line('city')?>'>
			</div>
			<div class="col-md-3" style="padding: 0;">
				<input type="text" name='company_state' class='form-control' value='<?=$admin_data[0]->company_state?>' placeholder='<?=$this->lang->line('state')?>'>
			</div>
			<br><br><br>
			<input type="submit" class="btn btn-success pull-right" value="<?=$this->lang->line('edit_label')?>">
		</form>
	</div>
</div>