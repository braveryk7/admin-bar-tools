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

export type ItemType = {
	name: string;
	shortname: shortNameType;
	status: boolean;
	url: string;
	adminurl: string;
};

export type ItemsWrapperType< T > = {
	[ key: string ]: T;
};

export type WPApiType< T > = {
	abt_status: { // eslint-disable-line
		[ key: string ]: T;
	};
};
