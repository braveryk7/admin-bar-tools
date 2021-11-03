import { useContext } from 'react';

import { RadioControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { apiContext } from '../..';
import { useSetApi } from '../../hooks/useSetApi';
import { apiType } from '../../types/apiType';

export const Radio = ( props: { itemKey: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { itemKey } = props;

	const changeValue = ( value: number ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		newItem.abt_sc = Number( value );
		setApiData( newItem );
	};

	useSetApi( itemKey, apiData.abt_sc! );

	return (
		<RadioControl
			selected={ apiData.abt_sc }
			options={ [
				{ label: __( "I don't use it.", 'admin-bar-tools' ), value: 0 },
				{ label: __( 'Domain', 'admin-bar-tools' ), value: 1 },
				{ label: __( 'URL Prefix', 'admin-bar-tools' ), value: 2 },
			] }
			onChange={ ( value: number ) => changeValue( value ) }
		/>
	);
};
