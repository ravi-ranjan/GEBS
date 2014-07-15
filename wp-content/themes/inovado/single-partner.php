<?php get_header(); 
$getDetails = get_post_meta(get_the_ID());
?>
<?php get_template_part( 'framework/inc/titlebar' ); ?>

<div id="page-wrap" class="container portfolio-detail partner_detail">
  <div id="content">
  <div class="portfolio-sidebyside clearfix">

    <div class="portfolio-detail-attributes" id="back"> <a href="<?php echo get_the_permalink(2333); ?>" class="button">Back to Partners</a> </div>
    <?php 
		
		if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "wide" ) {
			get_template_part( 'framework/inc/portfolio/wide' );
		} else {
			?>
    <div class="one_half">
      <?php
			if ( has_post_thumbnail()) {
				
				echo "<div class='featured_image_partner'>".get_the_post_thumbnail(get_the_ID(),'medium')."</div>";
			}
			echo '<div class="partner-country-description">';
			echo '<ul>';
			if(get_post_meta( get_the_ID(),'partner_country',true) != '' )
			{ 
				echo "<li> ".get_post_meta( get_the_ID(), "partner_country", true ).'</li>';
			}
			if(get_post_meta( get_the_ID(), "custom_post_cat_select") != "" ){
				
				$getServices = get_post_meta( get_the_ID(), "custom_post_cat_select");
				foreach(array_unique($getServices) as $service){
				echo '<li>'.$service.'</li>';
				$s++;
				}
			}
			echo '</ul>';
			echo '</div>';
			echo '<p>'.get_the_content(get_the_ID()).'</p>';
		
			$lat = get_post_meta( get_the_ID(),'partner_lat',true);
			$lon = get_post_meta( get_the_ID(),'partner_lng',true);
			if($lat != '' && $lon != ''){ ?>
            <div class="portfolio-detail-description">
	        	<h3 class="title partner_title"><span>Location</span></h3>
        		<div class="portfolio-detail-description-text partner-detail-description-text">
					<?php echo do_shortcode('[map id="map2" z="16" style="full" address="Miami" marker="yes" lat='.$lat.' lon='.$lon.'  infowindow=""]');?>
        		</div>
      		</div>
            <?php
				}
			}?>
    </div>
    <div class="one_half last">
      <div class="portfolio-detail-description">
        <h3 class="title partner_title"><span>Sales Enquiries</span></h3>
        <div class="portfolio-detail-description-text partner-detail-description-text">
          <div class="contact"><span>Contact: </span> <?php echo get_post_meta( get_the_ID(),'partner_contact_name',true); ?></div>
          <div class="contact"><span>Telephone: </span><?php echo get_post_meta( get_the_ID(),'partner_telephone',true);?></div>
        </div>
      </div>
      <div class="portfolio-detail-description">
        <h3 class="title partner_title"><span>Send a Message</span></h3>
        <div class="description clearfix style-1">
          <?php echo do_shortcode('[contact-form-7 id="2827" title="Partner Contact Form"]'); ?>
        </div>
      </div>
    </div>

    <div class="clear"></div>
    <!-- end of portfolio-related-posts -->
    
    <?php //end related specific ?>
    <div class="clear"></div>
    <?php endwhile; endif; ?>
  </div>
  <!-- end of content --> 
  
</div>
</div>
<!-- end of page-wrap -->

<?php get_footer(); ?>
