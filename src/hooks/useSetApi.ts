import { useContext, useEffect, useRef } from 'react';

// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { __ } from '@wordpress/i18n';

import { apiContext } from '..';
import { ItemsWrapperType, ItemType } from '../types/CheckboxType';
import { WPApiType } from '../types/apiType';

export const useSetApi = (
	itemKey: string,
	value: ItemsWrapperType< ItemType > | number
) => {
	const { setNoticeStatus, setNoticeValue, setNoticeMessage } = useContext(
		apiContext
	);

	const isFirstRender = useRef( true );

	useEffect( () => {
		if ( isFirstRender.current ) {
			isFirstRender.current = false;
		} else {
			api.loadPromise.then( () => {
				const model = new api.models.Settings( {
					[ itemKey ]: value,
				} );
				const save = model.save();

				setNoticeStatus( false );

				save.success(
					( res: WPApiType< ItemType >, status: string ) => {
						setNoticeStatus( true );
						setNoticeValue( 'abt_success' );
						setNoticeMessage( __( 'Success.', 'admin-bar-tools' ) );
						return [ res, status ];
					}
				);
				save.error( ( res: WPApiType< ItemType >, status: string ) => {
					setNoticeStatus( true );
					setNoticeValue( 'abt_error' );
					setNoticeMessage( __( 'Error.', 'admin-bar-tools' ) );
					return [ res, status ];
				} );
			} );
		}
	}, [ itemKey, value ] );
};
