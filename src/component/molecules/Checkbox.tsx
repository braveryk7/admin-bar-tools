import { CheckboxControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';

import { apiContext } from '../..';
import { useSetApi } from '../../hooks/useSetApi';
import { apiType, locationItemsType, shortNameType } from '../../types/apiType';

export const Checkbox = memo( ( props: { itemKey: string } ) => {
	const { apiData, setApiData } = useContext( apiContext );
	const { itemKey } = props;

	const changeStatus = ( shortname: shortNameType ) => {
		const newItem: apiType = JSON.parse( JSON.stringify( { ...apiData } ) );

		newItem.abt_options.items[ shortname ].status = ! newItem.abt_options
			.items[ shortname ].status;
		setApiData( newItem );
	};

	useSetApi( itemKey, apiData.abt_options );

	return (
		<>
			{ Object.values( apiData.abt_options.items ).map(
				( item: locationItemsType ) => (
					<CheckboxControl
						key={ item.shortname }
						label={ item.name }
						checked={ item.status }
						onChange={ () => changeStatus( item.shortname ) }
					/>
				)
			) }
		</>
	);
} );
