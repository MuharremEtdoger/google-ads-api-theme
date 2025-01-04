<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// TAXONOMY OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options     = array();

// -----------------------------------------
// Taxonomy Options                        -
// -----------------------------------------
$options[]   = array(
  'id'       => 'writer_seo_settings',
  'taxonomy' => 'writer', // category, post_tag or your custom taxonomy name
  'fields'   => array(
    array(
      'id'    => 'meta_description',
      'type'  => 'textarea',
      'title' => 'Meta Açıklaması',
    ),	
  ),
);
$options[]   = array(
  'id'       => 'writer_add',
  'taxonomy' => 'writer', // category, post_tag or your custom taxonomy name
  'fields'   => array(
    array(
      'id'    => 'icon_image',
      'type'  => 'image',
      'title' => 'İkon Görseli',
    ),
    array(
      'id'    => 'video_kategori',
      'type'  => 'text',
      'title' => 'Video Kategori ID',
    ),	
  ),
);
$options[]   = array(
  'id'       => '_custom_taxonomy_options',
  'taxonomy' => 'another_taxonomy_name', // category, post_tag or your custom taxonomy name
  'fields'   => array(

    array(
      'id'    => 'section_1_text',
      'type'  => 'text',
      'title' => 'Text Field',
    ),

  ),
);

CSFramework_Taxonomy::instance( $options );
