<div class="jumbotron">
	<h1><?=$this->lang->line('welcome')?></h1><br><br>
	<div class="col-md-4">
		<a href="<?=base_url('admin/courses')?>" class="btn btn-primary btn-block"><?=$this->lang->line('class_label')?></a>
	</div>
	<div class="col-md-4">
		<a href="<?=base_url('admin/students')?>" class="btn btn-primary btn-block"><?=$this->lang->line('student_label')?></a>
	</div>
	<div class="col-md-4">
		<a href="<?=base_url('admin/classes')?>" class="btn btn-primary btn-block"><?=$this->lang->line('classes_label')?></a>
	</div>
</div>