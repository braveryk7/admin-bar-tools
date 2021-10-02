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
