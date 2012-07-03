<?php 

/*--------------------------------------------------------------------------
*
*	Field_groups
*
*	@author Elliot Condon
*	@since 3.2.6
* 
*-------------------------------------------------------------------------*/
 
 
class Field_groups 
{

	var $parent,
		$data;
		
	
	/*
	*  __construct
	*
	*  @description: 
	*  @since 3.1.8
	*  @created: 23/06/12
	*/
	
	function __construct($parent)
	{
	
		// vars
		$this->parent = $parent;
		
		
		// actions
		add_filter('pre_get_posts', array($this, 'pre_get_posts')); 
		add_action('admin_print_scripts', array($this,'admin_print_scripts'));
		add_action('admin_print_styles', array($this,'admin_print_styles'));
		add_action('admin_footer', array($this,'admin_footer'));
	}
	
	
	/*
	*  validate_page
	*
	*  @description: returns true | false. Used to stop a function from continuing
	*  @since 3.2.6
	*  @created: 23/06/12
	*/
	
	function validate_page()
	{
		// global
		global $pagenow;
		
		
		// vars
		$return = false;
		
		
		// validate page
		if( in_array( $pagenow, array('edit.php') ) )
		{
		
			// validate post type
			if( isset($GLOBALS['post_type']) && $GLOBALS['post_type'] == 'acf' )
			{
				$return = true;
			}	
			
		}
		
		
		// return
		return $return;
	}
	
	
	/*
	*  admin_print_scripts
	*
	*  @description: 
	*  @since 3.1.8
	*  @created: 23/06/12
	*/
	
	function admin_print_scripts()
	{
		// validate page
		if( ! $this->validate_page() ) return;
		
		wp_enqueue_script( 'jquery' );
    	wp_enqueue_script( 'thickbox' );
	}
	
	
	/*
	*  admin_print_styles
	*
	*  @description: 
	*  @since 3.1.8
	*  @created: 23/06/12
	*/
	
	function admin_print_styles()
	{
		// validate page
		if( ! $this->validate_page() ) return;
		
		wp_enqueue_style( 'thickbox' );
	}
	
	
	/*
	*  pre_get_posts
	*
	*  @description: 
	*  @since 3.0.6
	*  @created: 23/06/12
	*/
	
	function pre_get_posts($query)
	{
		// validate page
		if( ! $this->validate_page() ) return;
		
		$query->query_vars['posts_per_page'] = 999;
		  
    	return $query; 
	}
	
	
	/*
	*  admin_footer
	*
	*  @description: 
	*  @since 3.1.8
	*  @created: 23/06/12
	*/
	
	function admin_footer()
	{
		// validate page
		if( ! $this->validate_page() ) return;
	
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->parent->dir ?>/css/global.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->parent->dir ?>/css/acf.css" />
		<div id="acf-col-right" class="hidden">
		
			<div class="wp-box">
				<div class="inner">
					<h3 class="h2"><?php _e("Advanced Custom Fields",'acf'); ?> <span>v<?php echo $this->parent->version; ?></span></h3>
		
					<h3><?php _e("Changelog",'acf'); ?></h3>
					<p><?php _e("See what's new in",'acf'); ?> <a class="thickbox" href="<?php bloginfo('url'); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=advanced-custom-fields&section=changelog&TB_iframe=true&width=640&height=559">v<?php echo $this->parent->version; ?></a>
					
					<h3><?php _e("Resources",'acf'); ?></h3>
					<p><?php _e("Read documentation, learn the functions and find some tips &amp; tricks for your next web project.",'acf'); ?><br />
					<a href="http://www.advancedcustomfields.com/"><?php _e("View the ACF website",'acf'); ?></a></p>
		
				</div>
				<div class="footer">
					<ul class="left hl">
						<li><?php _e("Created by",'acf'); ?> Elliot Condon</li>
					</ul>
					<ul class="right hl">
						<li><a href="http://wordpress.org/extend/plugins/advanced-custom-fields/"><?php _e("Vote",'acf'); ?></a></li>
						<li><a href="http://twitter.com/elliotcondon"><?php _e("Follow",'acf'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		(function($){
			
			$('#screen-meta-links').remove();
			$('#wpbody .wrap').wrapInner('<div id="acf-col-left" />');
			$('#wpbody .wrap').wrapInner('<div id="acf-cols" />');
			$('#acf-col-right').removeClass('hidden').prependTo('#acf-cols');
			
		})(jQuery);
		</script>
		<?php
	}
			
}

?>