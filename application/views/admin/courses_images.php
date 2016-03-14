<h2><?=$this->lang->line('images_label')?>&nbsp; -> <strong><?=$course[0]->description?></strong></h2>
<div class='col-md-12 alert alert-info'><?=$this->lang->line('images_long_description')?></div>
<div class="col-md-12">
	<h3>Logo </h3>
	<hr>
	<div class='jumbotron'>
		<form method="POST" enctype="multipart/form-data" action="<?=base_url('admin/courses_images/add')?>">
			<div class="form-inline form-group">
				<input type="hidden" name='type' value='logo' required>
				<input type="hidden" name='id_course' value='<?=$course[0]->id?>' required>
				<input type="file" name='name' class="form-control" required>
				<input type="submit" class='btn btn-primary' value='Add'>
			</div>
		</form>
	</div>
		<?php 
			if( count( $images_logo ) > 0 ):
				foreach ($images_logo as $img) {
					echo "<div class='col-md-2'><img style='max-width: 100%;' src='".base_url('media/'.$img->name)."'><a class='btn btn-danger' href='".base_url('admin/courses_images_remove/'.$img->id_course.'/'.$img->id)."' style='width: 100%; border-radius: 0;'>".$this->lang->line('delete_label')."</a></div>";
				}
			else:
				echo "<pre>".$this->lang->line('nothing_found')."</pre>";
			endif;
		?>
	
</div>

<div class="col-md-12">
	<h3><?=$this->lang->line('singnature_label')?></h3>
	<hr>
	<div class='jumbotron'>
		<form method="POST" enctype="multipart/form-data" action="<?=base_url('admin/courses_images/add')?>">
			<div class="form-inline form-group">
				<input type="hidden" name='type' value='singnature' required>
				<input type="hidden" name='id_course' value='<?=$course[0]->id?>' required>
				<input type="file" name='name' class="form-control" required>
				<input type="submit" class='btn btn-primary' value='Add'>
			</div>
		</form>
	</div>
		<?php 
			if( count( $images_singnature ) > 0 ):
				foreach ($images_singnature as $img) {
					echo "<div class='col-md-2'><img style='max-width: 100%;' src='".base_url('media/'.$img->name)."'><a class='btn btn-danger' href='".base_url('admin/courses_images_remove/'.$img->id_course.'/'.$img->id)."' style='width: 100%; border-radius: 0;'>".$this->lang->line('delete_label')."</a></div>";
				}
			else:
				echo "<pre>".$this->lang->line('nothing_found')."</pre>";
			endif;
		?>
	
</div>