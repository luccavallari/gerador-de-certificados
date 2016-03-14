<?php 
	//data to edit (if exists)
	$id = "";
	$name = "";
	$doc = "";
	$email = "";
	$ON_EDIT = false;
	if (  isset( $student_edit ) )
	{
		foreach ($student_edit as $e) 
		{
			$id = $e->id;
			$name = $e->name;
			$doc = $e->doc;
			$email = $e->email;
		}
		$ON_EDIT = true;
	}
	
?>
<div class="row">
	<div class="col-md-12">
		<h3><?=$this->lang->line('new_edit_label')?></h3>
		<form class='form form-inline' id='form' name='form' action='<?=base_url("admin/students/".$id)?>' method='POST'>
		<div class='form-group'>
			<input class='form-control' value="<?=$name?>" type='text' maxlength="54" name='name' placeholder='<?=$this->lang->line('name_student_label')?> *' required='required'> 
			<input class='form-control' value="<?=$doc?>" type='text' maxlength="11" name='doc' placeholder='<?=$this->lang->line('doc_student_label')?>'>
			<input class='form-control' value="<?=$email?>" type='email' maxlength="60" name='email' placeholder='E-mail' required="required">
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
					<th><?=$this->lang->line('name_student_label')?></th>
					<th><?=$this->lang->line('doc_student_label')?></th>
					<th>email</th>
					<th><?=$this->lang->line('actions_label')?></th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach ($students as $c) 
				{
					echo "<tr>";
						echo "<td>".$c->id."</td>";
						echo "<td>".$c->name."</td>";
						echo "<td>".$c->doc."</td>";
						echo "<td>".$c->email."</td>";
						$edit = "<a class='btn btn-warning' href='".base_url('admin/students/'.$c->id)."' >".$this->lang->line('edit_label')."</a>";
						$delete = "<a class='btn btn-danger confirm' href='".base_url('admin/students/'.$c->id.'/remove')."' >".$this->lang->line('delete_label')."</a>";
						echo "<td>".$edit."&nbsp;".$delete."</td>";
					echo "</tr>";
				}
			 ?>
			</tbody>
		</table>
	</div>
</div>