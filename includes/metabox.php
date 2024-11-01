<?php

defined( 'ABSPATH' )
	or die( 'No direct load ! ' );

//Meta Box pour afficher ou non les réseaux sociaux par article
add_action('admin_menu','wpmysocial_init_metaboxes');
function wpmysocial_init_metaboxes(){
    //on utilise la fonction add_metabox() pour initialiser une metabox
    add_meta_box('wpmysocial_active', __('Display the sharing buttons', 'wp-my-social-networks'), 'wpmysocial_meta_function', 'post', 'normal', 'high');
    add_meta_box('wpmysocial_active', __('Display the sharing buttons', 'wp-my-social-networks'), 'wpmysocial_meta_function', 'page', 'normal', 'high');
}

// build meta box, and get meta
function wpmysocial_meta_function($post){
    global $post;
    // on récupère la valeur actuelle pour la mettre dans le champ
    $valActive = get_post_meta($post->ID,'wpmysocial_active',true);
    echo '<label for="wpmysocial_active"><p>'.__('Choose whether or not to display buttons for social networks:', 'wp-my-social-networks').'</label></p>';
    echo __('Yes', 'wp-my-social-networks').'&nbsp;<input id="wpmysocial_active" type="radio" name="wpmysocial_active" value="true" ';
    if($valActive == 'true' or $valActive == '') { echo 'checked'; } 
    echo ' />&nbsp;';
    echo __('No', 'wp-my-social-networks').'&nbsp;<input id="wpmysocial_active" type="radio" name="wpmysocial_active" value="false" ';
    if($valActive == 'false') { echo 'checked'; } 
    echo ' />&nbsp;';
}

// save meta box with update
add_action('save_post','wpmysocial_save_metaboxes');
function wpmysocial_save_metaboxes($post_ID){
    // si la metabox est définie, on sauvegarde sa valeur
    if(isset($_POST['wpmysocial_active'])){
        update_post_meta($post_ID,'wpmysocial_active', esc_html($_POST['wpmysocial_active']));
    }
}