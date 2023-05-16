import { useContext } from '@wordpress/element';

import { useSetApi } from 'src/hooks/useSetApi';
import { apiContext } from 'src/index';
import { shortNameList } from 'src/utils/constant';

import { apiType, itemKeyType, shortNameType } from 'src/types/apiType';

export const useChangeValue = ( itemKey: itemKeyType ) => {
	const { apiData, setApiData } = useContext( apiContext );

	const changeValue = ( value: string | number | boolean ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		const isShortName = ( shortName: string ): shortName is shortNameType => {
			return shortNameList.includes( shortName as shortNameType );
		};

		if ( 'items' === itemKey && typeof value === 'string' && isShortName( value ) ) {
			newItem.items[ value ].status = ! newItem.items[ value ].status;
		} else if ( 'locale' === itemKey && typeof value === 'string' ) {
			const url = 'https://developers.google.com/speed/pagespeed/insights/?hl=';
			const psiUrl = {
				url: `${ url }${ value }&url=`,
				adminurl: `${ url }${ value }`,
			};
			newItem.items.psi.url = psiUrl.url;
			newItem.items.psi.adminurl = psiUrl.adminurl;
			newItem.locale = value;
		} else if ( 'sc' === itemKey && typeof value === 'number' ) {
			newItem.sc = value;
		} else if ( 'theme_support' === itemKey && typeof value === 'boolean' ) {
			newItem.theme_support = value;
		}

		setApiData( newItem );
	};

	useSetApi( itemKey, apiData );

	return changeValue;
};
