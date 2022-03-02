import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';
import { psiLocalesType } from 'types/LocaleType';

import { apiContext } from '../..';
import { useSetApi } from '../../hooks/useSetApi';
import { psiLocales } from '../../lib/locale';
import { apiType } from '../../types/apiType';

export const Select = memo( ( props: { itemKey: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { itemKey } = props;

	const changeLocale = ( value: string ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		const psiUrl = {
			url: `https://developers.google.com/speed/pagespeed/insights/?hl=${ value }&url=`,
			adminurl: `https://developers.google.com/speed/pagespeed/insights/?hl=${ value }`,
		};
		newItem.abt_options.items.psi.url = psiUrl.url;
		newItem.abt_options.items.psi.adminurl = psiUrl.adminurl;
		newItem.abt_options.locale = value;
		setApiData( newItem );
	};

	useSetApi( itemKey, apiData.abt_options );

	return (
		<SelectControl
			value={ apiData.abt_options.locale }
			options={ Object.values( psiLocales ).map( ( locale: psiLocalesType ) => ( {
				label: locale.name,
				value: locale.id,
			} ) ) }
			onChange={ ( value ) => changeLocale( value ) }
		/>
	);
} );
