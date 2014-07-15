<?php global $data; ?>

<?php 
$getPageName = trim(get_the_title(get_the_ID()));
$post = get_queried_object();
if ($post->post_type ==  'post') {
    $post_format = get_post_format();
} else {
    $post_format = $post->post_type;
}
if (!is_singular('portfolio')) { ?>
		<?php if ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'featuredimage' ) { ?>
		<!-- Titlebar Type: Post Thumbnail -->
            <div id="<?php echo ($getPageName != 'Videos' && $getPageName != 'Partners' ? 'alt-title' : 'alt-title-2' );?>" style="background-image: url( <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' ); echo $src[0]; ?> );">
				<div class="grid"></div>
				<div class="container">
                	<div class="ten columns">
					<h1><?php the_title(); ?><?php if($data['text_titledivider'] != "") { echo $data['text_titledivider']; } ?></h1>
					<?php if(get_post_meta( get_the_ID(), 'minti_subtitle', true )){ echo '<h2>'.get_post_meta( get_the_ID(), 'minti_subtitle', true ).'</h2>'; } ?>
                    </div>
                    <?php if($getPageName == 'Videos' || $getPageName == 'Partners'){  ?>
					<?php if(get_post_meta( get_the_ID(), 'minti_featuredimage-breadcrumbs', true ) == true) { ?>
						<div id="breadcrumbs" class="six columns breadrcumbpadding">
							<div id="crumbs">
							<?php minti_breadcrumbs(); ?>
							</div>
						</div>
					<?php }
					} ?>
                    
				</div>
			</div>
            <?php if($getPageName != 'Videos' && $getPageName != 'Partners'){ ?>
            <div id="alt-breadcrumbs">
			<?php if(get_post_meta( get_the_ID(), 'minti_featuredimage-breadcrumbs', true ) == true) { ?>
                <div id="breadcrumbs" class="six columns breadrcumbpadding container">
                    <div id="crumbs">
                        <?php minti_breadcrumbs(); ?>
                    </div>
                </div>
		<?php } ?>	
	        </div>
            <?php } ?>
			<?php if($getPageName != 'Videos' && $getPageName != 'Partners'){if($data['check_stripedborder']) { ?><div class="hr-border"></div><?php }} ?>
			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } elseif ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'featuredimage2' ) { ?>
		<!-- Titlebar Type: No Titlebar -->
		
			<div id="alt-title-2" class="post-thumbnail" style="background-image: url( <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' ); echo $src[0]; ?> );">
				<div class="container">
					<div class="ten columns">
						<h1><?php the_title(); ?><?php if($data['text_titledivider'] != "") { echo $data['text_titledivider']; } ?></h1>
					</div>
					<?php if(get_post_meta( get_the_ID(), 'minti_featuredimage-breadcrumbs', true ) == true) { ?>
						<div id="breadcrumbs" class="six columns">
							<?php  minti_breadcrumbs(); ?>
						</div>
					<?php } ?>
				</div>
			</div>

			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
		
		<?php } elseif (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'notitlebar') { ?>
		<!-- Titlebar Type: No Titlebar -->
		
			<?php if(get_post_meta( get_the_ID(), 'minti_featuredimage-breadcrumbs', true ) == true) { ?>
			<div id="no-title">
				<div class="container">
						<div id="breadcrumbs" class="sixteen columns <?php if(get_post_meta( get_the_ID(), 'minti_subtitle', true )){ echo 'breadrcumbpadding'; } /* to align middle */ ?>">
							<?php  minti_breadcrumbs(); ?>
						</div>
				</div>
			</div>
			<?php if($data['check_stripedborder']) { ?><div class="hr-border"></div><?php } ?>
			<?php } else { ?>
			<div id="no-title-divider"></div>
			<?php if($data['check_stripedborder']) { ?><div class="hr-border"></div><?php } ?>
			<?php } ?>
			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
		
		<?php } elseif (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'revslider') { ?>
		<!-- Titlebar Type: Revolution Slider -->
		
			<div class="clear"></div>
	
			<?php if(class_exists('RevSlider')){ putRevSlider(get_post_meta( get_the_ID(), 'minti_revolutionslider', true )); } ?>
			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } elseif (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'flexslider') { ?>
		<!-- Titlebar Type: FlexSlider -->
			
			<div id="title-flexslider">
				<div class="container">
					<div class="sixteen columns">
						<?php echo do_shortcode('[wooslider slide_page="'.get_post_meta( get_the_ID(), 'minti_flexslider', true ).'" slider_type="slides" limit="5"]'); ?>
					</div>
				</div>
			</div>
			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } else { ?>
		<!-- Titlebar Type: Default Titlebar -->
			<?php /*if($post_format == "videos"){?>
                <div id="title">
                            <div class="container">
                                <div class="ten columns">
                                    <h1><?php the_title(); ?><?php if($data['text_titledivider'] != "") { echo $data['text_titledivider']; } ?></h1>
                                    <?php if(get_post_meta( get_the_ID(), 'sub_title', true )){ echo '<h2>'.get_post_meta( get_the_ID(), 'sub_title', true ).'</h2>'; } ?>
                                </div>
                                <div class="projects-nav <?php if( (get_post_meta( get_the_ID(), 'minti_subtitle', true )) == false ){ echo 'projectsnavpadding'; } //to align middle  ?>">
                                    <?php next_post_link('<div class="next">%link</div>', __('Next', 'minti')); ?>  
                                    <?php previous_post_link('<div class="prev">%link</div>', __('Previous', 'minti')); ?>
                                </div>
                            </div>
                        </div>	
<?php }else{*/?>
			<div id="title">
				<div class="container">
					<div class="ten columns">
						<h1><?php the_title(); ?><?php if($data['text_titledivider'] != "") { echo $data['text_titledivider']; } ?></h1>
						<?php echo (get_metadata('post',get_the_ID(),'partner_url',true) != '' ? '<span>'.get_metadata('post',get_the_ID(),'partner_url',true).'</span>' : ""); ?>
					</div>
                    <?php if($post_format == "partner"){ ?>
                    <div id="breadcrumbs">
                    	<div id="crumbs">
                    	Partner
                        </div>
                    </div>
                    <?php } ?>
					<?php if(get_post_meta( get_the_ID(), 'minti_featuredimage-breadcrumbs', true ) == true) { ?>
						<div id="breadcrumbs" class="six columns <?php if(get_post_meta( get_the_ID(), 'minti_subtitle', true )){ echo 'breadrcumbpadding'; } /* to align middle */ ?>">
							<?php  minti_breadcrumbs(); ?>
						</div>
					<?php } ?>
				</div>
			</div>
           <?php //} ?>
		
		<?php } ?>
		
	<?php /* ---------------------------------------------------------------------------------------*/ ?>
	
	<!-- End: Title Bar -->
	
<?php 
/*$getPageName = get_the_title(get_the_ID());
echo get_the_ID()."<BR>";
echo "GET PG NAME : ";
print_r(get_post_types());*/

?>
<?php } else { // Begin: Single Projects Title bar ?>

	<?php if (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'notitlebar') { ?>
		
		<div id="no-title-divider"></div>
		<?php if($data['check_stripedborder']) { ?><div class="hr-border"></div><?php } ?>
		
	<?php } else { ?>

		<div id="title">
			<div class="container">
				<div class="ten columns">
					<h1><?php the_title(); ?><?php if($data['text_titledivider'] != "") { echo $data['text_titledivider']; } ?></h1>
					<?php if(get_post_meta( get_the_ID(), 'minti_subtitle', true )){ echo '<h2>'.get_post_meta( get_the_ID(), 'minti_subtitle', true ).'</h2>'; } ?>
				</div>
				<div class="projects-nav <?php if( (get_post_meta( get_the_ID(), 'minti_subtitle', true )) == false ){ echo 'projectsnavpadding'; } /* to align middle */ ?>">
					<?php next_post_link('<div class="next">%link</div>', __('Next', 'minti')); ?>  
					<?php previous_post_link('<div class="prev">%link</div>', __('Previous', 'minti')); ?>
				</div>
			</div>
		</div>
		
		<?php if($data['check_stripedborder']) { ?><div class="hr-border"></div><?php } ?>
	
	<?php } ?>

	<!-- End: Projects Title Bar -->

<?php } ?>