<?php

function cosmos_prefetch_prerender() {

	global $wp_query, $paged;

	if ( ( is_home() || is_archive() || is_category() || is_tax() || is_tag() ) && ( $paged < $wp_query->max_num_pages ) ) {

		echo "<link rel=\"prefetch\" href=\"" . get_next_posts_page_link() . "\" />\n";
		echo "<link rel=\"prerender\" href=\"" . get_next_posts_page_link() . "\" />\n";
	}
}
add_action('wp_head', 'cosmos_prefetch_prerender', 5, 0);

// Google Analytics Tracking Code
// https://developers.google.com/analytics/devguides/collection/gajs/
function cosmos_google_analytics() {

	//$options = get_option('ga_options');

	//if ($options['ga_enable']) {

?>
<script>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-28533366-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php
	//}
}
add_action('wp_footer', 'cosmos_google_analytics', 20, 0);
