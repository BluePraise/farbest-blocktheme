<?php
/**
 * Title: Hero
 * Slug: farbest/hero
 * Categories: featured, banner
 * Description: Full-width hero with heading, subtitle, and CTA button on a teal background.
 */
?>
<!-- wp:cover {"align":"full","minHeight":560,"minHeightUnit":"px","style":{"color":{"background":"var:preset|color|teal"}},"isDark":true} -->
<div class="wp-block-cover alignfull is-dark" style="min-height:560px;background-color:var(--wp--preset--color--teal)">
	<div class="wp-block-cover__inner-container">

		<!-- wp:group {"align":"wide","layout":{"type":"flex","orientation":"vertical","crossAxis":"flex-start"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
		<div class="wp-block-group alignwide">

			<!-- wp:heading {"level":1,"style":{"color":{"text":"var:preset|color|white"},"typography":{"fontSize":"var:preset|font-size|xxx-large","fontWeight":"700"}}} -->
			<h1 class="wp-block-heading has-white-color has-text-color" style="font-size:var(--wp--preset--font-size--xxx-large);font-weight:700">Quality ingredients.<br>Trusted expertise.</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|beige-dark"},"typography":{"fontSize":"var:preset|font-size|x-large","fontWeight":"300"}}} -->
			<p class="has-beige-dark-color has-text-color" style="font-size:var(--wp--preset--font-size--x-large);font-weight:300">Supplying the food and beverage industry with premium functional ingredients.</p>
			<!-- /wp:paragraph -->

			<!-- wp:pattern {"slug":"farbest/cta-button"} /-->

		</div>
		<!-- /wp:group -->

	</div>
</div>
<!-- /wp:cover -->
