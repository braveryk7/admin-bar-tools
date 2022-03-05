import { CheckboxControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';
import { useChangeValue } from 'src/hooks/useChangeValue';
import { apiContext } from 'src/index';
import { itemKeyType, locationItemsType } from 'src/types/apiType';

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
