import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';
import { itemKeyType } from 'types/apiType';

import { apiContext } from '../..';
import { useChangeValue } from '../../hooks/useChangeValue';
import { psiLocales } from '../../utils/constant';

export const Select = memo( ( props: { itemKey: itemKeyType } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<SelectControl
			value={ apiData.locale }
			options={ Object.values( psiLocales ).map( ( locale ) => ( {
				label: locale.name,
				value: locale.id,
			} ) ) }
			onChange={ ( value ) => changeValue( value ) }
		/>
	);
} );
