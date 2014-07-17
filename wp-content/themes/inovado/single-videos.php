<?php get_header(); ?>

<?php get_template_part( 'framework/inc/titlebar' ); ?>
	
<div id="page-wrap" class="container portfolio-detail">
	
	<div id="content">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "wide" ) {
			get_template_part( 'framework/inc/portfolio/wide' );
		} else { ?>
			
            <div class="portfolio-sidebyside clearfix">
                <div class="ten columns">
                 <div id="portfolio-video" class="ten columns alpha">
                 	<iframe src="<?php echo get_post_meta( get_the_ID(), 'video_url',true)?>?title=0&amp;byline=0&amp;portrait=0&amp;color=2f8ccc" width="500" height="313" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
<p><a href="<?php echo get_post_meta( get_the_ID(), 'video_url',true)?>"><?php echo get_post_meta( get_the_ID(), 'sub_title',true)?></a> from <a href="http://vimeo.com/user25219494">GEBS Unison</a> on <a href="https://vimeo.com">Vimeo</a>.</p> 
                 </div>
           <?php } ?>
                </div>
                <div class="six columns">
			       <div class="portfolio-detail-description">
                   		<h3 class="title video_title"><span>Video Description</span></h3>
                        <div class="portfolio-detail-description-text">
	                   		<?php echo get_the_content(get_the_ID());  ?>
                        </div>
                   </div>
                   <div class="portfolio-detail-attributes video-detail-attributes">
                        <h3 class="title video_title"><span>Video Details</span></h3>
                        <ul>
                            <li><strong>Published: </strong> <?php echo get_the_date();?></li>
                            <?php $posttags = get_the_tags(get_the_ID());
										if ($posttags) {
										?>
                                         <li><strong>Tags:</strong>
                                         <?php
										 	
										foreach ($posttags as $tag) {
											$tag_string .= "<a href='".get_tag_link($tag->term_id)."'>".$tag->name."</a>, ";						
										}
										echo substr($tag_string, 0, -2);
										?>
                                        </li>
										<?php
										} ?>
                            
                        </ul>
                    </div>
                    
                 </div>
        	</div>
		
		<!--Show related Videos specific-->
			
			<div class="clear"></div>
			
			<div id="portfolio-related-post">
				
				<h3 class="title video_title"><span><?php _e('Related Videos', 'minti'); ?></span></h3>
			
				<?php
				$terms = get_the_terms( $post->ID , 'video type', 'string');

				$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );
			
				$second_query = new WP_Query( array(
				      'post_type' => 'videos',
				      'tax_query' => array(
				                    array(
				                        'taxonomy' => 'video type',
				                        'field' => 'id',
				                        'terms' => $term_ids,
				                        'operator'=> 'IN' //Or 'AND' or 'NOT IN'
				                     )),
				      'posts_per_page' => 4,
				      'ignore_sticky_posts' => 1,
				      'orderby' => 'date',  // 'rand' for random order
				      'post__not_in'=>array($post->ID)
				   ) );
							
				//Loop through posts and display...
				if($second_query->have_posts()) {
					while ($second_query->have_posts() ) : $second_query->the_post(); ?>
					
					      <div class="portfolio-item four columns">

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
								  		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="portfolio-title video-title "><h4><?php the_title(); ?></h4>
								  		<span>
											<?php
												if(get_post_meta( get_the_ID(),'sub_title',true) != '' )
												{ 
													echo get_post_meta( get_the_ID(), "sub_title", true );
												}											
											  ?>
                                        </span></a>
								  	</div>
								  	<?php echo $embedd; ?>
								<?php } ?>

					      </div>
					   <?php endwhile; wp_reset_query(); ?>
				<?php } ?>
				
			</div> <!-- end of portfolio-related-posts -->
		
		<!--end related specific-->
		
		<div class="clear"></div>
	
		<?php endwhile; endif; ?>
	
	</div> <!-- end of content -->
	
</div> <!-- end of page-wrap -->

<?php get_footer(); ?>