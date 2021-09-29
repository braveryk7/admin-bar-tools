// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { WPApiType } from '../types/apiType';
import { ItemsWrapperType, ItemType } from '../types/checkboxType';

export const useSetApi = (
	itemKey: string,
	value: ItemsWrapperType< ItemType > | number
) => {
	api.loadPromise.then( () => {
		const model = new api.models.Settings( {
			[ itemKey ]: value,
		} );
		const save = model.save();

		save.success( ( res: WPApiType< ItemType >, status: string ) => {
			return [ res, status ];
		} );
		save.error( ( res: WPApiType< ItemType >, status: string ) => {
			return [ res, status ];
		} );
	} );
};
