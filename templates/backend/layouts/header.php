<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Админцентр</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    
    <!-- JQUERY -->
    <script type="text/javascript" src="/resources/libs/jquery-1.7.2.min.js"></script>
    
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/libs/bootstrap/css/bootstrap.css" media="all" />
    <script type="text/javascript" src="<?php echo base_url() ?>resources/libs/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- TPL -->
    <script type="text/javascript" src="/templates/<?php echo TPL_DIR ?>/js/main.js"></script>
    <link rel="stylesheet" href="/templates/<?php echo TPL_DIR ?>/css/style.css" type="text/css" media="screen, projection" />

</head>

<body>

<?php echo $this->load->view('top_sidebar') ?>

<div id="wrapper">

	<div id="middle">

        <div id="header"></div><!-- #header-->
    
		<div id="container">
			<div id="content">