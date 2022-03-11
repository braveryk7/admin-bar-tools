import { shortNameList } from 'src/utils/constant';

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

export type shortNameType = typeof shortNameList[number];

export type itemKeyType = 'items' | 'locale' | 'sc' | 'version';

export type useSetApiType = {
	( itemKey: itemKeyType, value: apiType | undefined ): void;
};
