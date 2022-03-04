import { useContext } from '@wordpress/element';
import { apiType, itemKeyType, shortNameType } from 'types/apiType';

import { apiContext } from '../';
import { shortNameList } from '../utils/constant';
import { useSetApi } from './useSetApi';

export const useChangeValue = ( itemKey: itemKeyType ) => {
	const { apiData, setApiData } = useContext( apiContext );

	const changeValue = ( value: string | number ) => {
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
			default:
				break;
		}

		setApiData( newItem );
	};

	useSetApi( itemKey, apiData );

	return changeValue;
};
