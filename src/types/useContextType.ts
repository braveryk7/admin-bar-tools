import { Dispatch, SetStateAction } from 'react';

import { apiType } from './apiType';

export type noticeValueType = 'abt_success' | 'abt_error' | undefined;

export type apiContextType = {
	apiData: apiType;
	setApiData: Dispatch< SetStateAction< apiType > >;
	setNoticeValue: Dispatch< SetStateAction< noticeValueType > >;
	setNoticeMessage: Dispatch< SetStateAction< string > >;
	snackbarTimer: number;
};
