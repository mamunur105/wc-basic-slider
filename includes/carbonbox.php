<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'bs_slider_attach_post_meta' );
function bs_slider_attach_post_meta() {
    Container::make( 'post_meta', __( 'Slider option' ) )
        ->where( 'post_type', '=', 'bs_slider' )
        ->add_fields( array(
            Field::make( 'select', 'crb_select', __( 'Choose slider type' ) )
		    ->set_options( array(
		        'main_slider' => 'Main Slider',
		        'category_slider' => 'Woocommerce Category',
		        'releted_product' => 'Woocommerce Related Product',
		        'woocommerce_upsell_display' => 'Woocommerce Upsell',
		    ) ),
        ) );
}

