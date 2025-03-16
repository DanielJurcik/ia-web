<?php
/**
 * Blog Post Main File.
 *
 * @package CHARITYHOME
 * @author  Tona Theme
 * @version 1.0
 */

get_header();
$data    = \CHARITYHOME\Includes\Classes\Common::instance()->data( 'single' )->get();
$layout = $data->get( 'layout' );
$sidebar = $data->get( 'sidebar' );
if (is_active_sidebar( $sidebar )) {$layout = 'right';} else{$layout = 'full';}
$class = ( !$layout || $layout == 'full' ) ? 'col-xs-12 col-sm-12 col-md-12' : 'col-xs-12 col-sm-12 col-md-8';
$options = charityhome_WSH()->option();

if ( class_exists( '\Elementor\Plugin' ) && $data->get( 'tpl-type' ) == 'e') {
	
	while(have_posts()) {
	   the_post();
	   the_content();
    }

} else {
?>

<!--Page Title-->
<section class="inner-header" style="background-image: url('<?php echo esc_url( $data->get( 'banner' ) ); ?>')">
    <div class="container">
        <div class="row">
            <div class="col-md-12 sec-title colored text-center">
                <h2><?php if( $data->get( 'title' ) ) echo wp_kses( $data->get( 'title' ), true ); else( wp_title( '' ) ); ?></h2>
                <ul class="breadcumb">
                    <?php echo charityhome_the_breadcrumb(); ?>
                </ul>
                <span class="decor"><span class="inner"></span></span>
            </div>
        </div>
    </div>
</section>
<!--End Page Title-->

<?php 
	echo do_shortcode('[pickMenuForPost]');
?>

<!--Sidebar Page Container-->
<section class="blog-home sec-padding blog-page blog-details">
    <div class="container">
        <div class="row">
        	<?php
				if ( $data->get( 'layout' ) == 'left' ) {
					do_action( 'charityhome_sidebar', $data );
				}
			?>
            <div class="content-side <?php echo esc_attr( $class ); ?>">
            	<?php while ( have_posts() ) : the_post(); ?>
                <div class="thm-unit-test">
                	
                    <div class="single-blog-post">
                        <?php if( has_post_thumbnail() ):?>
                        <div class="img-box">
                            <?php the_post_thumbnail('charityhome_1170x400'); ?>
                        </div>
                        <?php endif;?>
                        <div class="content-box">
                            <div class="date-box">
                                <div class="inner">
                                    <div class="date">
                                        <b><?php echo get_the_date('d'); ?></b>
										<?php echo get_the_date('M'); ?>
                                        <hr>
                                        <?php echo get_the_date('Y'); ?>
                                    </div>
                                    <div class="comment">
                                        <i class="flaticon-interface-1"></i> <?php comments_number( wp_kses(__('0' , 'charityhome'), true), wp_kses(__('1' , 'charityhome'), true), wp_kses(__('%' , 'charityhome'), true)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                
                                <div class="text">
									<?php the_content(); ?>
                                    <div class="clearfix"></div>
                                    <?php wp_link_pages(array('before'=>'<div class="paginate-links">'.esc_html__('Pages: ', 'charityhome'), 'after' => '</div>', 'link_before'=>'<span>', 'link_after'=>'</span>')); ?>
                                </div>
                                
                                <?php if(function_exists('bunch_share_us_two') || has_tag()):?>
                                <div class="bottom-box clearfix">
                                    <?php if(has_tag()){ ?>
                                    <span class="pull-left"><?php the_tags( 'Tags: ', ', ', '' ); ?></span>
									<?php } ?>
                                    
                                    <?php if(function_exists('bunch_share_us')):?>
									<?php echo wp_kses(bunch_share_us(get_the_id(),$post->post_name ), true);?>
                                    <?php endif;?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if( $options->get( 'single_post_author_box' ) ):?>
                    <div class="admin-info">
                        
						<?php if($avatar = get_avatar(get_the_author_meta('ID')) !== FALSE): ?>
                        <div class="img-box">
                            <div class="inner-box">
                            	<?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="content">
                            <h3><?php the_author(); ?></h3>
                            <p><?php the_author_meta( 'description', get_the_author_meta('ID') ); ?></p>
                            <?php if( $options->get( 'single_post_author_links' ) ):?>
								<?php $icons = $options->get( 'single_post_author_social_share' );
                                if ( ! empty( $icons ) ) :
                            ?>
                            <ul class="social">
                                <?php
								foreach ( $icons as $h_icon ) :
								$header_social_icons = json_decode( urldecode( charityhome_set( $h_icon, 'data' ) ) );
								if ( charityhome_set( $header_social_icons, 'enable' ) == '' ) {
									continue;
								}
								$icon_class = explode( '-', charityhome_set( $header_social_icons, 'icon' ) );
								?>
								<li><a href="<?php echo esc_url(charityhome_set( $header_social_icons, 'url' )); ?>" style="background-color:<?php echo esc_attr(charityhome_set( $header_social_icons, 'background' )); ?>; color: <?php echo esc_attr(charityhome_set( $header_social_icons, 'color' )); ?>"><i class="fa <?php echo esc_attr( charityhome_set( $header_social_icons, 'icon' ) ); ?>"></i></a></li>
								<?php endforeach; ?>
                            </ul>
                            <?php endif; endif;?>
                        </div>
                    </div>
                    <?php endif;?>
                    
                    
                    <!--End Single blog Post-->
                    <?php comments_template(); ?>
            	
				</div>
                <?php endwhile; ?>
            </div>
        	<?php
				if ( $data->get( 'layout' ) == 'right' ) {
					do_action( 'charityhome_sidebar', $data );
				}
			?>
        </div>
    </div>
</section>
<!--End blog area-->

<?php
}
get_footer();

