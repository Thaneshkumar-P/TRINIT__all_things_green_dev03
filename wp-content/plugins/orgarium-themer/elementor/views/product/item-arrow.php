<?php
	if (!defined('ABSPATH')){ exit; }
	global $orgarium_post, $post;
	if( !$orgarium_post ){ return; }
	if( $orgarium_post->post_type != 'product' ){ return; }
?>

<?php 
	if(\Elementor\Plugin::$instance->editor->is_edit_mode() || $post->post_type == 'gva__template'){
		echo '<div class="menu-single-product">';
			echo '<a href="#" rel="next"><i class="fas fa-chevron-left"></i></a>';
			echo '<a href="#" rel="prev"><i class="fas fa-chevron-right"></i></a>';
		echo '</div>';
	}else{
		echo '<div class="menu-single-product">';
			next_post_link( '%link',  '<i class="fas fa-chevron-left"></i>' , true, array(), 'product_cat' );
			previous_post_link( '%link',  '<i class="fas fa-chevron-right"></i>', true, array(), 'product_cat' );
		echo '</div>';
	}
