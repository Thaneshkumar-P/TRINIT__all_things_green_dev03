<?php
	$query = $this->query_posts();
	if(!$query->found_posts){ return; }

	$classes = array();
	$classes[] = 'event-carousel swiper-slider-wrapper';
   $classes[] = $settings['space_between'] < 15 ? 'margin-disable': '';
   $this->add_render_attribute('wrapper', 'class', $classes);
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div <?php echo $this->get_render_attribute_string('carousel') ?> <?php echo $this->get_carousel_settings() ?>>
		<div class="swiper-content-inner">
   		<div class="init-carousel-swiper swiper" data-carousel="<?php echo $this->get_carousel_settings() ?>">
      		<div class="swiper-wrapper">
					<?php
						global $post;
						$count = 0;
						while ( $query->have_posts() ) { 
						$query->the_post();
							$post->loop = $count++;
							$post->post_count = $query->post_count;
							echo '<div class="swiper-slide item">';
								$this->orgarium_get_template_part('tribe-events/list/single', $settings['style'], array(
								  'thumbnail_size' => $settings['image_size']
								));
							echo '</div>';
						}
					?>
				</div>
			</div>
		</div>			
	</div>
	<?php echo ($settings['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
	<?php echo ($settings['ca_navigation'] ? '<div class="swiper-nav-next"></div><div class="swiper-nav-prev"></div>' : '' ); ?>
</div>
<?php
wp_reset_postdata();