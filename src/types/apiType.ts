import { ItemsWrapperType, ItemType } from './CheckboxType';

export type apiType = {
	abt_locale?: string; // eslint-disable-line
	abt_sc?: number; // eslint-disable-line
	abt_status?: ItemsWrapperType< ItemType >; // eslint-disable-line
};

export type WPApiType< T > = {
	[ key: string ]: { // eslint-disable-line
		[ key: string ]: T;
	};
};
