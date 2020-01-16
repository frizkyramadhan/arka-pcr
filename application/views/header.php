<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/pages/plans.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/pages/dashboard.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>datepicker/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo base_url();?>">ARKA Planned Component Replacement</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> Hi, <?php echo $pengguna->username;?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url('login/logout');?>"><i class="icon-signout"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->