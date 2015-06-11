<?php
/**
  * Plugin Name: WPMU Post Meta Box Image Uploader
  * Description: Adds a Meta Box for Drag and Drop Media Upload to the edit post screens. It does not attach the image, but is handy for quick image uploads. Supports the following post_types: 'post', 'video', 'image', 'page'.
  * Version:  1.0
  * Author: Jason Jersey
  */


class wpmu_pmbiu{
	
    private $plugin_name = "";
	
	/* Initialize */
	public function __construct(){

		$this->plugin_name = basename(dirname( __FILE__ ));
			
		//hook onto add_meta_boxes action
		add_action( 'add_meta_boxes', array($this, 'add_wpmu_pmbiues') );
  
	}

	/* build meta boxes */
	function build_wpmu_pmbiu(){
			global $post;
			
			wp_enqueue_script('plupload-handlers');
			
			$form_class='media-upload-form type-form validate';
			$post_id = $post->ID;
			$_REQUEST['post_id'] = $post_id;
			?>
			<style>#media-items { width: auto; }</style>
		
			<?php media_upload_form(); ?>
		
			<script type="text/javascript">
			var post_id = <?php echo $post_id; ?>;
			var shortform = 3;
			</script>

			<div id="media-items" class="hide-if-no-js"></div>
		
	 <?php	 
	 }

	/* add meta boxes to post_types */
	function add_wpmu_pmbiues(){
		
		if(current_user_can('upload_files')){
	
			$id = "image_upload";
			$title= "Upload Image";
			$callback = "build_wpmu_pmbiu";
			$context = "side";
			$screens = array( 'post', 'video', 'image', 'page' );
			
			foreach ($screens as $screen) {
				add_meta_box(
					$id,
					__( $title, $id),
					array($this, $callback),
					$screen,
					$context
				);
			}
		}
	}

}

$wpmu_pmbiu = new wpmu_pmbiu;
