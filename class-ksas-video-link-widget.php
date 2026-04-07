<?php
/**
 * KSAS_Video_Link_Widget Class
 *
 * File: class-ksas-video-link-widget.php
 *
 * @package KSAS_VIDEO_LINK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * KSAS Video Link Widget Class.
 *
 * This class handles the creation, display, and management of the
 * YouTube video link widget for the KSAS flagship properties.
 *
 * @package KSAS_VIDEO_LINK
 * @see     WP_Widget
 */
class KSAS_Video_Link_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'ksas_video_link_widget',
			esc_html__( 'KSAS Video Link Widget', 'ksas-flagship' ),
			array(
				'classname'   => 'ksas_video_link_widget',
				'description' => esc_html__( 'Link to your video on YouTube. Video opens in new tab.', 'ksas-flagship' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments (before_widget, after_widget, etc.).
	 * @param array $instance Saved values from the database for this specific widget.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$link     = ! empty( $instance['link'] ) ? $instance['link'] : '';
		$videoid  = ! empty( $instance['videoid'] ) ? $instance['videoid'] : '';
		$textarea = ! empty( $instance['textarea'] ) ? $instance['textarea'] : '';
		$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<div class="video-thumbnail">
			<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
				<img src="https://img.youtube.com/vi/<?php echo esc_attr( $videoid ); ?>/hqdefault.jpg" alt="<?php echo esc_attr__( 'Youtube Video thumbnail for ', 'ksas-flagship' ) . esc_attr( $title ); ?>">
				<div class="playbutton"></div>
			</a>
		</div>
		<?php if ( ! empty( $textarea ) ) : ?>
			<div class="description">
				<p><?php echo esc_html( $textarea ); ?></p>
			</div>
		<?php endif; ?>
		<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 * @return string|void Default return is 'noform'.
	 */
	public function form( $instance ) {
		$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$link     = ! empty( $instance['link'] ) ? $instance['link'] : '';
		$videoid  = ! empty( $instance['videoid'] ) ? $instance['videoid'] : '';
		$textarea = ! empty( $instance['textarea'] ) ? $instance['textarea'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ksas-flagship' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Full YouTube URL:', 'ksas-flagship' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'videoid' ) ); ?>"><?php esc_html_e( 'Video ID:', 'ksas-flagship' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'videoid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'videoid' ) ); ?>" type="text" value="<?php echo esc_attr( $videoid ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php esc_html_e( 'Description:', 'ksas-flagship' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>" rows="5"><?php echo esc_html( $textarea ); ?></textarea>
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
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link']     = ( ! empty( $new_instance['link'] ) ) ? esc_url_raw( $new_instance['link'] ) : '';
		$instance['videoid']  = ( ! empty( $new_instance['videoid'] ) ) ? sanitize_text_field( $new_instance['videoid'] ) : '';
		$instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? sanitize_text_field( $new_instance['textarea'] ) : '';
		return $instance;
	}
}