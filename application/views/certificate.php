<?php 
	//pdf não abria sem isto.
	ob_start();
?>
<body style="background: url(<?=base_url('images/cert-bg.png')?>) no-repeat; padding: 0 !important; margin: 0 auto; ">
	<?php 
		$this->courses = $courses;
		//verifica se foi definido um texto personalizado.
		if( trim($courses[0]->long_description) != "" ):
			//faz os replaces das pseudovariaveis
			$desc = $courses[0]->long_description;
			echo '<br><br><br><br><br><br><br><br>';
			///replaces
			$desc = str_replace('[student]',"<strong>".strtoupper($courses[0]->student_name)."</strong>", $desc);
			$desc = str_replace('[aluno]',"<strong>".strtoupper($courses[0]->student_name)."</strong>", $desc);
			$desc = str_replace('[curso]',"<strong>".strtoupper($courses[0]->course_name)."</strong>", $desc);
			$desc = str_replace('[course]',"<strong>".strtoupper($courses[0]->course_name)."</strong>", $desc);
			$desc = str_replace('[instituition]',"<strong>".strtoupper($admin[0]->company_name)."</strong>", $desc);
			$desc = str_replace('[instituicao]',"<strong>".strtoupper($admin[0]->company_name)."</strong>", $desc);
			///fim replaces
			echo "<p style='font-size: 23px; text-align: justfy; font-family: verdana; text-transform: uppercase; width: 90%; margin-left: 10%;'>".$desc."</p>";
			//only in pt-br.
			if( config_item('language') == "portuguese-brazilian" && $admin[0]->company_city != "" ):
				    $mes = array(
				        'Jan' => 'Janeiro',
				        'Feb' => 'Fevereiro',
				        'Mar' => 'Marco',
				        'Apr' => 'Abril',
				        'May' => 'Maio',
				        'Jun' => 'Junho',
				        'Jul' => 'Julho',
				        'Aug' => 'Agosto',
				        'Nov' => 'Novembro',
				        'Sep' => 'Setembro',
				        'Oct' => 'Outubro',
				        'Dec' => 'Dezembro'
				    );
				echo '<p style="width: 90%; text-align: right; font-size: 18px; "><strong>'.$admin[0]->company_city.', '.date('d').' de '.$mes[date('M')].' de '.date('Y').'<strong></p>';
			endif;
		else:
	?>
		<div>
			<br><br><br><br><br>
			<div style="text-align: center;">
				<span style="font-family: sans-serif;"><?=$this->lang->line('cert_sub_title')?></span><br>
				<!--<span style="text-align: center; font-family: 'anglotext'; font-size: 110px; color: #333; margin-top: 0;"><?=$courses[0]->student_name?></span>-->
				<span style="text-align: center; font-family: arial; font-size: 80px; color: #333; margin-top: 0;"><?=$courses[0]->student_name?></span>
			</div>
			<div style="text-align: center;">
				<span style="font-family: sans-serif;"><?=$this->lang->line('cert_sub_title_course')?></span><br>
				<strong><span style="text-align: center; font-family: 'sans-serif'; font-size: 40px; color: #333; margin-top: 0;"><?=$courses[0]->course_name?></span></strong>
				<br><span>
					<?php 
						if( $courses[0]->course_date != "" )
							echo " ".$courses[0]->course_date;
						if( $courses[0]->course_time != "" )
							( $courses[0]->course_date != "" ) ? " - " : "";
							echo " ".$courses[0]->course_time."h";
					 ?>
				</span>
			</div>
		<?php endif; ?>	
		<?php 
			//mostra assinaturas.
			if(count( $img_singnatures ) > 0):
				echo "<table style='width: 100%;'><tr style='width: 100%;'>";
					foreach ($img_singnatures as $img) {
						echo "<td><center><img style='width: 120px ; margin-top: 30px; ' src='".base_url('media/'.$img->name)."'></center></td>";
					}
				echo "</tr></table>";
			endif;
		?>
	</div>
</body>
