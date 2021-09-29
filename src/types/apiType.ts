import { ItemsWrapperType, ItemType } from './checkboxType';

export type apiType = {
	abt_sc?: number; // eslint-disable-line
	abt_status?: ItemsWrapperType< ItemType >; // eslint-disable-line
};

export type WPApiType< T > = {
	[ key: string ]: { // eslint-disable-line
		[ key: string ]: T;
	};
};
