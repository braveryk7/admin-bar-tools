import { Dispatch, SetStateAction } from 'react';

import { apiType } from './apiType';

export type noticeValueType = 'abt_success' | 'abt_error' | null;

export type apiContextType = {
	apiData: apiType | null;
	setApiData: Dispatch< SetStateAction< apiType | null > >;
	setNoticeValue: Dispatch< SetStateAction< noticeValueType > >;
	setNoticeMessage: Dispatch< SetStateAction< string > >;
	snackbarTimer: number;
};
