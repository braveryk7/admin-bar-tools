export type apiType = {
	items: locationsType;
	locale: string;
	sc: number;
	version: number;
};

export type locationsType = {
	[key in shortNameType]: locationItemsType;
};

export type locationItemsType = {
	name: string;
	shortname: shortNameType;
	status: boolean;
	url: string;
	adminurl: string;
	order: number;
};

export type shortNameType =
	| 'psi'
	| 'lh'
	| 'gsc'
	| 'gc'
	| 'gi'
	| 'twitter'
	| 'facebook'
	| 'hatena'
	| 'bi';

export type WPApiType< T > = {
	[ key: string ]: {
		[ key: string ]: T;
	};
};

export type useSetApiType = {
	( itemKey: string, value: apiType ): void;
};
