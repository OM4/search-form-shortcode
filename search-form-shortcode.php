<?php
/*
Plugin Name: Search Form Shortcode
Plugin URI: http://om4.com.au/wordpress-plugins/
Description: Display a WordPress search box/form using a simple shortcode: [search-form buttonimage="" buttontext="" fieldtext=""]
Version: 1.0.1
Author: OM4
Author URI: https://om4.com.au/
Git URI: https://github.com/OM4/search-form-shortcode
Git Branch: release
License: GPLv2
*/

/*

   Copyright 2012-2016 OM4 (email: info@om4.com.au    web: https://om4.com.au/)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Handler for the [search-form] shortcode.
 * Display a search form that can be embedded in a post or page
 *
 * @param Array  $atts
 * @param string $content
 *
 * @return string
 */
function om4_search_form_shortcode( $atts, $content = null ) {

	$defaults = array(
			'buttonimage'  => ''
			, 'buttontext' => ''
			, 'fieldtext'  => ''
	);

	$atts = shortcode_atts( $defaults, $atts );
	extract( $atts, EXTR_SKIP );

	ob_start();
	get_search_form();
	$content = ob_get_contents();
	ob_end_clean();

	if ( ! empty($buttonimage) ) {
		// Convert the button to an image submit button
		$content = str_replace( 'type="submit"', 'type="image" alt="Search" src="' . esc_url( $buttonimage ) . '"', $content );
		// Remove the value="" attribute because <input type="text">  isn't allowed a value
		$content    = str_replace( 'value="Search"', '', $content );
		$buttontext = '';
	}

	if ( ! empty($buttontext) ) {
		$content = str_replace( 'value="Search"', 'value="' . $buttontext . '"', $content );
	}

	if ( ! empty($fieldtext) ) {
		$content = str_replace( 'value=""', 'value="' . $fieldtext . '" onFocus="if(this.value==\'' . $fieldtext . '\') this.value=\'\';" ', $content );
	}

	return '<div class="inline-search">' . $content . '</div>';
}
add_shortcode( 'search-form', 'om4_search_form_shortcode' );
