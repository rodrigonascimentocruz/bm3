jQuery(document).ready(function () {
	
    jQuery('.redux-add').click(function () {
        var oldSlide = jQuery(this).prev().find('.redux-accordion-group:last');
        oldSlide.find('select').select2('destroy');
		
        var newSlide = oldSlide.clone(true).removeClass("hidden");
        var SocialCount = jQuery(newSlide).find('input[type="text"]').attr("name").match(/[0-9]+(?!.*[0-9])/);
        var SocialCount1 = SocialCount*1 + 1;

        jQuery(newSlide).find('input[type="text"],  input[type="hidden"], textarea, select').each(function(){

            if(typeof jQuery(this).attr("name") !== 'undefined') {
                jQuery(this).attr("name", jQuery(this).attr("name").replace(/[0-9]+(?!.*[0-9])/, SocialCount1) );
            }
            if(typeof jQuery(this).attr("id") !== 'undefined') {
                jQuery(this).attr("id", jQuery(this).attr("id").replace(/[0-9]+(?!.*[0-9])/, SocialCount1) );
            }
            jQuery(this).val('');
            if (jQuery(this).hasClass('social-sort')){
                jQuery(this).val(SocialCount1);
            }
        });
        newSlide.find('input[type="checkbox"]').removeAttr('checked');
        newSlide.find('h3').text('').append('<span class="redux-header">New Social</span><span class="ui-accordion-header-icon ui-icon ui-icon-plus"></span>');
        jQuery(this).prev().append(newSlide);
        jQuery.redux.select3();
    });
	
    jQuery('.social-title').keyup(function(event) {
        var newTitle = event.target.value;
        jQuery(this).parents().eq(3).find('.redux-header').text(newTitle);
    });
	
	jQuery('.redux-remove').live('click', function () {
        redux_change(jQuery(this));
		
        jQuery(this).parent().siblings().find('input[type="text"]').val('');
        jQuery(this).parent().siblings().find('textarea').val('');
        jQuery(this).parent().siblings().find('input[type="hidden"]').val('');

        var SocialCount = jQuery(this).parents('.redux-container:first').find('.redux-accordion-group').length;

        //if (SocialCount > 1) {
            jQuery(this).parents('.redux-accordion-group:first').slideUp('medium', function () {
                jQuery(this).remove();
            });
        /*
		} else {
            jQuery(this).parents('.redux-accordion-group:first').find('.remove-image').click();
            jQuery(this).parents('.redux-container:first').find('.redux-accordion-group:last').find('.redux-header').text("New Social");
        }
		*/
    });
	
    jQuery(function () {
        jQuery(".redux-accordion")
            .accordion({
                header: "> div > fieldset > h3",
                collapsible: true,
                active: false,
                heightStyle: "content",
                icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
            })
            .sortable({
                axis: "y",
                handle: "h3",
                connectWith: ".redux-accordion",
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                },
                placeholder: "ui-state-highlight",
                stop: function (event, ui) {
                    ui.item.children("h3").triggerHandler("focusout");
                    var inputs = jQuery('input.social-sort');
                    inputs.each(function(idx) {
                        jQuery(this).val(idx);
                    });
                }
            });
    });
	
});