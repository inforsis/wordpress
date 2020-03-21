<?php
/**
 * Admin functions WP Newsletter Register plugin
 **/

function wp_newsletter_output() {
	 if ($_GET['page'] == 'wp-newsletter-register') {
	 	include (WP_NEWSLETTER_REGISTER_DIR.'/template/listing.php');
	 }
}

?>