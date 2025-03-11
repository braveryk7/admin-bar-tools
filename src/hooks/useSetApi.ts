import apiFetch from '@wordpress/api-fetch';
import { useContext, useEffect, useRef } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { apiContext } from 'src/index';

import { useSetApiType } from 'src/types/apiType';

export const useSetApi: useSetApiType = ( itemKey, value ) => {
	const {
		apiData,
		setNoticeValue,
		setNoticeMessage,
		snackbarTimer,
	} = useContext( apiContext );

	const isFirstRender = useRef( true );

	useEffect( () => {
		if ( isFirstRender.current ) {
			isFirstRender.current = false;
		} else if ( value ) {
			setNoticeValue( undefined );
			clearTimeout( snackbarTimer );

			apiFetch( {
				path: '/admin-bar-tools/v1/update',
				method: 'POST',
				data: { [ itemKey ]: value[ itemKey ] },
			} ).then( () => {
				setNoticeValue( 'abt_success' );
				setNoticeMessage( __( 'Success.', 'admin-bar-tools' ) );
			} ).catch( () => {
				setNoticeValue( 'abt_error' );
				setNoticeMessage( __( 'Error.', 'admin-bar-tools' ) );
			} );
		}
	}, [ apiData, itemKey, setNoticeMessage, setNoticeValue, snackbarTimer, value ] );
};
