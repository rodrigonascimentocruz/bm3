<?php



class NjtCf7Vc

{

    private static $_instance = null;

    private $cf7_elements_url = '';

    private $unique_form_id = '';

    private static $post_type = 'cf7_vc';



    public function __construct()

    {

        if (!$this->isActiveVC()) {

            /*

             * Admin notice

             */

            add_action('admin_notices', array($this, 'adminNotices'));

            return false;

        }

        /*

         * Load Text Domain

         */

        add_action('plugins_loaded', array($this, 'loadTextDomain'));



        /*

         * Register Enqueue

         */

        add_action('admin_enqueue_scripts', array($this, 'registerAdminEnqueue'));

        

        /*

         * Register Custom Post Type

         */

        add_action('init', array($this, 'registerCustomPostType'));



        /*

         * My init actions

         */

        add_action('init', array($this, 'init'));

        

        /*

         * Add VC to our custom post type

         */

        add_action('admin_init', array($this, 'addCap'));



        /*

         * Add js, css to our custom post type

         */

        add_action('admin_print_scripts-post-new.php', array($this, 'addCustomPostTypeJs'), 1000);

        add_action('admin_print_scripts-post.php', array($this, 'addCustomPostTypeJs'), 1000);



        add_action('admin_print_styles-post-new.php', array($this, 'addCustomPostTypeCss'));

        add_action('admin_print_styles-post.php', array($this, 'addCustomPostTypeCss'));



        /*

         * Set default Content for custom post

         */

        //add_filter('default_content', array($this, 'customPostDefaultContent'), 10, 2);

        add_action('edit_form_after_title', array($this, 'editFormAfterTitle'));

        add_filter('wpb_vc_js_status_filter', array($this, 'vcStatusFilter'));



        /*

         * Add loading effect before loading VC

         */

        add_action('in_admin_header', array($this, 'cf7VCLoading'));



        /*

         * Add New VC Element

         */

        add_action('vc_before_init', array($this, 'integrateWithVC'));

        add_shortcode('vc_cf7_elements', array($this, 'doCf7VcShortcode'));



        /*

         * Add new VC Param

         */

        vc_add_shortcode_param('cf7_vc', array($this, 'cf7VcElementsSettingsField'), CF7_VC_URL . '/assets/admin/js/vc_opened.js');

        vc_add_shortcode_param('cf7_vc_raw_text', array($this, 'cf7VcElementsSettingsFieldRawText'));

        

        /*

         * Add Form Builder Tab

         */

        NjtCf7VcAddTab::instance();



        $this->cf7_elements_url = add_query_arg(array('page' => 'wpcf7-new', 'cf7_vc' => 'true'), esc_url(admin_url('admin.php')));



        /*

         * Use shortcode in Contact Form 7

         */

        add_filter('wpcf7_form_elements', array($this, 'wpcf7FormElements'));



        /*

         * Disable Confirm Dialog When leaving

         */

        //add_action('admin_head' , array($this, 'disableConfirmDialog'));

        

        /*

         * Register Ajax

         */

        add_action('wp_ajax_njt_cf7_vc', array($this, 'registerAjax'));



        $this->unique_form_id = $this->uniqueFormId();



        add_filter('do_shortcode_tag', array($this, 'doShortcodeTag'), 10, 4);



        /*

         * Print some code in edit.php to hide the Cf7 element

         */

        add_action("admin_footer-post.php", array($this, "adminFooterPostPhp"));

        add_action("admin_footer-post-new.php", array($this, "adminFooterPostPhp"));



    }

    public static function instance()

    {

        if (is_null(self::$_instance)) {

            self::$_instance = new self();

        }

        return self::$_instance;

    }

    public function init()

    {

        /*

         * Add new post, used to load VC to contact form

         */

    }

    public function adminNotices()

    {

        if (!$this->isActiveVC()) {

            ?>

            <div class="warning notice notice-warning is-dismissible">

                <p>

                    <?php _e('CF7 Visual Composer Waring: Please Active Visual Composer.', CF7_VC_LANG_PREFIX) ?>

                </p>

            </div>

            <?php

        }

    }

    private function isActiveVC()

    {

        return function_exists('vc_map');

    }

    private function insertCf7VCMainPost()

    {

        $args = array(

            'post_name' => 'NinjaTeam CF7 VC',

            'post_type' => self::$post_type,

        );

        $cf7_vc_main_post = wp_insert_post($args);

        update_option('cf7_vc_main_post', $cf7_vc_main_post);

    }

    public function getCf7VCMainPost()

    {

        global $wpdb;

        $post_id = (int)get_option('cf7_vc_main_post', null);

        if (is_null($post_id) || !($post_id > 0) || !is_string(get_post_status($post_id)) || (get_post_type($post_id) != 'cf7_vc')) {

            $wpdb->delete('posts', array('post_type' => 'cf7_vc'), array('%s'));

            $this->insertCf7VCMainPost();

            $post_id = get_option('cf7_vc_main_post', null);

        }

        return $post_id;

    }

    public function registerAdminEnqueue($hook_suffix)

    {

        if (false === strpos($hook_suffix, 'wpcf7')) {

            return;

        }

        wp_register_style('cf7-vc', CF7_VC_URL . '/assets/admin/css/cf7-vc.css');

        wp_enqueue_style('cf7-vc');



        wp_register_script('cf7-vc', CF7_VC_URL . '/assets/admin/js/cf7-vc.js', array('jquery'));

        wp_enqueue_script('cf7-vc');

        

        /*

        $vc_elements_query = array('post_type' => 'cf7_vc');

        if (isset($_GET['post'])) {

            $cf7id = (int)$_GET['post'];

            if ($cf7id > 0) {

                $vc_elements_query['cf7id'] = (int)$_GET['post'];

            }

        }

        $vc_elements_url = add_query_arg($vc_elements_query, esc_url(admin_url('post-new.php')));

        */

        $vc_elements_query = array(

            'action' => 'edit',

            'post' => $this->getCf7VCMainPost(),

            'cf7_vc' => 1,

        );

        if (isset($_GET['post'])) {

            $cf7id = (int)$_GET['post'];

            if ($cf7id > 0) {

                $vc_elements_query['cf7id'] = (int)$_GET['post'];

            }

        }

        $vc_elements_url = add_query_arg($vc_elements_query, esc_url(admin_url('post.php')));



        wp_localize_script('cf7-vc', 'njt_cf7vc_object',

            array(

                'cf7_elements_url' => $this->cf7_elements_url,

                'vc_elements_url' => $vc_elements_url,

                'form_unique_id' => $this->unique_form_id,

            )

        );



        /*

         * this is Add new contact form 7 page, has cf7_vc on URL.

         */

        if (substr($hook_suffix, -15) == '_page_wpcf7-new' && isset($_GET['cf7_vc']) && ($_GET['cf7_vc'] == 'true')) {

            wp_register_style('cf7-vc-hidden-cf7-tags', CF7_VC_URL . '/assets/admin/css/hidden-cf7.css');

            wp_enqueue_style('cf7-vc-hidden-cf7-tags');



            wp_register_script('cf7-vc-cf7-special-page', CF7_VC_URL . '/assets/admin/js/cf7-vc-cf7-special-page.js', array('jquery'));

            wp_enqueue_script('cf7-vc-cf7-special-page');

        }

    }

    private function uniqueFormId()

    {

        return md5(njt_get_user_ip());

    }

    private function clearTempMeta()

    {

        global $wpdb;

        $wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE `meta_key` LIKE '_cf7_vc_%'");

    }

    public function addCustomPostTypeJs()

    {

        global $post;

        if ($post->post_type == self::$post_type) {
          wp_dequeue_script('frame_event_publisher');
            wp_register_script('cf7-cpt', CF7_VC_URL . '/assets/admin/js/cpt.js', array('jquery'));

            wp_enqueue_script('cf7-cpt');



            wp_localize_script('cf7-cpt', 'njt_cf7vc_cpt',

                array(

                    'save_text' => __('Save Changes', CF7_VC_LANG_PREFIX),

                    'close_text' => __('Close', CF7_VC_LANG_PREFIX),

                )

            );

        }

    }

    public function addCustomPostTypeCss()

    {

        global $post;

        if ($post->post_type == self::$post_type) {

            wp_register_style('cf7-vc-cpt', CF7_VC_URL . '/assets/admin/css/cpt.css');

            wp_enqueue_style('cf7-vc-cpt');



            wp_dequeue_script('autosave');

        }

    }

    public function loadTextDomain()

    {

        load_plugin_textdomain('cf7_vc', false, plugin_basename(CF7_VC_DIR) . '/languages/');

    }

    public function registerCustomPostType()

    {

        $labels = array(

            'name'               => __('CF7 VC Items', CF7_VC_LANG_PREFIX),

        );



        $args = array(

            'labels'             => $labels,

            'public'             => true,

            'publicly_queryable' => false,

            'show_ui'            => true,

            'show_in_menu'       => false,

            'query_var'          => false,

            'rewrite'            => array('slug' => 'cf7-vc'),

            'capability_type'    => 'post',

            'has_archive'        => false,

            'hierarchical'       => false,

            'menu_position'      => null,

            'can_export'         => false,

            'supports'           => array('title', 'editor')

        );



        register_post_type(self::$post_type, $args);

    }

    /*public function customPostDefaultContent($_post)

    {

        global $post;

        if (is_admin() && ($_post->post_type == 'cf7_vc')) {

            if (!isset($_GET['cf7id'])) {

                $post->post_content = 'default ne';

            } else {

                if (function_exists('wpcf7_contact_form')) {

                    $contact_form = wpcf7_contact_form((int)$_GET['cf7id']);

                    $post->post_content = $contact_form->form_html($atts);

                }

            }

        }

    }*/

    public function customPostDefaultContent($post_content, $post)

    {

        if ($post->post_type == self::$post_type) {

            if (!isset($_GET['cf7id'])) {

                if (class_exists('WPCF7_ContactFormTemplate')) {

                    $post_content = WPCF7_ContactFormTemplate::get_default('form');

                }

            } else {

                if (function_exists('wpcf7_contact_form')) {

                    $contact_form = wpcf7_contact_form((int)$_GET['cf7id']);

                    $post_content = $contact_form->form_html();

                }

            }

        }

        return $post_content;

    }

    public function editFormAfterTitle()

    {

        global $post;

        if (is_admin() && ($post->post_type == self::$post_type)) {

            if ($meta = get_post_meta($this->getCf7VCMainPost(), '_cf7_vc_' . $this->unique_form_id, true)) {

                $this->clearTempMeta();

                $post->post_content = $meta;

            } else {

                if (!isset($_GET['cf7id'])) {

                    if (class_exists('WPCF7_ContactFormTemplate')) {

                        $post->post_content = WPCF7_ContactFormTemplate::get_default('form');

                    }

                } else {

                    if (function_exists('wpcf7_contact_form')) {

                        $contact_form = wpcf7_contact_form((int)$_GET['cf7id']);

                        $post->post_content = $contact_form->prop('form');

                    }

                }

            }

        }

    }

    public function vcStatusFilter($status)

    {

        global $post;

        if ($post->post_type == self::$post_type) {

            return 'true';

        }

        return $status;

    }

    public function cf7VCLoading()

    {

        global $post;

        if (!$post || ($post->post_type != self::$post_type)) {

            return false;

        }

        ?>

        <div class="cf7-vc-loading">

            <div class="cf7-vc-loading-inner">

                <div class="cssload-thecube">

                    <div class="cssload-cube cssload-c1"></div>

                    <div class="cssload-cube cssload-c2"></div>

                    <div class="cssload-cube cssload-c4"></div>

                    <div class="cssload-cube cssload-c3"></div>

                </div>

            </div>            

        </div>

        <?php

    }

    public function integrateWithVC()

    {

        $params = array(

            array(

                "type" => "textfield",

                "heading" => __("Label", CF7_VC_LANG_PREFIX),

                "param_name" => "label",

                "admin_label" => true,

            ),

            array(

                "type" => "cf7_vc",

                "heading" => __("Contact Form 7 Element", CF7_VC_LANG_PREFIX),

                "param_name" => "content",

                "admin_label" => true,

            ),

            array(

                "type" => "hidden",

                "param_name" => "label_for",

            ),

            array(

                'type' => 'css_editor',

                'heading' => __('Css', CF7_VC_LANG_PREFIX),

                'param_name' => 'css',

                'group' => __('Design options', CF7_VC_LANG_PREFIX),

            )

        );

        vc_map(array(

            "name" => __("Contact Form 7 Element", CF7_VC_LANG_PREFIX),

            "base" => "vc_cf7_elements",

            "icon" => "icon-wpb-wp",

            "class" => "",

            "category" => __("Contact Form 7", CF7_VC_LANG_PREFIX),

            "params" => $params,

        ));

    }

    public function doCf7VcShortcode($atts, $content = null)

    {

        extract(shortcode_atts(array(

            'text' => '',

            'label' => '',

            'label_for' => '',

            'css' => '',

        ), $atts));

        $css_class = vc_shortcode_custom_css_class($css, ' ');



        $content = $this->removeVcSpecialChars($content);

        if (preg_match("#id=\"(.*?)\"#", $content, $m)) {

            $label_for = $m[1];

        }



        if (!empty($label)) {

            $label = htmlspecialchars($label);

            $content = '<label '.(($label_for != 'false') ? 'for="'.esc_attr($label_for).'"' : '').'>'.$label.'</label>' . $content;

        }

        

        return sprintf('<div class="%1$s">%2$s</div>', $css_class, $content);

    }

    public function cf7VcElementsSettingsField($settings, $value)

    {

        //$dependency = vc_generate_dependencies_attributes($settings);

        $dependency = '';

        //$value = htmlspecialchars($value);

        $value = esc_attr($value);

        ?>

        <style type="text/css">

            .cf7-vc-iframe-fullscreen_bak.cf7-vc-iframe-fullscreen{

                height:100% !important;

            }

            .cf7-vc-iframe-fullscreen_bak{

                height:290px;

            }

        </style>

        <?php

        return '<div class="njt_cf7_vc_block">'

            .'<div class="njt_cf7_vc_cf7_ele_iframe"><iframe style="width: 100%;" class="cf7-vc-iframe-fullscreen_bak" src="'.$this->cf7_elements_url.'"></iframe></div>'

            .'<input id="njt-cf7-vc-input-'.$settings['param_name'].'" name="'.$settings['param_name']

            .'" class="wpb_vc_param_value wpb-textinput '

            .$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'

            .$value.'" ' . $dependency . '/>'

            .'</div>';

    }

    public function cf7VcElementsSettingsFieldRawText($settings, $value)

    {

        return '';

    }

    public function addCap()

    {

        $post_types = vc_editor_post_types();

        if (!in_array(self::$post_type, $post_types)) {

            $post_types[] = self::$post_type;

            vc_editor_set_post_types($post_types);

        }

    }

    public function removeVcSpecialChars($str)

    {

        return str_replace(array('`{`', '`}`', '``'), array('[', ']', '"'), $str);

        return $str;

    }

    public function disableConfirmDialog()

    {

        global $post;

        if (!is_null($post) && ($post->post_type == self::$post_type)) {

            ?>

            <script type="text/javascript"> 

                

            </script> 

            <?php

        }

    }

    public function registerAjax()

    {

        if (!isset($_POST['act'])) {

            wp_die('Error');

        }

        if ($_POST['act'] == 'update_post_meta') {

            $value = $_POST['value'];

            $form_unique_id = $_POST['form_unique_id'];

            update_post_meta($this->getCf7VCMainPost(), '_cf7_vc_' . $form_unique_id, $value);

        }

        wp_send_json_success(array('mess' => 'Success'));

    }

    public function doShortcodeTag($output, $tag, $attr, $m)

    {

        if (in_array($tag, array('contact-form-7', 'contact-form'))) {

            if (isset($attr['id'])) {

                $output .= '<style>' . get_post_meta($attr['id'], '_wpb_shortcodes_custom_css', true) . '</style>';

            }

        }

        return $output;

    }

    public function wpcf7FormElements($form)

    {

        $form = preg_replace('#\[vc_row\]\[vc_column\]\[vc_cf7_elements\]<button type="button" class="cf7mls_(next|back) cf7mls_btn action-button" name="(cf7mls_next|cf7mls_back)">(.+)<\/button><\/fieldset><fieldset class="fieldset-cf7mls">\[\/vc_cf7_elements\]\[\/vc_column\]\[\/vc_row\]#', '<button type="button" class="cf7mls_$1 cf7mls_btn action-button" name="$2">$3</button></fieldset><fieldset class="fieldset-cf7mls">', $form);

        return do_shortcode($form);

    }

    public function adminFooterPostPhp()

    {

        global $post;

        if ($post->post_type != self::$post_type) {

            ?>

            <script type="text/javascript">

                jQuery(document).ready(function($) {

                    var e = jQuery('.wpb-content-layouts').find('li[data-element="vc_cf7_elements"]');

                    var cl = e.attr('class');

                    var id_cat = cl.match(/js-category-([a-zA-Z0-9\-_.]+)/);



                    e.hide();

                    tab = jQuery('button[data-filter=".js-category-' + id_cat[1] + '"]').hide();



                });

            </script>

            <?php

        }

    }

}

