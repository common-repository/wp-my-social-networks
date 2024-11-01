<?php

class wp_mysocial {
    
	public function hooks() {
     
        /* Version du plugin */
        $option['wpmysocial_version'] = WPMYSN_VERSION;
        if( !get_option('wpmysocial_version') ) {
            add_option('wpmysocial_version', $option);
        } else if ( get_option('wpmysocial_version') != WPMYSN_VERSION ) {
            update_option('wpmysocial_version', WPMYSN_VERSION);
        }
        // Maybe disable AJAX requests
        add_filter( 'plugin_action_links', array( $this, 'wpmysn_plugin_actions'), 10, 2 );
        add_action('admin_head', array( $this, 'wpmysn_admin_head') );
        add_action("admin_menu", array( $this, "wpmysn_add_admin") );
        add_action('wp_head', array( $this, 'wpmysn_plusOneOptions'), 1 );
        add_action('wp_head', array( $this, 'wpmysn_css' ), 1 );
        add_action('wp_head', array( $this, 'wpmysn_add_meta' ), 1 );
                   
        add_filter('the_content', array( $this, 'wpmysn_add_social_content'), 10, 1);
        add_filter('the_excerpt', array( $this, 'wpmysn_add_social_content'), 10, 2);
    
        register_deactivation_hook(__FILE__, 'wpmysn_uninstall');

    }
    
    // Add "Réglages" link on plugins page
    function wpmysn_plugin_actions( $links, $file ) {
        
        if ( $file != WPMYSN_PLUGIN_BASENAME ) {
		  return $links;
        } else {
            $wpm_settings_link = '<a href="admin.php?page=wp-my-social-networks">'
                . esc_html( __( 'Settings', 'wp-my-social-networks' ) ) . '</a>';

            array_unshift( $links, $wpm_settings_link );

            return $links;
        }
    }
    
    function wpmysn_dashboard_html_page() {
        include(WPMYSN_DIR."/views/wp-mysocials-admin.php");
    }
    
    function wpmysn_add_admin() {
        
        add_options_page(
			__( 'Display social networks options', 'wp-my-social-networks' ),
			__('Social Networks', 'wp-my-social-networks' ),
			'manage_options',
			'wp-my-social-networks',
			array(
				$this,
				'wpmysn_dashboard_html_page'
			)
		);
    
        // Valeurs par défaut
        if( !get_option('wpmysocial_plugin_settings') ) { 
            $wpmysocials_AdminOptions = array(  
                'fb_like_btn' => 1,
                'fb_send_btn' => 1,
                'fb_faces_btn' => 1,
                'fb_type_btnlike' => 'button_count',
                'fb_settings_single' => 1,
                'fb_settings_page' => 1,
                'fb_share_btn' => '',
                'fb_share_settings_single' => 1,
                'twitter_btn' => 1,
                'twitter_settings_single' => 1,
                'twitter_settings_page' => 1,
                'twitter_type_btn '=> 'horizontal',
                'plusone_settings_single' => 1,
                'plusone_settings_page' => 1,
                'plusone_btn' => 1,
                'plusone_type_btn' => 'medium',
                'margin_top' => 20,
                'margin_bottom' => 0,
                'wpmysocial_belowpost' => 1
            );  
            $wpmysocials_Settings = get_option('wpmysocial_plugin_settings');  
            if (!empty($wpmysocials_Settings)) {  
                foreach ($wpmysocials_Settings as $key => $option) {
                    $wpmysocials_AdminOptions[$key] = $option;
                }
            }
            update_option('wpmysocial_plugin_settings', $wpmysocials_AdminOptions);

            if(!get_option('wpmysocial_plugin_style') or get_option('wpmysocial_plugin_style')=='') { 
                update_option( 'wpmysocial_plugin_style', $this->wpmysn_print_style() );
            }
        }
        
        // If you're not including an image upload then you can leave this function call out    
        if (isset($_GET['page']) && $_GET['page'] == 'wp-my-social-networks') {
            
            wp_register_script('wpm-admin-settings', plugins_url('../js/mysocials-admin.js', __FILE__ ) );
            wp_enqueue_script('wpm-admin-settings');
            
        }
    
    }
    
    /* Ajout feuille CSS pour l'admin barre */
    function wpmysn_admin_head() {
        echo '<link rel="stylesheet" type="text/css" media="all" href="' .plugins_url('../css/mysocials-admin.css', __FILE__). '">';
    }
    
    function wpmysn_afficheReseauxSociaux() {

        global $post;
        
        if(get_option('wpmysocial_plugin_settings')) { extract(get_option('wpmysocial_plugin_settings')); }
        $options = get_option('wpmysocial_plugin_settings');
 
        $mysnReseau = array('fb', 'fb_faces', 'plusone', 'shareplusone', 'twitter', 'linkedin', 'linkedin' );
        $position = array();
        $content = '';
        
        if( is_single() ) {
            
            foreach($mysnReseau as $reseau) {
                if( isset($options[$reseau.'_settings_single']) ) { 
                    $reseau = $options[$reseau.'_settings_single']; 
                } else { 
                    $reseau = ''; 
                }
                array_push($position, $reseau);
            }
            $positionReseaux = array_combine($mysnReseau, $position );

        } else if( is_page() ) {
            
            foreach($mysnReseau as $reseau) {
                if( isset($options[$reseau.'_settings_page']) ) { 
                    $reseau = $options[$reseau.'_settings_page']; 
                } else { 
                    $reseau = ''; 
                }
                array_push($position, $reseau);
            }
            $positionReseaux = array_combine($mysnReseau, $position );

        } else if( is_home() ) {
            
            foreach($mysnReseau as $reseau) {
                if( isset($options[$reseau.'_settings_home']) ) { 
                    $reseau = $options[$reseau.'_settings_home']; 
                } else { 
                    $reseau = ''; 
                }
                array_push($position, $reseau);
            }
            $positionReseaux = array_combine($mysnReseau, $position );
           
        } else {
            
            $positionReseaux = array(
                'fb' => $options['fb_settings_category'],
                'fb_share' => $options['fb_share_settings_category'],
                'fb_faces' => $options['fb_faces_settings_category'],
                'plusone' => $options['plusone_settings_category'],
                'shareplusone' => $options['shareplusone_settings_category'],
                'twitter' => $options['twitter_settings_category'],
                'linkedin' => $options['linkedin_settings_category']
            );

        }

        if($options['fb_settings_single']==1 or $options['fb_share_settings_single']==1 or $options['plusone_settings_single']==1 or $options['twitter_settings_single']==1 or $options['linkedin_settings_single']==1) {
            $linkPermaLink = get_permalink($post->ID);
        } else {
            $linkPermaLink = the_permalink();
        }

        /* div général */
        $content .= '<div id="wp-socials" style="margin-top:'.$margin_top.'px;margin-bottom:'.$margin_bottom.'px;">';

            /* div pour les boutons des réseaux sociaux */
            $content .= '<div id="wp-socials-general-btn">';
            //$plusoneSizeHeight = '';
            if( isset($options['shareplusone_type_btn']) ) { 
                $plusoneSize = $options['shareplusone_type_btn']; 
            } else { 
                $plusoneSize = 'tall';
            }
            if( isset($options['shareplusone_annotation']) ) {
                $plusoneAnnotation = $options['shareplusone_annotation']; 
            } else { 
                $plusoneAnnotation = 'none';
            }
                
            /* Bouton partager de Google */
            if( isset($options['shareplusone_btn']) && $options['shareplusone_btn']==1 && isset($positionReseaux['shareplusone']) && $positionReseaux['shareplusone']==1) {
                $content .= '<div id="wp-socials-plusone">';
                $content .= '
                <!-- Place this tag in your head or just before your close body tag. -->
                <script src="https://apis.google.com/js/platform.js" async defer>
                  {lang: \''.substr(WPMYSN_LANGUAGE, 0, 2).'\'}
                </script>

                <!-- Place this tag where you want the share button to render. -->
                <div class="g-plus" data-action="share" data-annotation="'.$plusoneAnnotation.'" data-height="58" data-size="'.$plusoneSize.'" data-href="'.$linkPermaLink.'"></div>';
                $content .= '</div>';
            }
            /* ------------ */

            /* Bouton FB Like */
            if( isset($options['fb_like_btn']) && $options['fb_like_btn']==1 && isset($positionReseaux['fb']) && $positionReseaux['fb']==1) {

                $fbLikeLayout = 'standard';
                $fbLikeShare = 'false';
                $fbLikeSize = 'small';
                if( isset($options['fb_share_btn']) && $options['fb_share_btn']==1 ) {
                   $fbLikeShare = "true";
                }
                if( isset($options['fb_type_btnlike']) ) {
                    $fbLikeLayout = $options['fb_type_btnlike'];
                }
                if( isset($options['fb_size_btn']) ) {
                    $fbLikeSize = $options['fb_size_btn'];
                }
                if( $fbLikeLayout == 'box_count' ) { 
                    if( $fbLikeSize == 'small' ) { 
                        $fbLikewidth="63"; $fbLikeheight="65";
                    } else {
                        $fbLikewidth="77"; $fbLikeheight="65"; 
                    }
                } else {
                    if( $fbLikeSize == 'small' ) { 
                        $fbLikewidth="450"; $fbLikeheight="35";
                    } else {
                        $fbLikewidth="450"; $fbLikeheight="80"; 
                    }
                }
                if( $fbLikeLayout == 'button' ) {
                    if( $fbLikeShare == "true" ) { 
                        $fbLikewidth="155"; $fbLikeheight="65";
                    } else { 
                        if( $fbLikeSize == 'small' ) { 
                            $fbLikewidth="65"; $fbLikeheight="65";
                        } else {
                            $fbLikewidth="85"; $fbLikeheight="65";
                        }
                    }
                }
                
                $content .= '<div id="wp-socials-fb-like">';
                $content .= '<iframe src="https://www.facebook.com/plugins/like.php?href='.$linkPermaLink.'%2F&width='.$fbLikewidth.'&layout='.$fbLikeLayout.'&action=like&size='.$fbLikeSize.'&show_faces=false&share='.$fbLikeShare.'&height='.$fbLikeheight.'" width="'.$fbLikewidth.'" height="'.$fbLikeheight.'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
                $content .= '</div>';

            }
            /* ------------ */


            /* Bouton ReTwitte */
            if( isset($options['twitter_btn']) && $options['twitter_btn']==1 && isset($positionReseaux['twitter']) && $positionReseaux['twitter']==1) {
                
                if( isset($options['twitter_account']) ) { 
                    $twitterVia = $options['twitter_account']; 
                } else { 
                    $twitterVia = '';
                }
                $content .= '<div id="wp-socials-twitter">';                
                $content .= '<iframe scrolling="no"
                  src="https://platform.twitter.com/widgets/tweet_button.html?size=l&url='.$linkPermaLink.'&via='.$twitterVia.'&text='.$post->post_title.'"
                  width="140"
                  height="28"
                  title="Twitter Tweet Button"
                  style="border: 0; overflow: hidden;">
                </iframe>';
                $content .= '</div>';
            }
            /* ------------ */

            /* Bouton ShareIn */
            if( isset($options['linkedin_btn']) && $options['linkedin_btn']==1 && isset($positionReseaux['linkedin']) && $positionReseaux['linkedin']==1) {
                
                $printLinkedin = 'none';
                if( isset($options['linkedin_type_btn']) ) { 
                    $printLinkedin = $options['linkedin_type_btn']; 
                }
                $content .= '<div id="wp-socials-linkedin">
                               <script src="//platform.linkedin.com/in.js" type="text/javascript">
                                lang: '.WPMYSN_LANGUAGE.'
                               </script>
                               <script type="IN/Share" data-url="'.$linkPermaLink.'" data-counter="'.$printLinkedin.'"></script>
                           </div>';
            }
            /* ------------ */

            $content .= '</div>';
            /* Fin div pour les boutons des réseaux sociaux */



        $content .= '<div style="clear:both"></div>';
        $content .= '</div>';
        /* fin div général */

        if(
            $positionReseaux['plusone']==1 or 
            $positionReseaux['shareplusone']==1 or 
            $positionReseaux['fb']==1 or 
            $positionReseaux['fb_share']==1 or 
            $positionReseaux['twitter']==1 or 
            $positionReseaux['linkedin']==1
        ) {
            return $content;
        }
    }
    
    function wpmysn_add_social_content($content) {

        global $single;
        global $post;
        global $page;

        $expostid = get_option('wpmysocial_excludeid','');
        $expostcat = get_option('wpmysocial_excludecat','');
        
        // N'affiche rien si on ne veut pas 
        $initActive = get_post_meta($post->ID, 'wpmysocial_active', true);        
        if( isset($initActive) && $initActive=='false') { 
            return  $content;
            exit();
        }
        
        if( get_option('wpmysocial_plugin_settings') )  {
            
            extract( get_option('wpmysocial_plugin_settings') );
            $displayMysocial = $this->wpmysn_afficheReseauxSociaux();
            
            if( get_option('wpmysocial_abovepost')==true && !get_option('wpmysocial_belowpost') ) {
                $returnContent = $content.$displayMysocial;
            } else if( get_option('wpmysocial_belowpost')==true && !get_option('wpmysocial_abovepost') ) {         
                $returnContent = $displayMysocial.$content;
            } else {
                $returnContent = $displayMysocial.$content.$displayMysocial;
            }

        }

        if( $expostid!='' ) {
            
            $pids = explode(",", $expostid);
            if( in_array($post->ID, $pids) ) {
                $returnContent =  $content;
            }
            $psttype = get_post_type($post->ID);
            if( in_array($psttype, $pids) && $psttype!==flase ) {
                $returnContent =  $content;
            }
            $pstfrmt = get_post_format($post->ID);
            if( in_array($pstfrmt, $pids) && $pstfrmt!==false ) {
                return $content;
            }
            
        }
        
        if( $expostcat!='' ) {
            
            $pcat = explode(",", $expostcat);
            if( in_category($pcat) ) {
                $returnContent = $content;
            }
            
        }
        return $returnContent;

    }
                   
    function wpmysn_add_meta() {
    
        global $post, $posts;

        if(!get_option('wpmysocial_excludemeta')) {

            $desc = ""; 
            if ( has_excerpt(get_the_ID()) ) {
                $desc = esc_attr( strip_tags( get_the_excerpt(get_the_ID()) ) );
            } else {
                $desc = esc_attr( str_replace("\r\n",' ', substr(strip_tags(strip_shortcodes(get_the_content())), 0, 160)) );
            }
            if(trim($desc)=="") { $desc = get_the_title(''); }

            if(function_exists('get_post_thumbnail_id') && function_exists('wp_get_attachment_image_src')) {
                $image_id = get_post_thumbnail_id();
                $image_url = wp_get_attachment_image_src($image_id,'large');
                $thumb = $image_url[0];
            }

    echo '
    <meta property="og:type" content="article" />';
    echo '
    <meta property="og:title" content="'.get_bloginfo('name').'" />';
    echo '
    <meta property="og:url" content="'.get_permalink().'"/>';
    echo '
    <meta property="og:description" content="'.$desc.'" />';
    echo '
    <meta property="og:site_name" content="'.get_bloginfo('name').'" />';
    echo '
    <meta property="og:image" content="'.$thumb.'" />';

        }
    }
                   
    function wpmysn_css() {
        $siteurl = get_option('siteurl');
        $url = plugins_url('../css/mysocials.css', __FILE__);
        
        echo "<link href='".$url."' rel='stylesheet' type='text/css' />";
        if(!get_option('wpmysocial_plugin_style') or get_option('wpmysocial_plugin_style')=='') { 
            update_option('wpmysocial_plugin_style', $this->wpmysn_print_style());
        }
        echo "<style type='text/css'>".get_option('wpmysocial_plugin_style').'</style>';
    }

    function wpmysn_plusOneOptions() {
        
        global $post;
        
        if(get_option('wpmysocial_plugin_settings')) { extract(get_option('wpmysocial_plugin_settings')); }
        $options = get_option('wpmysocial_plugin_settings');
        
        if( isset($options['plusone_btn']) && $options['plusone_btn']==1) {
        echo '<link rel="canonical" href="'.get_permalink($post->ID).'" />
    ';
        echo "<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: '".get_option('wpmysocial_plugin_lang')."'}</script>
    ";
        }
    }
                   
    /* Feuille de style par défault */
    function wpmysn_print_style() {

    return '
#wp-socials-general-btn { float: left;min-height:65px; }
#wp-socials-fb-like { float:left;margin-right:5px;min-height: 65px; }
#wp-socials-twitter { float:left;margin-right:5px;max-width: 85px;min-height: 65px; }
#wp-socials-linkedin { float:left;margin-right:5px;margin-top: 4px;min-height: 65px; }
#wp-socials-plusone { float:left;margin-right:5px;min-height: 30px; }
#wp-socials-addthis { float:left;margin-right:5px;margin-top: 4px;min-height: 65px; }
    ';

    } 
                   
    function wpmysn_uninstall() {
    
        global $wpdb;

        if(get_option('wpmysocial_plugin_settings')) { delete_option('wpmysocial_plugin_settings'); } else { echo 'Erreur : wpmysocial_plugin_settings'; }
        if(get_option('wpmysocial_plugin_version')) { delete_option('wpmysocial_plugin_version'); } else { echo 'Erreur : wpmysocial_plugin_version'; }
        delete_option('wpmysocial_excludeid');
        delete_option('wpmysocial_excludecat');
        delete_option('wpmysocial_excludemeta');
        delete_option('wpmysocial_belowpost');
        delete_option('wpmysocial_abovepost');
        delete_option('wpmysocial_plugin_lang');
    }
    
    
    
}


?>