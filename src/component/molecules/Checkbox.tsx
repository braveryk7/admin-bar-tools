import { CheckboxControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';

import { apiContext } from '../..';
import { useChangeValue } from '../../hooks/useChangeValue';
import { locationItemsType } from '../../types/apiType';

export const Checkbox = memo( ( props: { itemKey: string } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ Object.values( apiData.items ).map(
				( item: locationItemsType ) => (
					<CheckboxControl
						key={ item.shortname }
						label={ item.name }
						checked={ item.status }
						onChange={ () => changeValue( item.shortname ) }
					/>
				)
			) }
		</>
	);
} );
