//window.cf7_vc_main_iframe = jQuery('#cf7-vc-main-ifrm');
(function($){
    var Cf7VcApp = function(){
        var self = this;

        self.startEditingBtn = $('.cf7-start-editing-btn');
        self.main_iframe_wrap = $('#cf7-vc-main-ifrm-wrap');
        self.main_iframe_id_name = 'cf7-vc-main-ifrm';
        self.main_iframe = $('#' + self.main_iframe_id_name);       
        self.cf7Textarea = $('textarea#wpcf7-form');

        var save_form_btn = $('#publishing-action input[name="wpcf7-save"]');

        /*
         * Init function
         */
        
        self.init = function()
        {
            self.startEditingBtn.click(function(event) {
                self.startEditing();
            });           
            //self.setCf7Value();                       
        };

        self.startEditing = function()
        {            
            self.main_iframe_wrap.append('<iframe src="" frameborder="0" id="' + self.main_iframe_id_name + '" class="cf7-vc-iframe-fullscreen"></iframe>');
            self.main_iframe_wrap.find('#cf7-vc-main-ifrm').attr('src', njt_cf7vc_object.vc_elements_url);
            //self.startEditingBtn.hide();
        };

        self.getVCValue = function()
        {
            var $val = self.main_iframe.contents().find('#content').val();
            return $val;
        };

        self.setCf7Value = function()
        {
            setInterval(function(){
                if (self.main_iframe && self.main_iframe.attr('src') != '') {
                    self.cf7Textarea.val(self.getVCValue());
                }                            
            }, 1000);
        };

    };
    
    
    jQuery(document).ready(function($) {
        var cf7_vc_app = new Cf7VcApp();
        cf7_vc_app.init();
    });
    jQuery(window).load(function() {
    });
})(jQuery);