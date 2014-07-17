<?php
/*
Template Name: Portfolio: 3 Columns
*/
?>

<?php get_header(); ?>

<?php 
$getPageName = trim(get_the_title(get_the_ID()));
get_template_part( 'framework/inc/titlebar' ); 

?>
	
<div id="page-wrap" class="container portfolio">
	<div id="filters" class="sixteen columns">
	<?php	
		if ($getPageName == "Partners"){
		$partner_regions = get_terms('partner region');
			if($partner_regions): ?>
				<ul class="clearfix">
					<li><a href="#" data-filter="*" class="active"><?php _e('All', 'minti'); ?></a></li>	
					<?php foreach($partner_regions as $partner_region): ?>
						<?php if(get_post_meta(get_the_ID(), 'minti_portfoliofilter', false)  && !in_array('0', get_post_meta(get_the_ID(), 'minti_portfoliofilter', false))): ?>
							<?php if(in_array($partner_region->term_id, get_post_meta(get_the_ID(), 'minti_portfoliofilter', false))): ?>
								<li><a href="#" data-filter=".term-<?php echo $partner_region->slug; ?>"><?php echo $partner_region->name; ?></a></li>
							<?php endif; ?>
						<?php else: ?>
							<li><a href="#" data-filter=".term-<?php echo $partner_region->slug; ?>"><?php echo $partner_region->name; ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; 
		}
		if ($getPageName == "Videos" || $getPageName == "Tutorials" || $getPageName == "Webinars" ){
			
		$active_video = '';	$taxonomy_video='';
		if($getPageName == "Tutorials") { $active_video = 'tutorial';  $taxonomy_video = 47; }
		if($getPageName == "Webinars") { $active_video = 'webinar'; $taxonomy_video = 45; }
				
		$partner_regions = get_terms('video type');
			if($partner_regions): ?>
				<ul class="clearfix">
					<li><a href="#" data-filter="*" <?php echo ($getPageName == "Videos") ? 'class="active"' : '' ; ?>><?php _e('All', 'minti'); ?></a></li>	
					<?php foreach($partner_regions as $partner_region): ?>
							<li><a href="#" data-filter=".term-<?php echo $partner_region->slug; ?>" <?php if ($active_video == $partner_region->slug) { ?> class="active" <?php } ?>><?php echo $partner_region->name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; 
		}
		?>
	</div>
	
	<div id="portfolio-wrap">
		<?php
		
			if($getPageName == "Partners"){
			global $wp_query;
			$portfolioitems = $data['text_portfolioitems']; // Get Items per Page Value
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type' 		=> 'partner',
				'posts_per_page' 	=> $portfolioitems,
				'post_status' 		=> 'publish',
				'orderby' 			=> 'date',
				'order' 			=> 'DESC',
				'paged' 			=> $paged
			);
			
			// Only pull from selected Filters if chosen
			$selectedfilters = get_post_meta(get_the_ID(), 'minti_portfoliofilter', false);
			if($selectedfilters && $selectedfilters[0] == 0) {
				unset($selectedfilters[0]);
			}
			if($selectedfilters){
				$args['tax_query'][] = array(
					'taxonomy' 	=> 'partner region',
					'field' 	=> 'ID',
					'terms' 	=> $selectedfilters
				);
			}
			
			$wp_query = new WP_Query($args);
			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<?php $terms = get_the_terms( get_the_ID(), 'partner region' ); 
				$getCustomPostValues = get_post_custom(get_the_ID());
			?>              	
			<div class="<?php if($terms) : foreach ($terms as $term) { echo 'term-'.$term->slug.' '; } endif; ?>portfolio-item one-third columns">
				
				<?php // Define if Lightbox Link or Not
				
				$embedd = '';
				
				if( get_post_meta( get_the_ID(), 'minti_portfolio-lightbox', true ) == "true") { 
					$lightboxtype = '<span class="overlay-lightbox"></span>';
					if( get_post_meta( get_the_ID(), 'minti_embed', true ) != "") {
							if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'youtube' ) {
								$link = '<a href="http://www.youtube.com/watch?v='.get_post_meta( get_the_ID(), 'minti_embed', true ).'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'vimeo' ) {
		    					$link = '<a href="http://vimeo.com/'. get_post_meta( get_the_ID(), 'minti_embed', true ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'own' ) {
		    					$randomid = rand();
		    					$link = '<a href="#embedd-video-'.$randomid.'" class="prettyPhoto" title="'. get_the_title() .'" rel="prettyPhoto[portfolio]">';
		    					$embedd = '<div id="embedd-video-'.$randomid.'" class="embedd-video"><p>'. get_post_meta( get_the_ID(), 'minti_embed', true ) .'</p></div>';
							}
					} else {
						$link = '<a href="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    		}
		    	}
				else{
					$lightboxtype = '<span class="overlay-link"></span>';
					$link = '<a href="'. get_permalink() .'" title="'. get_the_title() .'">';
					$embedd = '';
				} ///// ?>
			
				<?php if ( has_post_thumbnail()) { ?> 
					<div class="portfolio-it">
				  		<?php echo $link; ?><span class="portfolio-pic"><?php the_post_thumbnail('eight-columns'); ?><div class="portfolio-overlay1"><?php echo $lightboxtype; ?></div></span></a>
				  		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="portfolio-title partner-title"><h4><?php the_title(); ?></h4>
				  		<span>
							<?php 	
								if(get_post_meta( get_the_ID(),'partner_city',true) != '' )
								{ 
									echo get_post_meta( get_the_ID(), "partner_city", true );
								}
								if(get_post_meta( get_the_ID(),'partner_country',true) != '' )
								{ 
									echo (get_post_meta( get_the_ID(),'partner_city',true) != '' ? " , " : "").get_post_meta( get_the_ID(), "partner_country", true );
								}
							?>
                         </span>
                         </a>
				  	</div>
				  	<?php echo $embedd; ?>
				<?php } ?>
							
			</div> <!-- end of terms -->	
			
		<?php endwhile; 
		}
			if($getPageName == "Videos" || $getPageName == "Tutorials" || $getPageName == "Webinars" ){
			global $wp_query;
			$portfolioitems = $data['text_portfolioitems']; // Get Items per Page Value
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type' 		=> 'videos',
				'posts_per_page' 	=> $portfolioitems,
				'post_status' 		=> 'publish',
				'orderby' 			=> 'date',
				'order' 			=> 'DESC',
				'paged' 			=> $paged,
			);
			
			// Only pull from selected Filters if chosen
			$selectedfilters = get_post_meta(get_the_ID(), 'minti_portfoliofilter', false);
			if($selectedfilters && $selectedfilters[0] == 0) {
				unset($selectedfilters[0]);
			}
			if($taxonomy_video != '')
			{
				//$selectedfilters = $taxonomy_video;
			}
			//print_r($selectedfilters);
			if($selectedfilters){
				$args['tax_query'][] = array(
					'taxonomy' 	=> 'video type',
					'field' 	=> 'ID',
					'terms' 	=> $selectedfilters
				);
			}
			
			$wp_query = new WP_Query($args);
			?>
        
            <?php
			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<?php $terms = get_the_terms( get_the_ID(), 'video type' ); 
				$getCustomPostValues = get_post_custom(get_the_ID());
			?>              	
			<div class="<?php if($terms) : foreach ($terms as $term) { echo 'term-'.$term->slug.' '; } endif; ?>portfolio-item one-third columns <?php  echo ($active_video != $term->slug) ? 'isotope-item isotope-hidden' : 'isotope-item' ; ?>"  
	<?php		if($active_video != $term->slug) { echo 'style="opacity:0;transform:translate(0px, 0px) !important"'; } ?>
    >
    				<?php // Define if Lightbox Link or Not
				
				$embedd = '';
				
				if( get_post_meta( get_the_ID(), 'minti_portfolio-lightbox', true ) == "true") { 
					$lightboxtype = '<span class="overlay-lightbox"></span>';
					if( get_post_meta( get_the_ID(), 'minti_embed', true ) != "") {
							if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'youtube' ) {
								$link = '<a href="http://www.youtube.com/watch?v='.get_post_meta( get_the_ID(), 'minti_embed', true ).'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'vimeo' ) {
		    					$link = '<a href="http://vimeo.com/'. get_post_meta( get_the_ID(), 'minti_embed', true ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'minti_source', true ) == 'own' ) {
		    					$randomid = rand();
		    					$link = '<a href="#embedd-video-'.$randomid.'" class="prettyPhoto" title="'. get_the_title() .'" rel="prettyPhoto[portfolio]">';
		    					$embedd = '<div id="embedd-video-'.$randomid.'" class="embedd-video"><p>'. get_post_meta( get_the_ID(), 'minti_embed', true ) .'</p></div>';
							}
					} else {
						$link = '<a href="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    		}
		    	}
				else{
					$lightboxtype = '<span class="overlay-link"></span>';
					$link = '<a href="'. get_permalink() .'" title="'. get_the_title() .'">';
					$embedd = '';
				} ///// 
				?>
			
				<?php if ( has_post_thumbnail()) { ?> 
					<div class="portfolio-it">
				  		<?php echo $link; ?><span class="portfolio-pic"><?php the_post_thumbnail('eight-columns'); ?><div class="portfolio-overlay1"><?php echo $lightboxtype; ?></div></span></a>
				  		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="portfolio-title video-title"><h4><?php the_title(); ?></h4>
				  		<span>
							<?php 	
								if(get_post_meta( get_the_ID(),'sub_title',true) != '' )
								{ 
									echo get_post_meta( get_the_ID(), "sub_title", true );
								}
							?>
                         </span>
                         </a>
				  	</div>
				  	<?php echo $embedd; ?>
				<?php } ?>
							
			</div> <!-- end of terms -->	
			
		<?php endwhile; 
		}
		?>
	</div>
	
	<div class="sixteen columns">
		<?php get_template_part( 'framework/inc/nav' ); ?>
	</div>
	
</div>


<?php get_footer(); ?>
<script>
jQuery(document).ready(function($){
		var $container = jQuery('#portfolio-wrap');
		//jQuery('#filters a').removeClass('active');
	//	jQuery('#filters a').removeClass('active');
		jQuery(this).addClass('active');
		<?php
		if($active_video =='')
		{
			?>
			var selector ='*';
			<?php
		}
		else
		{
			?>
			var selector ='<?php echo '.term-'.$active_video; ?>';
			<?php
		}
		?>
		
		//alert(selector);
	  	$container.isotope({ filter: selector });
		//jQuery('#filters a').removeClass('active');
		jQuery(this).addClass('active');
});
</script>