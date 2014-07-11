<div id="sidebar" class="four columns">

    <?php 
	if(is_page()){
		/* Page Sidebar */
		if(get_post_meta( get_the_ID(), 'minti_customsidebar', true ) != ''){ 
			echo do_shortcode(get_post_meta( get_the_ID(), 'minti_customsidebar', true ));
		} else {
			if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Widgets') );
		}
	}
	else {
		/* Blog Sidebar */
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Widgets') );
	}
	?>

</div>