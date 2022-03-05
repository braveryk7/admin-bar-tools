import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';

import { useChangeValue } from 'src/hooks/useChangeValue';
import { apiContext } from 'src/index';
import { psiLocales } from 'src/utils/constant';

import { itemKeyType } from 'src/types/apiType';

export const Select = memo( ( props: { itemKey: itemKeyType } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ apiData && <SelectControl
				value={ apiData.locale }
				options={ Object.values( psiLocales ).map( ( locale ) => ( {
					label: locale.name,
					value: locale.id,
				} ) ) }
				onChange={ ( value ) => changeValue( value ) }
			/>
			}
		</>
	);
} );
