import { useEffect, useState } from 'react';

// @ts-ignore
import api from '@wordpress/api'; // eslint-disable-line
import { CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import {
	ItemsWrapperType,
	ItemType,
	shortNameType,
	WPApiType,
} from '../types/checkboxType';

export const Checkbox = () => {
	const [ itemData, setItemData ] = useState< ItemsWrapperType< ItemType > >(
		{}
	);

	const changeStatus = ( shortname: shortNameType ) => {
		const newItem = { ...itemData };

		if ( newItem[ shortname ]!.status ) {
			newItem[ shortname ]!.status = false;
		} else {
			newItem[ shortname ]!.status = true;
		}
		setItemData( newItem );
	};

	useEffect( () => {
		api.loadPromise.then( () => {
			const model = new api.models.Settings();

			model.fetch().then( ( res: WPApiType< ItemType > ) => {
				setItemData( res.abt_status! );
			} );
		} );
	}, [ setItemData ] );

	api.loadPromise.then( () => {
		const model = new api.models.Settings( {
			abt_status: itemData,
		} );
		const save = model.save();

		save.success( () => {} );
		save.error( () => {} );
	} );

	return (
		<div className="wrap">
			<h1>{ __( 'Admin Bar Tools Settings', 'admin-bar-tools' ) }</h1>
			{ Object.values( itemData ).map( ( item: ItemType ) => (
				<CheckboxControl
					key={ item.shortname }
					label={ item.name }
					checked={ item.status }
					onChange={ () => changeStatus( item.shortname ) }
				/>
			) ) }
		</div>
	);
};
