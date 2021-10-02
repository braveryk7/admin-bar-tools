import { Dispatch, SetStateAction, useEffect } from 'react';

// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { apiType, WPApiType } from '../types/apiType';
import { ItemType } from '../types/checkboxType';

export const useGetApi = (
	stateFunc: Dispatch< SetStateAction< apiType > >,
	setApiStatus: Dispatch< SetStateAction< boolean > >
) => {
	useEffect( () => {
		api.loadPromise.then( () => {
			const model = new api.models.Settings();

			model.fetch().then( ( res: WPApiType< ItemType > ) => {
				stateFunc( res );
				setApiStatus( true );
			} );
		} );
	}, [ stateFunc ] );
};
