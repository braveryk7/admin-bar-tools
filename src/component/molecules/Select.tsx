import { SelectControl } from '@wordpress/components';
import { memo, useContext } from '@wordpress/element';
import { psiLocalesType } from 'types/LocaleType';

import { apiContext } from '../..';
import { useChangeValue } from '../../hooks/useChangeValue';
import { psiLocales } from '../../lib/locale';

export const Select = memo( ( props: { itemKey: string } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<SelectControl
			value={ apiData.locale }
			options={ Object.values( psiLocales ).map( ( locale: psiLocalesType ) => ( {
				label: locale.name,
				value: locale.id,
			} ) ) }
			onChange={ ( value ) => changeValue( value ) }
		/>
	);
} );
