<?php 

/*
Plugin Name: KSAS External Video Link Widget
Plugin URI: https://inkthemes.com
Description: Link to your video on YouTube. Grabs thumb from API. Opens video in new window.
Author: KSAS Communications
Version: 1
Author URI: http://krieger.jhu.edu
*/

class KSAS_Video_Link_Widget extends WP_Widget {
  /**
  * To create the widget all four methods will be nested
  * inside this single instance of the WP_Widget class.
  **/

	public function __construct() {
	$widget_options = array( 
	  'classname' => 'ksas_video_link_widget',
	  'description' => 'Link to your video on YouTube. Video opens in new tab.',
	);
	parent::__construct( 'ksas_video_link_widget', 'KSAS Video Link Widget', $widget_options );
	}

	/* Widget Options */
	public function form($instance) {
		// Check values
		if( $instance) {
			$title = esc_attr($instance['title']);
			$link = esc_attr($instance['link']);
			$videoid = esc_attr($instance['videoid']);
			$textarea = $instance['textarea'];
		} else {
			$title = '';
			$link = '';
			$videoid = '';
			$textarea = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ksas_video_link_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<p>
		<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'ksas_video_link_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('videoid'); ?>"><?php _e('Video ID', 'ksas_video_link_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('videoid'); ?>" name="<?php echo $this->get_field_name('videoid'); ?>" type="text" value="<?php echo $videoid; ?>" />
		</p>
		<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Description:', 'ksas_video_link_widget'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>" rows="7" cols="20" ><?php echo $textarea; ?></textarea>
		</p>
		<?php
		}

	/* Update/Save the widget settings. */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['videoid'] = strip_tags($new_instance['videoid']);
		$instance['textarea'] = strip_tags($new_instance['textarea']);
		return $instance;
		}

	/* Widget Display */
	public function widget($args, $instance) {
		extract( $args );

		// these are the widget options
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$link = isset( $instance['link'] ) ? $instance['link'] : '';
		$videoid = isset( $instance['videoid'] ) ? $instance['videoid'] : '';
		$textarea = $instance['textarea'];
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; ?>

		<div class="video-thumbnail">
			<a href="<?php echo $link;?>" target="_blank" rel="noopener">
				<img src="https://img.youtube.com/vi/<?php echo $videoid; ?>/mqdefault.jpg" alt="<?php echo $title;?>">
				<div class="playbutton"></div>
			</a>
		</div>
		<div class="description">
			<p><?php echo $textarea;?></p>
		</div>
	
		<?php echo $after_widget; 
	}
}

/* Register Widget */
add_action('widgets_init', 'ksas_register_external_video_link_widgets');
	function ksas_register_external_video_link_widgets() {
		register_widget('KSAS_Video_Link_Widget');
	}
?>