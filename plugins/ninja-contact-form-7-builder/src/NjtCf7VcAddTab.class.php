<?php

class NjtCf7VcAddTab
{
    private static $_instance = null;

    public function __construct()
    {
        add_filter('wpcf7_editor_panels', array($this, 'addTabVC'));
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function addTabVC($panels)
    {
        if (!$this->isCF7VCPage()) {
            unset($panels['form-panel']);
            $cf7_vc = array(
                'cf7-vc' => array(
                    'title' => __('Form Builder', CF7_VC_LANG_PREFIX),
                    'callback' => array($this, 'addTabVCCallBack')
                ),
            );
            $panels = $cf7_vc + $panels;
        } else {
            foreach ($panels as $k => $v) {
                if ($k != 'form-panel') {
                    unset($panels[$k]);
                }
            }
        }
        return $panels;
    }
    public function addTabVCCallBack($post)
    {
        ?>
        <div id="cf7-vc-main-ifrm-wrap">
            <img src="<?php echo CF7_VC_URL; ?>/assets/admin/img/64x64.png" alt="" />
            <h3><?php _e('Start editing form with visual composer', CF7_VC_LANG_PREFIX); ?></h3>
            <a href="javascript:void(0)" class="cf7-start-editing-btn">
                <i class="_icon"></i>                
                <?php echo __('Start Editing', CF7_VC_LANG_PREFIX); ?>                
            </a>
        </div>
        <textarea style="display: none !important; width: 0; height: 0;" name="wpcf7-form" id="wpcf7-form" class=""><?php echo esc_textarea($post->prop('form')); ?></textarea>
        <?php
    }
    public function isCF7VCPage()
    {
        if (isset($_GET['page']) && ($_GET['page'] == 'wpcf7-new') && isset($_GET['cf7_vc']) && ($_GET['cf7_vc'] == 'true')) {
            return true;
        } else {
            return false;
        }
    }
}
