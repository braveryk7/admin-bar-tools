import { RadioControl } from '@wordpress/components';
import { useContext } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { itemKeyType } from 'types/apiType';

import { apiContext } from '../..';
import { useChangeValue } from '../../hooks/useChangeValue';

export const Radio = ( props: { itemKey: itemKeyType } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ apiData && <RadioControl
				selected={ apiData.sc }
				options={ [
					{ label: __( "I don't use it.", 'admin-bar-tools' ), value: 0 },
					{ label: __( 'Domain', 'admin-bar-tools' ), value: 1 },
					{ label: __( 'URL Prefix', 'admin-bar-tools' ), value: 2 },
				] }
				onChange={ ( value: number ) => changeValue( Number( value ) ) }
			/> }
		</>
	);
};
