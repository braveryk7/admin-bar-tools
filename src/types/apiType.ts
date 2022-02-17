export type apiType = {
	abt_options: {
		status: {};
		locale: string;
		sc: number;
		version: number;
	};
};

export type locationItems = {
	name: string;
	shortname: string;
	status: number;
	url: string;
	admin: string;
	order: number;
};

export type WPApiType< T > = {
	[ key: string ]: {
		[ key: string ]: T;
	};
};
