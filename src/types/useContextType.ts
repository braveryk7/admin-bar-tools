import { Dispatch, SetStateAction } from 'react';

import { apiType } from 'src/types/apiType';

export type noticeValueType = 'abt_success' | 'abt_error' | null;

export type apiContextType = {
	apiData: apiType | undefined;
	setApiData: Dispatch< SetStateAction< apiType | undefined > >;
	setNoticeValue: Dispatch< SetStateAction< noticeValueType > >;
	setNoticeMessage: Dispatch< SetStateAction< string > >;
	snackbarTimer: number;
};
