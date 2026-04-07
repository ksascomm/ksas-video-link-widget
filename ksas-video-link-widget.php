<?php
/**
 * KSAS External Video Link Widget
 *
 * @package   KSAS_VIDEO_LINK
 * @author    KSAS Communications <ksasweb@jhu.edu>
 * @license   GPL-2.0+
 * @link      https://krieger.jhu.edu
 * @copyright 2022-2026 KSAS Communications
 * @version   3.0
 *
 * @wordpress-plugin
 * Plugin Name: KSAS External Video Link Widget
 * Plugin URI: https://github.com/ksascomm
 * Description: Link to your video on YouTube. Grabs thumb from API. Opens video in new window.
 * Version: 3.0
 * Author: KSAS Communications
 * Author URI: https://krieger.jhu.edu
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the Widget.
 *
 * Includes the class file and registers it within the widgets_init hook.
 */
function ksas_register_video_link_widget() {
	$class_file = plugin_dir_path( __FILE__ ) . 'class-ksas-video-link-widget.php';

	if ( file_exists( $class_file ) ) {
		require_once $class_file;
		register_widget( 'KSAS_Video_Link_Widget' );
	}
}
add_action( 'widgets_init', 'ksas_register_video_link_widget' );

/**
 * Optional: Enqueue CSS for the play button and thumbnail styling.
 *
 * Only enqueues if the widget is active.
 */
function ksas_video_widget_styles() {
	if ( is_active_widget( false, false, 'ksas_video_link_widget', true ) ) {
		// Assuming you have a style.css in your plugin root.
		wp_enqueue_style( 'ksas-video-widget-css', plugins_url( 'style.css', __FILE__ ), array(), '3.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'ksas_video_widget_styles' );
