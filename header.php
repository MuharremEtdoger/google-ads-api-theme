<!DOCTYPE html>
<html lang="tr-TR">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
		<link rel="canonical" href="https://demo-basic.adminkit.io/" />
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> data-topbar="dark" data-layout="horizontal">
		<div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?php echo home_url(); ?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?php echo get_template_directory_uri().'/assets/img/arsol_header_logo.png'; ?>" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo get_template_directory_uri().'/assets/img/arsol_header_logo.png'; ?>" alt="" height="19">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    
                    </div>

                    <div class="d-flex">
						<?php echo do_shortcode('[ars_prj_top_right_user]'); ?>

           
                    </div>
                </div>
            </header>	
			<div class="main-content">