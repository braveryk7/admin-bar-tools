import './scss/index.scss';

import { createContext, Dispatch, SetStateAction, useState } from 'react';

import { Placeholder, Spinner } from '@wordpress/components';
import { render } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { Checkbox } from './component/molecules/Checkbox';
import { Radio } from './component/molecules/Radio';
import { Items } from './component/organisms/Items';
import { useGetApi } from './hooks/useGetApi';
import { apiType } from './types/apiType';

export const apiContext = createContext(
	{} as {
		apiData: apiType;
		setApiData: Dispatch< SetStateAction< apiType > >;
	}
);

const AdminPage = () => {
	const [ apiData, setApiData ] = useState( {} );
	const [ apiStatus, setApiStatus ] = useState( false );

	useGetApi( setApiData, setApiStatus );

	return (
		<div id="wrap">
			<h1>{ __( 'Admin Bar Tools Settings', 'admin-bar-tools' ) }</h1>
			{ apiStatus ? (
				<apiContext.Provider value={ { apiData, setApiData } }>
					<Items
						title={ __(
							'Please select the items you want to display.',
							'admin-bar-tools'
						) }
						classValue="select-display"
					>
						<Checkbox itemKey="abt_status" />
					</Items>
					<Items
						title={ __(
							'Choose how you want to register with Google SearchConsole.',
							'admin-bar-tools'
						) }
						classValue="select-radio"
					>
						<Radio itemKey="abt_sc" />
					</Items>
				</apiContext.Provider>
			) : (
				<Placeholder label={ __( 'Data loading', 'admin-bar-tools' ) }>
					<Spinner />
				</Placeholder>
			) }
		</div>
	);
};

render( <AdminPage />, document.getElementById( 'admin-bar-tools-settings' ) );
