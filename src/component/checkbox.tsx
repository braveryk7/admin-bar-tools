import { memo, useContext } from 'react';

// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { apiContext } from '..';
import { useSetApi } from '../hooks/useSetApi';
import { apiType } from '../types/apiType';
import { ItemType, shortNameType } from '../types/checkboxType';

export const Checkbox = memo( ( props: { id: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { id } = props;

	const changeStatus = ( shortname: shortNameType ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		newItem.abt_status![ shortname ]!.status = ! newItem.abt_status![
			shortname
		]!.status;
		setApiData( newItem );
	};

	useSetApi( apiData.abt_status!, id );

	return (
		<>
			{ Object.values( apiData.abt_status! ).map( ( item: ItemType ) => (
				<CheckboxControl
					key={ item.shortname }
					label={ item.name }
					checked={ item.status }
					onChange={ () => changeStatus( item.shortname ) }
				/>
			) ) }
		</>
	);
} );
