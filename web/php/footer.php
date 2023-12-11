<?php
/**
 * Footer Main File.
 *
 * @package CHARITYHOME
 * @author  Tona Theme
 * @version 1.0
 */
global $wp_query;
$page_id = ( $wp_query->is_posts_page ) ? $wp_query->queried_object->ID : get_the_ID();
?>

	<div class="clearfix"></div>

	<?php charityhome_template_load( 'templates/footer/footer.php', compact( 'page_id' ) );?>

	
    <!--Scroll to top-->
	<div class="scroll-to-top scroll-to-target" data-target="html"><span class="flaticon-heart-1"></span></div>

</div>

<?php wp_footer(); ?>
<script>
jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip({
	  position: { my: "left+15 center", at: "right center" }, 
	  tooltipClass: 'tooltip fade bs-tooltip-right show', 
	  content: function () {
            return '<div class="arrow" style="top: 8px;"></div><div class="tooltip-inner">' + jQuery(this).data('title') + '</div>' ;
        }
  });
})
</script>
</body>
</html>
