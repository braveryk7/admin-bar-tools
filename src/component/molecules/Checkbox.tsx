import { memo, useContext } from 'react';

// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { CheckboxControl } from '@wordpress/components';

import { apiContext } from '../..';
import { useSetApi } from '../../hooks/useSetApi';
import { ItemType, shortNameType } from '../../types/CheckboxType';
import { apiType } from '../../types/apiType';

export const Checkbox = memo( ( props: { itemKey: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { itemKey } = props;

	const changeStatus = ( shortname: shortNameType ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		newItem.abt_status![ shortname ]!.status = ! newItem.abt_status![
			shortname
		]!.status;
		setApiData( newItem );
	};

	useSetApi( itemKey, apiData.abt_status! );

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
