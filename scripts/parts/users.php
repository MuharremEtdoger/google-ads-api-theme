<?php
   remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
   add_filter( 'authenticate', 'tcb_authenticate_username_password', 20, 3 );
   function tcb_authenticate_username_password( $user, $username, $password ) {
	  if ( ! empty( $username ) && is_email( $username ) ) :
		if ( $user = get_user_by_email( $username ) )
		  $username = $user->user_login;
	  endif;

	  return wp_authenticate_username_password( null, $username, $password );
	}
	add_shortcode( 'ars_prj_top_right_user', 'ars_prj_top_right_user_func' );
	function ars_prj_top_right_user_func( $atts ){
		global $current_user;
		$html='';
		if(isset($current_user)){
			$html.='<div class="dropdown d-inline-block">';
				$html.='<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"';
					$html.='data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
					$html.='<i class="bi bi-person-circle"></i>';
					$html.='<span class="d-none d-xl-inline-block ms-1" key="t-henry">'.$current_user->display_name.'</span>';
					$html.='&nbsp;<i class="bi bi-chevron-down"></i>';
				$html.='</button>';
				$html.='<div class="dropdown-menu dropdown-menu-end">';
					/*<a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
					<a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
					<a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
					<a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
					<div class="dropdown-divider"></div>*/
					$html.='<a class="dropdown-item text-danger" href="'.wp_logout_url( home_url()).'"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">'.__('Çıkış Yap','arsoltranslate').'</span></a>';
				$html.='</div>';
			$html.='</div>'; 						
		}
		return $html;
	}
	function ars_prj_not_view_admin_panel() {
		$current_user = wp_get_current_user();

		if (count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
			wp_redirect(site_url('/'));
			exit;
		}
	}
	add_action('admin_init', 'ars_prj_not_view_admin_panel');
	function ars_prj_change_role_name(){
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		$wp_roles->roles['subscriber']['name'] = 'Müşteri';
		$wp_roles->role_names['subscriber'] = 'Müşteri';           
	}
	add_action('init', 'ars_prj_change_role_name');