import { ItemsWrapperType, ItemType } from './CheckboxType';

export type apiType = {
	abt_locale?: string;
	abt_sc?: number;
	abt_status?: ItemsWrapperType< ItemType >;
};

export type WPApiType< T > = {
	[ key: string ]: {
		[ key: string ]: T;
	};
};
