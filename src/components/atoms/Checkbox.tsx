import { CheckboxControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';
import { itemKeyType, locationItemsType } from 'types/apiType';

import { apiContext } from '../..';
import { useChangeValue } from '../../hooks/useChangeValue';

export const Checkbox = memo( ( props: { itemKey: itemKeyType } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ apiData &&
				Object.values( apiData.items ).map(
					( item: locationItemsType ) => (
						<CheckboxControl
							key={ item.shortname }
							label={ item.name }
							checked={ item.status }
							onChange={ () => changeValue( item.shortname ) }
						/>
					)
				)
			}
		</>
	);
} );
