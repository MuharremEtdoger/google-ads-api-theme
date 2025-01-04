<?php
	global $td_option;
	add_filter( 'show_admin_bar', '__return_false' );
	function ars_prj_redirect_login(){
		global $td_option,$post;
		$post_id=0;
		if(isset($post)){
			$post_id=$post->ID;
		}
		if(!is_admin()){
			if(!is_user_logged_in()){
				if($post_id!=$td_option['of_login_page']){
					wp_redirect(get_permalink($td_option['of_login_page']));
					exit;
				}
			}
		}
	}
	add_action( 'template_redirect', 'ars_prj_redirect_login' );
	