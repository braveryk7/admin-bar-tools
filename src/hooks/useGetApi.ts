import { Dispatch, SetStateAction } from 'react';

import apiFetch from '@wordpress/api-fetch';
import { useEffect } from '@wordpress/element';

import { apiType } from '../types/apiType';

export const useGetApi = (
	stateFunc: Dispatch< SetStateAction< apiType | undefined > >,
) => {
	useEffect( () => {
		apiFetch< apiType >(
			{ path: '/admin-bar-tools/v1/options' }
		).then( ( value ) => {
			stateFunc( value );
		} );
	}, [ stateFunc ] );
};
