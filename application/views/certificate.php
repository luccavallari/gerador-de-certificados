<?php 
	//pdf não abria sem isto.
	ob_start();
?>
<body style="background: url(<?=base_url('images/cert-bg.png')?>) no-repeat; padding: 0 !important; margin: 0 auto;  padding-left: 20px; padding-right: 20px;">
	<?php 
		$this->courses = $courses;
		//verifica se foi definido um texto personalizado.
		if( trim($courses[0]->long_description) != "" ):
			//pseudovariables replace.
			$desc = $courses[0]->long_description;
			echo '<br><br><br><br><br><br><br><br>';
			///replaces
			///added style > text-transform, to conver to uppercase all characters. (php don't convert ISO-8859-1 characters)
			$desc = str_replace('[student]',"<strong style='text-transform: uppercase;'>".strtoupper($courses[0]->student_name)."</strong>", $desc);
			$desc = str_replace('[aluno]',"<strong style='text-transform: uppercase;'>".strtoupper($courses[0]->student_name)."</strong>", $desc);
			$desc = str_replace('[curso]',"<strong style='text-transform: uppercase;'>".strtoupper($courses[0]->course_name)."</strong>", $desc);
			$desc = str_replace('[course]',"<strong style='text-transform: uppercase;'>".strtoupper($courses[0]->course_name)."</strong>", $desc);
			$desc = str_replace('[instituition]',"<strong style='text-transform: uppercase;'>".strtoupper($admin[0]->company_name)."</strong>", $desc);
			$desc = str_replace('[instituicao]',"<strong style='text-transform: uppercase;'>".strtoupper($admin[0]->company_name)."</strong>", $desc);
			///end replaces
			echo "<div style='font-size: 18px; font-family: verdana; text-transform: uppercase;  padding-left: 35px; padding-right: 25px;'>".$desc."</div>";
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
				if($courses[0]->city != '')
					$inCity = ucwords($courses[0]->city);
				else
					$inCity = $admin[0]->company_city;
				echo '<p style="width: 90%; text-align: right; font-size: 18px; "><strong>'.$inCity.', '.date('d').' de '.$mes[date('M')].' de '.date('Y').'<strong></p>';
			endif;
		else:
	?>
		<div>
			<br><br><br><br><br>
			<center>
				<div style="text-align: center;">
					<span style="font-family: Tahoma;"><?=$this->lang->line('cert_sub_title')?></span><br>
					<!--<span style="text-align: center; font-family: 'anglotext'; font-size: 110px; color: #333; margin-top: 0;"><?=$courses[0]->student_name?></span>-->
					<span style="text-align: center; font-family: arial; font-size: 80px; color: #333; margin-top: 0;"><?=$courses[0]->student_name?></span>
				</div>
			</center>
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
						echo "<td><center><img style='width: 250px ; margin-top: 30px; ' src='".base_url('media/'.$img->name)."'></center></td>";
					}
				echo "</tr></table>";
			endif;
		?>
	</div>
</body>
