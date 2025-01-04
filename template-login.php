<?php 
	/* Template Name: Login */ 
	if(is_user_logged_in()){
		wp_redirect(home_url());
		exit;		
	}
	get_header('login');
	$top_info_band='';
	if(isset($_POST['ars-login-form-submited'])){
		if($_POST['ars-login-form-submited']){
			$info = array();
			$info['user_login'] = $_POST['ars_prj_login_email'];
			$info['user_password'] = $_POST['ars_prj_login_pass'];
			$info['remember'] = false;
			$user_signon = wp_signon( $info, false );
			if ( is_wp_error($user_signon) ){
				$top_info_band='<p class="text-danger">'.__('Kullanıcı Adı veya Şifre Hatalı','arsoltranslate').'</p>';
			} else {
				wp_redirect(home_url());
				exit;
			}			
		}	
	}
	echo '<div class="account-pages my-5 pt-sm-5">';
	   echo '<div class="container">';
		  echo '<div class="row justify-content-center">';
			 echo '<div class="col-md-8 col-lg-6 col-xl-5">';
				echo '<div class="card overflow-hidden">';
				   echo '<div class="bg-primary-subtle">';
					  echo '<div class="row">';
						 echo '<div class="col-12">';
							echo '<div class="text-primary p-4">';
							   echo '<h5 class="text-primary">'.__('Arsol Dijital Reklam Yönetim Paneli','arsoltranslate').'</h5>';
							   echo '<p>'.__('Kullanıcı Adı ve Şifreniz İle Giriş Yapabilirsiniz','arsoltranslate').'</p>';
							echo '</div>';
						 echo '</div>';
					  echo '</div>';
				   echo '</div>';
				   echo '<div class="card-body pt-0">';
					  
					  echo '<div class="auth-logo">';
						 echo '<a href="'.home_url().'" class="auth-logo-light">';
							echo '<div class="avatar-md profile-user-wid mb-4">';
							   echo '<span class="avatar-title rounded-circle bg-light">';
							   echo '<img src="'.get_template_directory_uri().'/assets/img/yuvarlak-logo.jpeg" alt="" class="rounded-circle" height="34">';
							   echo '</span>';
							echo '</div>';
						 echo '</a>';
						 echo '<a href="'.home_url().'" class="auth-logo-dark">';
							echo '<div class="avatar-md profile-user-wid mb-4">';
							   echo '<span class="avatar-title rounded-circle bg-light">';
							   echo '<img src="'.get_template_directory_uri().'/assets/img/yuvarlak-logo.jpeg" alt="" class="rounded-circle" height="34">';
							   echo '</span>';
							echo '</div>';
						 echo '</a>';
					  echo '</div>';
					  echo $top_info_band;
					  echo '<div class="p-2">';
						 echo '<form class="form-horizontal" action="" method="POST">';
							echo '<input type="hidden" name="ars-login-form-submited" value="1">';
							echo '<div class="mb-3">';
							   echo '<label for="ars_prj_login_email" class="form-label">'.__('Email','arsoltranslate').'</label>';
							   echo '<input type="email" class="form-control" id="ars_prj_login_email" name="ars_prj_login_email" placeholder="'.__('E-Mail Adresinizi Girin','arsoltranslate').'">';
							echo '</div>';
							echo '<div class="mb-3">';
							   echo '<label for="ars_prj_login_pass" class="form-label">'.__('Şifre','arsoltranslate').'</label>';
							   echo '<input type="password" class="form-control" name="ars_prj_login_pass" id="ars_prj_login_pass" placeholder="'.__('Şifrenizi Girin','arsoltranslate').'" aria-label="Password" aria-describedby="password-addon">';
							echo '</div>';
							echo '<div class="mt-3 d-grid">';
							   echo '<button class="btn btn-primary waves-effect waves-light" type="submit">'.__('Giriş Yap','arsoltranslate').'</button>';
							echo '</div>';
						 echo '</form>';
					  echo '</div>';
				   echo '</div>';
				echo '</div>';
			 echo '</div>';
		  echo '</div>';
	   echo '</div>';
	echo '</div>';	

	get_footer('login');