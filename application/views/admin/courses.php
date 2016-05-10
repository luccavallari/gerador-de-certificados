<?php 
	//data to edit (if exists)
	$id = "";
	$description = "";
	$time = "";
	$date = "";
	$city = "";
	$ON_EDIT = false;
	if (  isset( $course_edit ) )
	{
		foreach ($course_edit as $e) 
		{
			$id = $e->id;
			$description = $e->description;
			$date = $e->date;
			$time = $e->time;
			$city = $e->city;
		}
		$ON_EDIT = true;
	}
	
?>
<div class="row">
	<div class="col-md-12">
		<h3><?=$this->lang->line('new_edit_label')?></h3>
		<form class='form form-inline' id='form' name='form' action='<?=base_url("admin/courses/".$id)?>' method='POST'>
		<div class='form-group'>
			<input class='form-control' value="<?=$description?>" type='text' maxlength="54" name='description' placeholder='<?=$this->lang->line('description_course_label')?> *' required='required'> 
			<input class='form-control' value="<?=$date?>" type='date' maxlength="10" name='date' placeholder='<?=$this->lang->line('date_course_label')?>'>
			<input class='form-control' value="<?=$time?>" type='text' maxlength="8" name='time' placeholder='<?=$this->lang->line('time_course_label')?>'>
			<input class='form-control' value="<?=$city?>" type='text' maxlength="30" name='city' placeholder='<?=$this->lang->line('city')?>'>
			<?php if ($ON_EDIT): ?>
				<input type="submit" class='btn btn-success' value='<?=$this->lang->line('edit_label')?>'>
			<?php else: ?>
				<input type="submit" class='btn btn-success' value='<?=$this->lang->line('add_label')?>'>
			<?php endif ?>
			
		</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3><?=$this->lang->line('list_label')?></h3>
		<table class='table table-responsive table-hover dataTable'>
			<thead>
				<tr>	
					<th>#</th>
					<th><?=$this->lang->line('description_course_label')?></th>
					<th><?=$this->lang->line('date_course_label')?></th>
					<th><?=$this->lang->line('time_course_label')?></th>
					<th><?=$this->lang->line('city')?></th>
					<th><?=$this->lang->line('actions_label')?></th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach ($courses as $c) 
				{
					echo "<tr>";
						echo "<td>".$c->id."</td>";
						echo "<td>".$c->description."</td>";
						echo "<td>".$c->date."</td>";
						echo "<td>".$c->time."</td>";
						echo "<td>".$c->city."</td>";
						$description = "<a class='btn btn-info open_edit_cert_text' id='desc__".$c->id."' href='javascript:void(0);' >".$this->lang->line('description_label')."</a>";
						$edit = "<a class='btn btn-warning' href='".base_url('admin/courses/'.$c->id)."' >".$this->lang->line('edit_label')."</a>";
						$delete = "<a class='btn btn-danger confirm' href='".base_url('admin/courses/'.$c->id.'/remove')."' >".$this->lang->line('delete_label')."</a>";
						$images = "<a class='btn btn-primary open_image_edit' id='imag__".$c->id."' href='".base_url('admin/courses_images/'.$c->id)."' >".$this->lang->line('images_label')."</a>";
						echo "<td>".$description."&nbsp;".$edit."&nbsp;".$delete."&nbsp;".$images."</td>";
					echo "</tr>";
				}
			 ?>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="modalCertDesc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="z-index: 999999;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
          <h4 class="modal-title"  id="modalCertDescLabel"><?=$this->lang->line('description_label')?></h4>
        </div>
        <div class="modal-body" id="modalCertDescBody">
          <div class='alert alert-info'><?=$this->lang->line('description_cert_alert')?></div>
          <form method="POST" id='form_alter_desc_cert' action='<?=base_url('admin/alter_cert_description')?>'>
	          <textarea rows='4' id='long_description_ta' name='long_description' class="form-control"></textarea>
	          <input class='btn btn-primary pull-right' type='submit' value='<?=$this->lang->line('edit_label')?>' style="margin-top: 10px;"><br><br>
          </form>
        </div>
        <div class="modal-footer" id='myModalFooter'>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>