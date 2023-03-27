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

		switch ( itemKey ) {
			case 'items':
				if ( typeof value === 'string' && isShortName( value ) ) {
					newItem.items[ value ].status = ! newItem.items[ value ].status;
				}
				break;
			case 'locale':
				if ( typeof value === 'string' ) {
					const url = 'https://developers.google.com/speed/pagespeed/insights/?hl=';
					const psiUrl = {
						url: `${ url }${ value }&url=`,
						adminurl: `${ url }${ value }`,
					};
					newItem.items.psi.url = psiUrl.url;
					newItem.items.psi.adminurl = psiUrl.adminurl;
					newItem.locale = value;
				}
				break;
			case 'sc':
				if ( typeof value === 'number' ) {
					newItem.sc = value;
				}
				break;
			case 'theme_support':
				if ( typeof value === 'boolean' ) {
					newItem.theme_support = value;
				}
				break;
			default:
				break;
		}

		setApiData( newItem );
	};

	useSetApi( itemKey, apiData );

	return changeValue;
};
