<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_select_taxonomies extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();


    $class      = $this->element_class();
    $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';
    $chosen_rtl = ( is_rtl() && strpos( $class, 'chosen' ) ) ? 'chosen-rtl' : '';

    echo '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class( $chosen_rtl ) . $this->element_attributes() .'>';

      echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

      $options = get_terms( 'emlak_kategori', 'hide_empty=0' );
      echo '<optgroup label="Konut">';
        if( !empty( $options ) ){
          foreach ( $options as $opt ) {
            echo '<option value="'. $opt->term_id .'" '. $this->checked( $this->element_value(), $opt->term_id, 'selected' ) .'>'. $opt->name .'</option>';
          }
        }
      echo '</optgroup>';

      $options = get_terms( 'arsa_kategori', 'hide_empty=0' );
      echo '<optgroup label="Arsa">';
        if( !empty( $options ) ){
          foreach ( $options as $opt ) {
            echo '<option value="'. $opt->term_id .'" '. $this->checked( $this->element_value(), $opt->term_id, 'selected' ) .'>'. $opt->name .'</option>';
          }
        }
      echo '</optgroup>';

      $options = get_terms( 'isyeri_kategori', 'hide_empty=0' );
      echo '<optgroup label="İşyeri">';
        if( !empty( $options ) ){
          foreach ( $options as $opt ) {
            echo '<option value="'. $opt->term_id .'" '. $this->checked( $this->element_value(), $opt->term_id, 'selected' ) .'>'. $opt->name .'</option>';
          }
        }
      echo '</optgroup>';

      $options = get_terms( 'turistik_kategori', 'hide_empty=0' );
      echo '<optgroup label="Turistik Tesis">';
        if( !empty( $options ) ){
          foreach ( $options as $opt ) {
            echo '<option value="'. $opt->term_id .'" '. $this->checked( $this->element_value(), $opt->term_id, 'selected' ) .'>'. $opt->name .'</option>';
          }
        }
      echo '</optgroup>';
	  
	  $options = get_terms( 'proje_kategori', 'hide_empty=0' );
      echo '<optgroup label="Proje">';
        if( !empty( $options ) ){
          foreach ( $options as $opt ) {
            echo '<option value="'. $opt->term_id .'" '. $this->checked( $this->element_value(), $opt->term_id, 'selected' ) .'>'. $opt->name .'</option>';
          }
        }
      echo '</optgroup>';

    echo '</select>';


    echo $this->element_after();

  }

}
