<?php
/**
 * This is a plugin that links a video to YouTube.
 * It grabs a thumbnail from YouTube's API and opens video in new window.
 *
 * @package   KSAS_VIDEO_LINK
 * @author    KSAS Communications <ksasweb@jhu.edu>
 * @license   GPL-2.0+
 * @link      https://krieger.jhu.edu
 * @copyright 2022 KSAS Communications
 * @version   2.0
 *
 * @wordpress-plugin
 * Plugin Name: KSAS External Video Link Widget
 * Plugin URI: https://github.com/ksascomm
 * Description: Link to your video on YouTube. Grabs thumb from API. Opens video in new window.
 * Version: 2.0
 * Author: KSAS Communications
 * Author URI: http://krieger.jhu.edu
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Adds KSAS_Video_Link_Widget widget.
 */
class KSAS_Video_Link_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'ksas_video_link_widget',
			esc_html__( 'KSAS Video Link Widget', 'ksasacademic' ),
			array(
				'classname'   => 'ksas_video_link_widget',
				'description' => esc_html__( 'Link to your video on YouTube. Video opens in new tab.', 'ksasacademic' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>
		<?php
		/* Our variables from the widget settings. Needed for HTML to work */
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$link     = isset( $instance['link'] ) ? $instance['link'] : '';
		$videoid  = isset( $instance['videoid'] ) ? $instance['videoid'] : '';
		$textarea = $instance['textarea'];
		?>
		<div class="video-thumbnail">
			<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
				<img src="https://img.youtube.com/vi/<?php echo esc_html( $videoid ); ?>/hqdefault.jpg" alt="Youtube Video thumbnail for <?php echo esc_html( $title ); ?>">
				<div class="playbutton"></div>
			</a>
		</div>
		<div class="description">
			<p><?php echo esc_html( $textarea ); ?></p>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title    = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Enter title', 'ksasacademic' );
		$link     = ! empty( $instance['link'] ) ? $instance['link'] : esc_html__( 'Enter Link', 'ksasacademic' );
		$videoid  = ! empty( $instance['videoid'] ) ? $instance['videoid'] : esc_html__( 'Enter Video ID', 'ksasacademic' );
		$textarea = ! empty( $instance['textarea'] ) ? $instance['textarea'] : esc_html__( 'Enter Description', 'ksasacademic' );
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title', 'ksasacademic' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'Link', 'ksasacademic' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'videoid' ) ); ?>"><?php esc_attr_e( 'Video ID', 'ksasacademic' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'videoid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'videoid' ) ); ?>" type="text" value="<?php echo esc_attr( $videoid ); ?>" />
		</p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php esc_attr_e( 'Description:', 'ksasacademic' ); ?></label>
		<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>" rows="7" cols="20" ><?php echo esc_html( $textarea ); ?></textarea>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		// Fields.
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link']     = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';
		$instance['videoid']  = ( ! empty( $new_instance['videoid'] ) ) ? sanitize_text_field( $new_instance['videoid'] ) : '';
		$instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? sanitize_text_field( $new_instance['textarea'] ) : '';
		return $instance;
	}
}

	/**
	 * Register Widget
	 */
function ksas_register_external_video_link_widgets() {
	register_widget( 'KSAS_Video_Link_Widget' );
}
	add_action( 'widgets_init', 'ksas_register_external_video_link_widgets' );

?>
