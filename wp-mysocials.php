<?php
/*
Plugin Name: WP My Social Networks
Plugin URI:  http://wordpress.org/plugins/wp-my-social-networks
Description: Add the social networks in your pages / posts.
Version:     2.0.1
Author:      Florent Maillefaud
Author URI:  https://restezconnectes.fr
License:     GPL3 or later
Domain Path: /languages
Text Domain: wp-my-social-networks
*/

/*  Copyright 2007-2015 Florent Maillefaud (email: contact at restezconnectes.fr)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

defined( 'ABSPATH' )
	or die( 'No direct load ! ' );

define( 'WPMYSN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPMYSN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPMYSN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPMYSN_LANGUAGE', get_bloginfo('language') );

if( !defined( 'WPMYSN_VERSION' )) { define( 'WPMYSN_VERSION', '2.0' ); }

require WPMYSN_DIR . 'classes/wp-mysocials.php';
require WPMYSN_DIR . 'includes/metabox.php';

add_action( 'plugins_loaded', '_mysn_sendpdf_load' );
function _mysn_sendpdf_load() {
	$mysn_sendpdf = new wp_mysocial();
	$mysn_sendpdf->hooks();
}

// Enable localization
add_action( 'init', '_mysn_load_translation' );
function _mysn_load_translation() {
    load_plugin_textdomain( 'wp-my-social-networks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}