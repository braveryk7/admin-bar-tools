import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';

import { apiContext } from '../..';
import { useSetApi } from '../../hooks/useSetApi';
import { psiLocales } from '../../lib/locale';
import { apiType } from '../../types/apiType';

export const Select = memo( ( props: { itemKey: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { itemKey } = props;

	const changeLocale = ( value: string ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		newItem.abt_options.locale = value;
		setApiData( newItem );
	};

	useSetApi( itemKey, apiData.abt_options );

	return (
		<SelectControl
			value={ apiData.abt_options.locale }
			options={ Object.values( psiLocales ).map( ( locale: any ) => ( {
				label: locale.name,
				value: locale.id,
			} ) ) }
			onChange={ ( value ) => changeLocale( value ) }
		/>
	);
} );
