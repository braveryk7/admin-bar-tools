import { Dispatch, SetStateAction } from 'react';

import apiFetch from '@wordpress/api-fetch';
import { useEffect } from '@wordpress/element';

import { apiType } from '../types/apiType';

export const useGetApi = (
	stateFunc: Dispatch< SetStateAction< apiType > >,
	setApiStatus: Dispatch< SetStateAction< boolean > >
) => {
	useEffect( () => {
		apiFetch< apiType >( { path: '/abt/v1/options' } ).then( ( value ) => {
			stateFunc( value );
			setApiStatus( true );
		} );
	}, [ stateFunc ] );
};
