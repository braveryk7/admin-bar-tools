import { Dispatch, SetStateAction } from 'react';

import apiFetch from '@wordpress/api-fetch';
import { useEffect } from '@wordpress/element';

import { apiType } from '../types/apiType';

export const useGetApi = (
	stateFunc: Dispatch< SetStateAction< Promise< apiType > > >,
	setApiStatus: Dispatch< SetStateAction< boolean > >
) => {
	useEffect( () => {
		apiFetch<Promise<apiType>>( { path: '/abt/v1/options' } ).then( ( value ) => {
			if ( value ) {
				stateFunc( value );
				setApiStatus( true );
			}
		} );
	}, [ stateFunc ] );
};
