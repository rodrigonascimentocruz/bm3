jQuery(document).ready(function($) {

    var parentWindow = window.parent || window.top;

    jQuery('.cf7-vc-loading').hide();

    $('#vc_navbar .vc_navbar-nav').prepend('<li class="vc_pull-right"><a id="cf7-vc-cancel-editing" href="javascript:;" class="vc_icon-btn" title="'+njt_cf7vc_cpt.close_text+'">'+njt_cf7vc_cpt.close_text+'</a></li>');
    $('#vc_navbar .vc_navbar-nav').prepend('<li class="vc_pull-right"><a id="cf7-vc-save-editing" href="javascript:;" class="vc_icon-btn" title="'+njt_cf7vc_cpt.save_text+'">'+njt_cf7vc_cpt.save_text+'</a></li>');

    $(document).on('click', '#cf7-vc-save-editing', function(event) {
        event.preventDefault();
        jQuery('.cf7-vc-loading').show();
        
        var form = $(this).closest('#post');
        var content = form.find('#content').val();
        
        var data = {
            'action': 'njt_cf7_vc',
            'act': 'update_post_meta',
            'value': content,
            'form_unique_id': parentWindow.njt_cf7vc_object.form_unique_id
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
        })
        .done(function(json) {
            jQuery('textarea#wpcf7-form', parentWindow.document).val(content);
            /* Save Form */
            jQuery('.cf7-vc-loading').hide();
            jQuery('#cf7-vc-main-ifrm', parentWindow.document).remove(); 
            jQuery('#publishing-action input[name="wpcf7-save"]', parentWindow.document).trigger('click');
            /*
            
            jQuery('.cf7-start-editing-btn', parentWindow.document).show();
            */
        });
    });
    $(document).on('click', '#cf7-vc-cancel-editing', function(event) {
        event.preventDefault();
        jQuery('#cf7-vc-main-ifrm', parentWindow.document).remove();
    });
});