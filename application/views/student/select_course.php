<!DOCTYPE html>
<html>
<head>
	<title><?=$this->lang->line('my_title')?></title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="William Marquardt <williammqt@gmail.com>">

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('css/custom.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class='bstud'>
	<div class="container">
		<div class="col-md-12">
            <?php 
                //show messages
                if( $this->session->flashdata('info') != "" ){
                    echo "<br><br><div class='alert alert-info'>".$this->session->flashdata('info')."</div>";
                }
                if( $this->session->flashdata('warning') != "" ){
                    echo "<br><br><div class='alert alert-warning'>".$this->session->flashdata('warning')."</div>";
                }
                if( $this->session->flashdata('success') != "" ){
                    echo "<br><br><div class='alert alert-success'>".$this->session->flashdata('success')."</div>";
                }
                if( $this->session->flashdata('danger') != "" ){
                    echo "<br><br><div class='alert alert-danger'>".$this->session->flashdata('danger')."</div>";
                }
              ?>
              <center><h1><?=$this->lang->line('select_course')?></h1></center>
            <?php 

                foreach ($courses as $c) 
                {

                    echo "<a href='".base_url('student/print_certificate/'.$c->id_student.'/'.$c->id_course)."'>";
                        echo "<div class='col-md-3' style='padding: 6px;'>";
                            echo "<div class='coursebox'><center>";
                                echo "<h1><i class='fa fa-check'></i></h1>";
                                echo "<strong>".$c->description."</strong>";
                            echo "</center></div>";
                        echo "</div>";
                    echo "</a>";
                }

             ?>			
		</div>
	</div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url('js/jquery-1.11.2.min.js')?>"></script>
    <script src="<?=base_url('js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('js/custom.js')?>"></script>
</body>
</html>