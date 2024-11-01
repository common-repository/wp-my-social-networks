<?php

defined( 'ABSPATH' ) or die( 'Not allowed' );

/* Update si changements */
if( isset($_POST['action']) && $_POST['action'] == 'update') {
    
    update_option('wpmysocial_plugin_settings', $_POST["wpmysocial_plugin_settings"]);
    if( isset($_POST["wpmysocial_plugin_style"]) ) { 
        update_option('wpmysocial_plugin_style', $_POST["wpmysocial_plugin_style"]);
    }
    if( isset($_POST["wpmysocial_excludeid"]) ) { 
        update_option('wpmysocial_excludeid', $_POST["wpmysocial_excludeid"]); 
    }
    if( isset($_POST["wpmysocial_excludecat"]) ) { 
        update_option('wpmysocial_excludecat', $_POST["wpmysocial_excludecat"]); 
    }
    if( isset($_POST["wpmysocial_excludemeta"]) ) { 
        update_option('wpmysocial_excludemeta', $_POST["wpmysocial_excludemeta"]); 
    }
    if( isset($_POST["wpmysocial_belowpost"]) ) { 
        update_option('wpmysocial_belowpost', $_POST["wpmysocial_belowpost"]); 
    }
    if( isset($_POST["wpmysocial_abovepost"]) ) { 
        update_option('wpmysocial_abovepost', $_POST["wpmysocial_abovepost"]); 
    }
    $options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.', 'wp-my-social-networks').'</strong></p></div>';
}
// Récupère les paramètres sauvegardés
if(get_option('wpmysocial_plugin_settings')) { extract(get_option('wpmysocial_plugin_settings')); }
$options = get_option('wpmysocial_plugin_settings');

/* Si on réinitialise les feuille de styles  */
if( isset($_POST['wpmysocial_initcss']) && $_POST['wpmysocial_initcss']==1) {
    update_option( 'wpmysocial_plugin_style', wpsocials_print_style() );
    $options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>'.__('The Style Sheet has been reset!', 'wp-my-social-networks').'</strong></p></div>';
}
if( get_option('wpmysocial_plugin_style')=='' ) {
    update_option( 'wpmysocial_plugin_style', wpsocials_print_style() );
}

?>
<style type="text/css">.postbox h3 { cursor:pointer; }</style>
<div class="wrap">
    
    <h2 style="font-size: 23px;font-weight: 400;padding: 9px 15px 4px 0px;line-height: 29px;">
        <?php echo __('My Socials Networks Settings', 'wp-my-social-networks'); ?>
    </h2>
    
     <!-- TABS OPTIONS -->
    <div id="icon-options-general" class="icon32"><br></div>
    <h2 class="nav-tab-wrapper">
        <a id="wpmysocial-menu-a" class="nav-tab nav-tab-active" href="#a" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>images/facebook.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('Facebook', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-b" class="nav-tab" href="#b" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/twitter.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('Twitter', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-c" class="nav-tab" href="#c" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/google.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('Google+', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-d" class="nav-tab" href="#d" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/linkedin.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('LinkedIn', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-g" class="nav-tab" href="#g" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/css.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('CSS Style', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-f" class="nav-tab" href="#f" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/hand-down.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('Options', 'wp-my-social-networks'); ?></a>
        <a id="wpmysocial-menu-about" class="nav-tab" href="#about" onfocus="this.blur();"><img src="<?php echo WPMYSN_URL; ?>/images/circle.png" style="vertical-align:text-bottom;margin-right:3px;" height="20" width="20" /><?php _e('About', 'wp-my-social-networks'); ?></a>
    </h2>
    
    <div style="margin-left:25px;margin-top: 15px;">
        
        <form method="post" action="" name="valide_wpmysocial">
            <input type="hidden" name="action" value="update" />
            
                <!-- ONGLET A -->
                <div class="wpmysocial-menu-a wpmysocial-menu-group">
                    <div id="wpmysocial-opt-a">
                         <ul>
                            <!-- FACEBOOK -->
                            <li>
                                <h3><?php _e('Facebook Like button', 'wp-my-social-networks'); ?></h3>
                            </li>
                            <!--  -->
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_like_btn]" value="1" <?php if( isset($options['fb_like_btn']) && $options['fb_like_btn']==1 ) { echo "checked"; } ?> />  <?php _e('Display the Facebook Like button', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_share_btn]" value="1" <?php if( isset($options['fb_share_btn']) && $options['fb_share_btn']==1) { echo "checked"; } ?> />  <?php _e('Display the Facebook Share button', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li>
                                <label><select name="wpmysocial_plugin_settings[fb_type_btnlike]">
                                        <option value="standard" <?php if( (isset($options['fb_type_btnlike']) && $options['fb_type_btnlike']=="standard") OR empty($options['fb_type_btnlike']) ) { echo "selected"; } ?>>Standard</option>
                                        <option value="button_count" <?php if( isset($options['fb_type_btnlike']) && $options['fb_type_btnlike']=="button_count") { echo "selected"; } ?>>Button Count</option>
                                        <option value="box_count" <?php if( isset($options['fb_type_btnlike']) && $options['fb_type_btnlike']=="box_count") { echo "selected"; } ?>>Box Count</option>
                                        <option value="button" <?php if( isset($options['fb_type_btnlike']) && $options['fb_type_btnlike']=="button") { echo "selected"; } ?>>Button</option>
                                        </select>  <?php _e('Select the type', 'wp-my-social-networks'); ?>
                                </label><br />
                                <label><select name="wpmysocial_plugin_settings[fb_size_btn]">
                                        <option value="small" <?php if( (isset($options['fb_size_btn']) && $options['fb_size_btn']=="small") OR empty($options['fb_size_btn']) ) { echo "selected"; } ?>>Small</option>
                                        <option value="large" <?php if( isset($options['fb_size_btn']) && $options['fb_size_btn']=="large") { echo "selected"; } ?>>Large</option>
                                        </select>  <?php _e('Select the size', 'wp-my-social-networks'); ?>
                                </label>
            
                            </li>
                            <li><h3><?php _e('Position the Facebook Like', 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_settings_home]" value="1" <?php if( isset($options['fb_settings_home']) && $options['fb_settings_home']==1) { echo "checked"; } ?> />  <?php _e('On the main page', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_settings_single]" value="1" <?php if( isset($options['fb_settings_single']) && $options['fb_settings_single']==1) { echo "checked"; } ?> />  <?php _e('On the posts', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_settings_category]" value="1" <?php if( isset($options['fb_settings_category']) && $options['fb_settings_category']==1) { echo "checked"; } ?> />  <?php _e('On the categories', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[fb_settings_page]" value="1" <?php if( isset($options['fb_settings_page']) && $options['fb_settings_page']==1) { echo "checked"; } ?> />  <?php _e('On the pages', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#a" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin options 1 -->
                
                <!--  Onglets B -->
                <div class="wpmysocial-menu-b wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-b"  >
                         <ul>
                            <!--  -->
                            <li>
                                <h3><?php _e('Twitter button', 'wp-my-social-networks'); ?></h3>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[twitter_btn]" value="1" <?php if( isset($options['twitter_btn']) && $options['twitter_btn']==1) { echo "checked"; } ?> />  <?php _e('Display re-twitt button', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li>
                                <label>
                                    Via : <input type="text" width="150" name="wpmysocial_plugin_settings[twitter_account]" value="<?php if( isset($options['twitter_account']) ) { echo $options['twitter_account']; } ?>"/> (<?php _e('This user will be refered in the tweet', 'wp-my-social-networks'); ?>)
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[twitter_settings_home]" value="1" <?php if( isset($options['twitter_settings_home']) && $options['twitter_settings_home']==1) { echo "checked"; } ?> />  <?php _e('On the main page', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[twitter_settings_single]" value="1" <?php if( isset($options['twitter_settings_single']) && $options['twitter_settings_single']==1) { echo "checked"; } ?> />  <?php _e('On the posts', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[twitter_settings_category]" value="1" <?php if( isset($options['twitter_settings_category']) && $options['twitter_settings_category']==1) { echo "checked"; } ?> />  <?php _e('On the categories', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[twitter_settings_page]" value="1" <?php if( isset($options['twitter_settings_page']) && $options['twitter_settings_page']==1) { echo "checked"; } ?> />  <?php _e('On the pages', 'wp-my-social-networks'); ?>
                                </label></li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#b" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin B -->
                
                <!--  Onglets C -->
                <div class="wpmysocial-menu-c wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-c"  >
                         <ul>
                            
                            <!-- BOUTON SHARE GOOGLE+1 -->
                            <li><h3><?php _e('Google+ Share Button', 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[shareplusone_btn]" value="1" <?php if( isset($options['shareplusone_btn']) && $options['shareplusone_btn']==1) { echo "checked"; } ?> />  <?php _e('Display the Share Google+ Button', 'wp-my-social-networks'); ?>
                                </label><br />
                                <label><select name="wpmysocial_plugin_settings[shareplusone_annotation]">
                                        <option value="none" <?php if( isset($options['shareplusone_annotation']) && $options['shareplusone_annotation']=="none") { echo "selected"; } ?>><?php _e('None', 'wp-my-social-networks'); ?></option>
                                        <option value="vertical-bubble" <?php if( isset($options['shareplusone_annotation']) && $options['shareplusone_annotation']=="vertical-bubble") { echo "selected"; } ?>><?php _e('Vertical bubble', 'wp-my-social-networks'); ?></option>
                                        <option value="bubble" <?php if( isset($options['shareplusone_annotation']) && $options['shareplusone_annotation']=="bubble") { echo "selected"; } ?>><?php _e('Bubble', 'wp-my-social-networks'); ?></option>
                                        <option value="inline" <?php if( isset($options['shareplusone_annotation']) && $options['shareplusone_annotation']=="inline") { echo "selected"; } ?>><?php _e('Inline', 'wp-my-social-networks'); ?></option>
                                        </select>  <?php _e('Select the annotation', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li>
                                <label><select name="wpmysocial_plugin_settings[shareplusone_type_btn]">
                                        <option value="small" <?php if( isset($options['shareplusone_type_btn']) && $options['shareplusone_type_btn']=="small") { echo "selected"; } ?>><?php _e('Small', 'wp-my-social-networks'); ?></option>
                                        <option value="medium" <?php if( isset($options['shareplusone_type_btn']) && $options['shareplusone_type_btn']=="medium") { echo "selected"; } ?>><?php _e('Medium', 'wp-my-social-networks'); ?></option>
                                        <option value="large" <?php if( isset($options['shareplusone_type_btn']) && $options['shareplusone_type_btn']=="bubble") { echo "selected"; } ?>><?php _e('Large', 'wp-my-social-networks'); ?></option>
                                        </select>  <?php _e('Select the type', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li><h3><?php _e('Position the Google+ Share Button', 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[shareplusone_settings_home]" value="1" <?php if( isset($options['shareplusone_settings_home']) && $options['shareplusone_settings_home']==1) { echo "checked"; } ?> />  <?php _e('On the main page', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[shareplusone_settings_single]" value="1" <?php if( isset($options['shareplusone_settings_single']) && $options['shareplusone_settings_single']==1) { echo "checked"; } ?> />  <?php _e('On the posts', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[shareplusone_settings_category]" value="1" <?php if( isset($options['shareplusone_settings_category']) && $options['shareplusone_settings_category']==1) { echo "checked"; } ?> />  <?php _e('On the categories', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[shareplusone_settings_page]" value="1" <?php if( isset($options['shareplusone_settings_page']) && $options['shareplusone_settings_page']==1) { echo "checked"; } ?> />  <?php _e('On the pages', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#c" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin C -->
                
                 <!--  Onglets D -->
                <div class="wpmysocial-menu-d wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-d"  >
                         <ul>
                            <!-- BOUTON LINKEDIN -->
                            <li><h3><?php _e('LinkedIn button', 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[linkedin_btn]" value="1" <?php if( isset($options['linkedin_btn']) && $options['linkedin_btn']==1) { echo "checked"; } ?> />  <?php _e('Display the LinkedIn button', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li>
                                <label><select name="wpmysocial_plugin_settings[linkedin_type_btn]">
                                        <option value="top" <?php if( isset($options['linkedin_type_btn']) && $options['linkedin_type_btn']=="top") { echo "selected"; } ?>><?php _e('Top', 'wp-my-social-networks'); ?></option>
                                        <option value="right" <?php if( isset($options['linkedin_type_btn']) && $options['linkedin_type_btn']=="right") { echo "selected"; } ?>><?php _e('Right', 'wp-my-social-networks'); ?></option>
                                        <option value="none" <?php if( isset($options['linkedin_type_btn']) && $options['linkedin_type_btn']=="none") { echo "selected"; } ?>><?php _e('None', 'wp-my-social-networks'); ?></option>
                                        </select>  <?php _e('Select the type', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li><h3><?php _e('Position the LinkedIn button', 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[linkedin_settings_home]" value="1" <?php if( isset($options['linkedin_settings_home']) && $options['linkedin_settings_home']==1) { echo "checked"; } ?> />  <?php _e('On the main page', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[linkedin_settings_single]" value="1" <?php if( isset($options['linkedin_settings_single']) && $options['linkedin_settings_single']==1) { echo "checked"; } ?> />  <?php _e('On the posts', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[linkedin_settings_category]" value="1" <?php if( isset($options['linkedin_settings_category']) && $options['linkedin_settings_category']==1) { echo "checked"; } ?> />  <?php _e('On the categories', 'wp-my-social-networks'); ?>
                                </label> 
                                <label>
                                    <input type="checkbox" name="wpmysocial_plugin_settings[linkedin_settings_page]" value="1" <?php if( isset($options['linkedin_settings_page']) && $options['linkedin_settings_page']==1) { echo "checked"; } ?> />  <?php _e('On the pages', 'wp-my-social-networks'); ?>
                                </label>
                            </li>
                            <li> &nbsp;</li>
                            <li>
                                <a href="#d" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin D -->

                <!-- Onglet options 5 -->
                <div class="wpmysocial-menu-g wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-g"  >
                         <ul>
                            <!-- UTILISER UNE FEUILLE DE STYLE PERSO -->
                            <li>
                                <h3><?php _e('CSS style sheet code:', 'wp-my-social-networks'); ?></h3>
                                <?php _e('Edit the CSS sheet here. Click "Reset" and "Save" to retrieve the default style sheet.', 'wp-my-social-networks'); ?><br />
                                <TEXTAREA NAME="wpmysocial_plugin_style" COLS=40 ROWS=14 style="width:100%;"><?php echo stripslashes(trim(get_option('wpmysocial_plugin_style'))); ?></TEXTAREA>
                            </li>
                            <li>
                                <input type= "checkbox" name="wpmysocial_initcss" value="1" id="initcss" >&nbsp;<label for="wpmysocial_initcss"><?php _e('Reset default CSS stylesheet ?', 'wp-my-social-networks'); ?></label>
                             </li>
                            <li>&nbsp;</li>

                            <li>
                                <a href="#g" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin options G -->

                <!--  Onglets F -->
                <div class="wpmysocial-menu-f wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-f"  >
                         <ul>
                            <!--  -->
                            <li><h3><?php _e("Don't display on Posts/Pages", 'wp-my-social-networks'); ?></h3><li>
                            <li>
                                <p><?php _e("Enter the <b>ID's</b> of those Pages/Posts separated by comma. e.g 13,5,87<br/>You can also include a <b>custom post types</b> or <b>custom post format</b> (all separated by comma)", 'wp-my-social-networks'); ?><br /><input type="text" name="wpmysocial_excludeid" style="width: 300px;" value="<?php echo get_option('wpmysocial_excludeid',''); ?>" /></p>
                            </li>

                            <li><h3><?php _e("Don't display on Category", 'wp-my-social-networks'); ?></h3></li>
                            <li>
                                <p><?php _e("Enter the ID's of those Categories separated by comma. e.g 131,45,817", 'wp-my-social-networks'); ?><br/>
                                <input type="text" name="wpmysocial_excludecat" style="width: 300px;" value="<?php echo get_option('wpmysocial_excludecat',''); ?>" /></p>
                            </li>

                            <li>
                                <h3><?php _e('Where to Display', 'wp-my-social-networks'); ?></h3>
                                    <input type="checkbox" name="wpmysocial_abovepost" id="wpmysocial_abovepost" value="true"<?php if (get_option( 'wpmysocial_abovepost', false ) == true) echo ' checked'; ?>> <?php _e('Display Above Content', 'wp-my-social-networks'); ?><br />
                                    <input type="checkbox" name="wpmysocial_belowpost" id="wpmysocial_belowpost" value="true"<?php if (get_option( 'wpmysocial_belowpost', false ) == true) echo ' checked'; ?>> <?php _e('Display Below Content', 'wp-my-social-networks'); ?>
                            </li>
                            <li><h3><?php _e('If some other plugin is adding the Facebook Meta tags', 'wp-my-social-networks'); ?></h3>
                               <input type="checkbox" name="wpmysocial_excludemeta" id="wpmysocial_excludemeta" value="true"<?php if (get_option( 'wpmysocial_excludemeta', false ) == true) echo ' checked'; ?>> <?php _e('Do not add Facebook OG META tags', 'wp-my-social-networks'); ?>
                            </li>
                            <li><h3><?php _e('Add a margin?', 'wp-my-social-networks'); ?></h3>
                                <label>
                                    <?php _e('Top margin:', 'wp-my-social-networks'); ?> <input type="text" width="2" size="5" name="wpmysocial_plugin_settings[margin_top]" value="<?php if( isset($options['margin_top']) ) { echo $options['margin_top']; } ?>" />px
                                </label>
                            </li>
                            <li>
                                <label>
                                    <?php _e('Bottom margin:', 'wp-my-social-networks'); ?> <input type="text" width="2" size="5" name="wpmysocial_plugin_settings[margin_bottom]" value="<?php if( isset($options['margin_bottom']) ) { echo $options['margin_bottom']; } ?>" />px
                                </label></li>
                            <li> &nbsp;</li>

                            <li>
                                <a href="#f" id="submitbutton" OnClick="document.forms['valide_wpmysocial'].submit();this.blur();" name="Save" class="button-primary"><span> <?php _e('Save this settings', 'wp-my-social-networks'); ?> </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- fin F -->
                
                </form>
        
                <!-- Onglet options 7 -->
                <div class="wpmysocial-menu-about wpmysocial-menu-group" style="display: none;">
                    <div id="wpmysocial-opt-about">
                         <ul>
                            <li>
                                <?php _e('This plugin has been developed for you for free by <a href="https://restezconnectes.fr" target="_blank">Florent Maillefaud</a>. It is royalty free, you can take it, modify it, distribute it as you see fit. <br /><br />It would be desirable that I can get feedback on your potential changes to improve this plugin for all.', 'wp-my-social-networks'); ?>
                            </li>
                            <li> &nbsp;</li>
                            <li>
                                <!-- FAIRE UN DON SUR PAYPAL -->
                            <div><?php _e('If you want Donate (French Paypal) for my current and future developments:', 'wp-my-social-networks'); ?><br /><br />
                                <div style="width:350px;margin-left:auto;margin-right:auto;padding:5px;">
                                    <a href="https://paypal.me/RestezConnectes/10" target="_blank" class="wpmclassname">
                                        <img src="<?php echo WP_PLUGIN_URL.'/wp-my-social-networks/images/donate.png'; ?>" valign="bottom" width="64" /> Donate now!
                                    </a>
                                </div>
                            </div>
                            <!-- FIN FAIRE UN DON -->
                            </li>
                            <li> &nbsp;</li>
                        </ul>
                    </div>
                </div>
                <!-- fin options 7 -->

     </div><!-- -->
    
</div><!-- wrap -->