<div class="swiper-slide bg-img-wrapper">
	<div class="slide-inner image-placeholder pos-r" style="<?php echo esc_attr( $background_image ); ?>">
		<div class="slide-content <?php echo esc_attr( $content_parent_class ); ?> ">
		<?php
			$item = 1;
            foreach ( $animate_text as $slider_text ) {
                $select_slider_animation = esc_attr( $slider_text['select_slider_animation'] );
                $animation_duration      = esc_attr( $slider_text['animation_duration'] );
                $animation_delay         = esc_attr( $slider_text['animation_delay'] );
                $main_slider_title       = esc_attr( $slider_text['main_slider_title'] );
                if ( 1 == $item ) {
                    ?>
                        <h1 class='main-title' data-swiper-animation='<?php echo esc_attr( $select_slider_animation ); ?>' data-duration='<?php echo esc_attr( $animation_duration ); ?>' data-delay='<?php echo esc_attr( $animation_delay ); ?>'>
                            <span> <?php echo esc_attr( $main_slider_title ); ?> </span>
                        </h1>
                    <?php } else { ?>
                        <p class='subtitle' data-swiper-animation='<?php echo esc_attr( $select_slider_animation ); ?>' data-duration='<?php echo esc_attr( $animation_duration ); ?>' data-delay='<?php echo esc_attr( $animation_delay ); ?>'>
                            <span> <?php echo esc_attr( $main_slider_title ); ?> </span>
                        </p>
                    <?php
                    }
                    $item++;
            }
		?>
		</div> <!-- end of slide-content -->
	</div> <!-- end of slider-inner -->
</div> <!-- end of swiper-slide -->