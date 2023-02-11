<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $orgarium_post;
   if (!$orgarium_post){
      return;
   }
   $html_tag = $settings['html_tag'];
?>

<div class="orgarium-post-title">
   <<?php echo esc_attr($html_tag) ?> class="post-title">
      <span><?php echo get_the_title($orgarium_post) ?></span>
   </<?php echo esc_attr($html_tag) ?>>
</div>   