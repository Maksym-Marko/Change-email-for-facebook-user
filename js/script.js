jQuery( document ).ready( function( $ ){

	$( '#mx_change_email_for_facebook' ).attr( 'onsubmit', 'return false' );

	$( '#mx_confirm_password' ).on( 'blur', function(){

		var newPass = $( '#mx_password' ).val();
		var confirmPass = $( '#mx_confirm_password' ).val();

		if( newPass !== confirmPass ){

			$( '#mx_confirm_password' ).next( '.mx-error_i' ).remove();
			$( '#mx_confirm_password' ).after( '<div class="mx-error_i">Пароли не совпадают!</div>' );

		} else{

			$( '#mx_confirm_password' ).next( '.mx-error_i' ).remove();

			$( '#mx_change_email_for_facebook' ).attr( 'onsubmit', 'return true' );

		}

	} );

} );