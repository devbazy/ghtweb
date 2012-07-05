<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $meta_title ?></title>
	
	<meta name="keywords" content="<?php echo $meta_keywords ?>" />
	<meta name="description" content="<?php echo $meta_description ?>" />
	
    <meta name="google-site-verification" content="922WU17GUwXCB1ngeLCsFFanwtTqz_89cPcdGlYP0c8" />
    
    <!-- JQUERY -->
    <script type="text/javascript" src="<?php echo base_url() ?>resources/libs/jquery-1.7.2.min.js"></script>
    
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/libs/bootstrap/css/bootstrap.css" media="all" />
    <script type="text/javascript" src="<?php echo base_url() ?>resources/libs/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>templates/<?php echo $this->config->item('template') ?>/css/style.css" media="all" />
    
    <!-- ENGINE -->
    <script type="text/javascript" src="<?php echo base_url() ?>resources/js/ghtweb.js"></script>
    
    <!-- MAIN -->
    <script type="text/javascript" src="<?php echo base_url() ?>templates/<?php echo $this->config->item('template') ?>/js/main.js"></script>
    
</head>

<body>

<?php if($this->auth->get('is_logged')) { ?>
    <?php echo $this->load->view('cabinet/top_panel') ?>
<?php } ?>

<div id="wrapper">

	<div id="header">
        <ul class="header-top-menu unstyled">
            <?php if($page_in_menu) { ?>
                <li><?php echo anchor('', lang('Главная')) ?></li>
                <?php foreach($page_in_menu as $row) { ?>
                    <li><?php echo anchor('page/' . $row['page'], $row['title']) ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="header-text">
            <img src="<?php echo base_url() ?>templates/<?php echo $this->config->item('template') ?>/images/logo.png" width="437" height="97" alt="" /> <span class="version"><?php echo VERSION ?></span>
        </div>
        <div class="l2top">
            <!-- <a href="#" target="_blank" style="left: 0;padding: 8px 10px 0;position: absolute;top: 0;">
                <img src="http://l2top.ru/vb/22638.pgif" width="88" height="31" border="0" alt="L2top: Рейтинг-каталог серверов Lineage2" />
            </a> -->
        </div>
	</div><!-- #header-->

	<div id="middle">

		<div id="container">
			<div id="content">