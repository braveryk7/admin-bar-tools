import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';

import { useChangeValue } from 'src/hooks/useChangeValue';
import { apiContext } from 'src/index';

import { itemKeyType } from 'src/types/apiType';

export const Select = memo( ( props: { itemKey: itemKeyType, locales?: object } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey, locales } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ apiData && locales && <SelectControl
				value={ apiData.locale }
				options={ Object.values( locales ).map( ( locale ) => ( {
					label: locale.name,
					value: locale.id,
				} ) ) }
				onChange={ ( value ) => changeValue( value ) }
			/>
			}
		</>
	);
} );
