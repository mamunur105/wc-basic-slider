<div class="swiper-slide  <?php echo esc_attr( $content_position ) . ' '; 	echo esc_attr( apply_filters( 'categpry_slider', 'slider_content_class' ) ); ?>">
	<a class="category_image" href="<?php echo esc_attr( $category_link ); ?>">
		<img src="<?php echo esc_url( $category_image ); ?>" alt="<?php echo esc_attr( $categoryname ); ?>">
	</a>

	<div class="cat-slide-content">
	<?php if ( ! $hide_title ) { ?>
			<div class="name"><?php echo esc_attr( $categoryname ); ?></div>
		<?php } ?>
	<?php if ( ! $hide_button ) { ?>

		<div class="cat-button">
			<a href="<?php echo esc_attr( $category_link ); ?>">
			<?php echo esc_html( $button_text ); ?></a>
		</div>
		<?php } ?>

	</div>
</div>