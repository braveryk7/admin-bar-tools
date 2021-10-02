import './scss/index.scss';

import { createContext, useState } from 'react';

import { Placeholder, Snackbar, Spinner } from '@wordpress/components';
import { render } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { Checkbox } from './component/molecules/Checkbox';
import { Radio } from './component/molecules/Radio';
import { Items } from './component/organisms/Items';
import { useGetApi } from './hooks/useGetApi';
import { apiContextType, noticeValueType } from './types/useContextType';

export const apiContext = createContext( {} as apiContextType );

const AdminPage = () => {
	const [ apiData, setApiData ] = useState( {} );
	const [ apiStatus, setApiStatus ] = useState( false );
	const [ noticeStatus, setNoticeStatus ] = useState( false );
	const [ noticeValue, setNoticeValue ] = useState(
		undefined as noticeValueType
	);
	const [ noticeMessage, setNoticeMessage ] = useState( '' );

	useGetApi( setApiData, setApiStatus );

	if ( noticeStatus ) {
		setTimeout( () => {
			setNoticeStatus( false );
		}, 4000 );
	}

	return (
		<div id="wrap">
			<h1>{ __( 'Admin Bar Tools Settings', 'admin-bar-tools' ) }</h1>
			{ noticeStatus && (
				<Snackbar className={ noticeValue }>{ noticeMessage }</Snackbar>
			) }
			{ apiStatus ? (
				<apiContext.Provider
					value={ {
						apiData,
						setApiData,
						setNoticeStatus,
						setNoticeValue,
						setNoticeMessage,
					} }
				>
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
