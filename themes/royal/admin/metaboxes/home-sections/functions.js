function royal_filter_params( ) {
	jQuery( '[data-header-section]' ).hide( );
	jQuery( '[data-header-section="' + jQuery( '#header-section' ).val( ) + '"]' ).show( );
}

function royal_slides_content( ) {
	if ( royalSlidesContent.length > 0 ) {
		jQuery.each( royalSlidesContent, function( that, node ) {
			jQuery( '#slideshow-field-' + node.id ).show( ).find( 'input[type="text"]' ).val( node.url.replace( /"/g, '' ) );
		} );
	}
}

jQuery( document ).ready( function( jQuery ) {
	jQuery( '.meta-item-upload' ).click( function( e ) {
		e.preventDefault( );

		var area_id = jQuery( this ).attr( 'data-area' ),
			area = jQuery( area_id ),
			is_multiple = jQuery( this ).attr( 'data-multiple' ) == 'true';

		frame = wp.media( {
			title: royal_home_lng.insert_media,
			frame: 'post',
			multiple: is_multiple,
			library: { type: 'image' },
			button: { text: royal_home_lng.insert_media },
		} );

		frame.on( 'close', function( data ) {
			var imageArray = [];

			images = frame.state( ).get( 'selection' );
			images.each( function( image ) {
				imageArray.push( image.attributes.url );
			} );

			if ( ! is_multiple ) jQuery( area ).val( imageArray.join( ', ' ) );
			else {
				if ( area_id == '#slideshow-fields' ) {
					var item;

					if ( images.length >= jQuery( area ).find( '.meta-item-row' ).not( ':visible' ).length ) {
						jQuery( '#slideshow-add-button' ).hide( );
					}

					images.each( function( image ) {
						item = jQuery( area ).find( '.meta-item-row' ).not( ':visible' ).eq( 0 );
						if ( item.length > 0 ) {
							item.find( 'input[type="text"]' ).val( image.attributes.url );
							item.show( );
						}
					} );
				} else {
					var code;

					images.each( function( image ) {
						code = '' +
						'<div class="meta-item-row-alt meta-pb-10">' +
						'  ' + royal_home_lng.image + ' <span class="meta-item-row-alt-c">-</span>' +
						'  <input type="text" class="meta-item-l alt" name="slideshow-alt-images[]" value="' + image.attributes.url + '">' +
						'  <input type="button" class="button" data-remove-image="true" value="' + royal_home_lng.remove + '">' +
						'</div>';

						jQuery( code ).appendTo( area );
					} );

					jQuery( area ).find( '.meta-item-row-alt-c' ).each( function( index ) {
						jQuery( this ).text( index + 1 );
					} );
				}
			}
		} );

		frame.open( );
	} );

	jQuery( document ).on( 'click', 'input[data-remove-slide]', function( evt ) {
		var item = jQuery( this ).parent( ).parent( ).parent( );
		evt.preventDefault( );

		item.hide( );
		item.find( 'input[type="text"]' ).val( '' );
		tinyMCE.get( item.find( 'textarea' ).attr( 'id' ) ).setContent( '' );

		jQuery( '#slideshow-add-button' ).show( );
	} );

	jQuery( document ).on( 'click', 'input[data-remove-image]', function( evt ) {
		evt.preventDefault( );
		jQuery( this ).parent( ).remove( );
	} );

	jQuery( '#header-section' ).on( 'change', function( ) {
		royal_filter_params( );
	} );

	royal_filter_params( );
	royal_slides_content( );
} );
