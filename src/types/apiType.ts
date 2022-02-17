export type apiType = {
	abt_options: {
		status: {};
		locale: string;
		sc: number;
		version: number;
	};
};

export type WPApiType< T > = {
	[ key: string ]: {
		[ key: string ]: T;
	};
};
