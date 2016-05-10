<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="William Marquardt <williammqt@gmail.com>">

    <title><?=$this->lang->line('my_title')?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('css/datatables.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('css/custom.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style='padding: 20px;'>

  

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url('admin')?>"><?=$this->lang->line('my_title')?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?=base_url('admin/courses')?>"><?=$this->lang->line('class_label')?></a></li>
              <li><a href="<?=base_url('admin/students')?>"><?=$this->lang->line('student_label')?></a></li>
              <li><a href="<?=base_url('admin/classes')?>"><?=$this->lang->line('classes_label')?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right ">

              <li><a href="<?=base_url('admin/logout')?>"><?=$this->lang->line('logout')?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right" >

              <li><a href="<?=base_url('admin/my_info')?>"><?=$this->lang->line('my_info')?></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <?php 
        //show messages
        if( $this->session->flashdata('info') != "" ){
            echo "<div class='alert alert-info'>".$this->session->flashdata('info')."</div>";
        }
        if( $this->session->flashdata('warning') != "" ){
            echo "<div class='alert alert-warning'>".$this->session->flashdata('warning')."</div>";
        }
        if( $this->session->flashdata('success') != "" ){
            echo "<div class='alert alert-success'>".$this->session->flashdata('success')."</div>";
        }
        if( $this->session->flashdata('danger') != "" ){
            echo "<div class='alert alert-danger'>".$this->session->flashdata('danger')."</div>";
        }
      ?>
      <?=$contents?>


  
    <script type="text/javascript">
      BASE_URL = "<?=base_url()?>";
    </script>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url('js/jquery-1.11.2.min.js')?>"></script>
    <script src="<?=base_url('js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('js/datatables.min.js')?>"></script>
    <script src="<?=base_url('js/custom.js')?>"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ 
      selector:'textarea',
      menubar : false
     });</script>
  </body>
</html>
