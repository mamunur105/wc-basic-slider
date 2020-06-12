<?php
namespace Basic\Slider;

/**
 * The admin class
 */
class BSCpt {
	

    protected $slug;

	 /**
     * CPT constructor.
     *
     */
    public function __construct() {
        
        $this->slug = 'bs_slider';
        add_action( 'init', array( $this, 'register_bs_slider' ), 0 );
        add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'set_shortocode_column' ) );
        add_action( 'manage_' . $this->slug . '_posts_custom_column', array( $this, 'shortocode_column_data' ), 10, 2 );

    }

    /**
     * Register post type
     */
    public function register_bs_slider() {

        $labels = array(
            'name'               => _x( 'Wc Basic Slider', 'post type general name', 'bs-slider' ),
            'singular_name'      => _x( 'Wc Basic Slider', 'post type singular name', 'bs-slider' ),
            'menu_name'          => _x( 'Wc Basic Slider', 'admin menu', 'bs-slider' ),
            'name_admin_bar'     => _x( 'Wc Basic Slider', 'add new on admin bar', 'bs-slider' ),
            'add_new'            => _x( 'Add New', 'book', 'bs-slider' ),
            'add_new_item'       => __( 'Add New Slider', 'bs-slider' ),
            'new_item'           => __( 'New Slider', 'bs-slider' ),
            'edit_item'          => __( 'Edit Slider', 'bs-slider' ),
            'view_item'          => __( 'View Slider', 'bs-slider' ),
            'all_items'          => __( 'All Sliders', 'bs-slider' ),
            'search_items'       => __( 'Search Slider', 'bs-slider' ),
            'parent_item_colon'  => __( 'Parent Slider:', 'bs-slider' ),
            'not_found'          => __( 'No Slider found.', 'bs-slider' ),
            'not_found_in_trash' => __( 'No Slider found in Trash.', 'bs-slider' )
        );

        $args = array(
            'labels'                => $labels,
            'description'           => __( 'Description.', 'bs-slider' ),
            'public'                => false,
            'publicly_queryable'    => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'can_export'            => true,
            'capability_type'       => 'post',
            'has_archive'           => false,
            'hierarchical'          => false,
            'menu_position'         => null,
            'menu_icon'             => 'dashicons-images-alt',
            'supports'              => array( 'title' ),
            'show_in_rest'          => true
        );

        register_post_type( $this->slug, $args );
    }

    /**
     * Register shortcode column
     *
     * @param $columns
     *
     * @return mixed
     */
    public function set_shortocode_column( $columns ) {
        unset( $columns['date'] );
        $columns['shortcode'] = __( 'Shortcode', 'bs-slider' );
        $columns['date']      = __( 'Date', 'bs-slider' );
        return $columns;
    }

    /**
     * show shortcode column data
     *
     * @param $column
     * @param $post_id
     */
    public function shortocode_column_data( $column, $post_id ) {
        $slider_type = carbon_get_post_meta( $post_id, 'select_slider_type' );
        $shortcode = '' ;
        if ('main_slider' == $slider_type) {
            $shortcode =  "<strong style='padding:5px 10px 7px; background:#ddd'>[bs_slider slider_id='{$post_id}']</strong>";
        }
        if ('category_slider' == $slider_type) {
            $shortcode =  "<strong style='padding:5px 10px 7px; background:#ddd'>[woocategory_slider slider_id='{$post_id}']</strong>";
        }
        
        switch ( $column ) {
            case "shortcode":
                echo $shortcode;
                break;
        }
    }

}