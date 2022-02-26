export type apiType = {
	abt_options: abtOptionsType;
};

export type abtOptionsType = {
	items: locationsType;
	locale: string;
	sc: number;
	version: number;
};

export type locationsType = {
	psi: locationItemsType;
	lh: locationItemsType;
	gsc: locationItemsType;
	gc: locationItemsType;
	gi: locationItemsType;
	bi: locationItemsType;
	twitter: locationItemsType;
	facebook: locationItemsType;
	hatena: locationItemsType;
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
	( itemKey: string, value: abtOptionsType ): void;
};
