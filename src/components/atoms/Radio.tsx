import { RadioControl } from '@wordpress/components';
import { useContext } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useChangeValue } from 'src/hooks/useChangeValue';
import { apiContext } from 'src/index';

import { itemKeyType } from 'src/types/apiType';

export const Radio = ( props: { itemKey: itemKeyType } ) => {
	const { apiData } = useContext( apiContext );
	const { itemKey } = props;
	const changeValue = useChangeValue( itemKey );

	return (
		<>
			{ apiData && <RadioControl
				selected={ String( apiData.sc ) }
				options={ [
					{ label: __( "I don't use it.", 'admin-bar-tools' ), value: '0' },
					{ label: __( 'Domain', 'admin-bar-tools' ), value: '1' },
					{ label: __( 'URL Prefix', 'admin-bar-tools' ), value: '2' },
				] }
				onChange={ ( value ) => changeValue( Number( value ) ) }
			/> }
		</>
	);
};
