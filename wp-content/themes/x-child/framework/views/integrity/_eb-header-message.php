<?php

// =============================================================================
// VIEWS/INTEGRITY/_EB-HEADER-MESSAGE.PHP
// -----------------------------------------------------------------------------
// Handles custom EB header message which appears above all other headers at top of page, set using Advanced Custom Fields options page
// =============================================================================
?>

<?php
if ( get_field('header_message', 'option') != FALSE ) : ?>
	<div class="x-section header-message">
		<div class="x-container max width">
			<p><?php the_field('header_message', 'option'); ?></p>
		</div>
	</div>

<?php endif; ?>