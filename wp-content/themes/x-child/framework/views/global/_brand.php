<?php

// =============================================================================
// VIEWS/GLOBAL/_BRAND.PHP
// -----------------------------------------------------------------------------
// Outputs the brand.
// =============================================================================

$site_name        = get_bloginfo( 'name' );
$site_description = get_bloginfo( 'description' );
$logo             = x_make_protocol_relative( x_get_option( 'x_logo' ) );
$site_logo        = '<img src="' . $logo . '" alt="' . $site_description . '">';

?>

<?php echo ( is_front_page() ) ? '<h1 class="visually-hidden">' . $site_name . '</h1>' : ''; ?>

<a href="<?php echo home_url( '/' ); ?>" class="<?php x_brand_class(); ?> x-column x-1-3" title="<?php echo $site_description; ?>">
	<svg class="logo-icon Icon">
		<use xlink:href="#icon-logo"></use>
	</svg>
</a>