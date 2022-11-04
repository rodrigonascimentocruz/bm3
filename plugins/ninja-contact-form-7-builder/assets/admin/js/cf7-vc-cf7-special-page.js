jQuery(document).ready(function($) {
    var parentWindow = window.parent || window.top;
    $('input.insert-tag').click(function(event) {
        var form = $(this).closest('form.tag-generator-panel');
        var tag = form.find('input.tag').val();
        var tag_id = form.find('input.idvalue').val();

        var parent_tag_element = jQuery('#njt-cf7-vc-input-content', parentWindow.document);
        var parent_tag_id_element = parent_tag_element.closest('.vc_edit-form-tab').find('input[name="label_for"]');
        
        jQuery('.njt_cf7_vc_cf7_ele_iframe > iframe', parentWindow.document).removeClass('cf7-vc-iframe-fullscreen');
        parent_tag_element.val(tag);
        parent_tag_id_element.val(tag_id);
        return false;
    });

    $('#tag-generator-list > a').click(function(event) {
        jQuery('.njt_cf7_vc_cf7_ele_iframe > iframe', parentWindow.document).addClass('cf7-vc-iframe-fullscreen');
    });

    var tb_unload_count = 1;
    jQuery(window).bind('tb_unload', function () {
        if (tb_unload_count > 1) {
            tb_unload_count = 1;
        } else {
            jQuery('.njt_cf7_vc_cf7_ele_iframe > iframe', parentWindow.document).removeClass('cf7-vc-iframe-fullscreen');
            tb_unload_count = tb_unload_count + 1;
        }
    });
    
}); 