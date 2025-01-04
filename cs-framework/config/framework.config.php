<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$menus = wp_get_nav_menus();
$menus_all=array();
if($menus){

foreach ( $menus as $menu_elem) {
 $menus_all[$menu_elem->slug]=$menu_elem->name;
}
}
$settings           = array(
	'menu_title'		=> 'Tema Ayarları',
	'menu_type'			=> 'menu', // menu, submenu, options, theme, etc.
	'menu_slug'			=> 'td-framework',
	'ajax_save'			=> true,
	'framework_title'	=> 'Tema Ayarları <small>by Tema.Digital</small>',
);
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options	= array();

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]	= array(
	'name'	=> 'genel-ayarlar',
	'title'	=> 'Genel Ayarlar',
	'icon'	=> 'fa fa-star',
	'fields'	=> array(
		array(
			'id'	=> 'of_login_page',
			'type'	=> 'select',
			'title'	=> 'Login Sayfası',
			'desc'	=> 'Login sayfasını seçiniz.',
			'options'	=> 'pages',
			// query_args is option for all
			'query_args'	=> array(
				'sort_order'	=> 'ASC',
				'sort_column'	=> 'post_title',
			),
		),
		array(
			'id'	=> 'of_accounts_page',
			'type'	=> 'select',
			'title'	=> 'Hesap Sayfası',
			'desc'	=> 'Hesap sayfasını seçiniz.',
			'options'	=> 'pages',
			// query_args is option for all
			'query_args'	=> array(
				'sort_order'	=> 'ASC',
				'sort_column'	=> 'post_title',
			),
		),		
	),
);
$options[]	= array(
	'name'		=> 'backup_section',
	'title'		=> 'Yedek',
	'icon'		=> 'fa fa-shield',
	'fields'	=> array(

		array(
			'type'		=> 'notice',
			'class'		=> 'warning',
			'content'	=> 'Yedekleri dışa aktarın / Yedekleri içe aktarın.',
		),

		array(
			'type'	=> 'backup',
		),

	)
);

CSFramework::instance( $settings, $options );