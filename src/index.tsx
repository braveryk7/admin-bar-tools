import 'src/scss/index.scss';

import { Placeholder, Snackbar, Spinner } from '@wordpress/components';
import { createContext, useEffect, useState, render } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { Checkbox } from 'src/components/atoms/Checkbox';
import { Radio } from 'src/components/atoms/Radio';
import { Select } from 'src/components/atoms/Select';
import { Items } from 'src/components/molecules/Items';
import { useGetApi } from 'src/hooks/useGetApi';

import { apiType } from 'src/types/apiType';
import { apiContextType, noticeValueType } from 'src/types/useContextType';

export const apiContext = createContext( {} as apiContextType );

const AdminPage = () => {
	const [ apiData, setApiData ] = useState< apiType | null >( null );
	const [ noticeValue, setNoticeValue ] = useState< noticeValueType >( null );
	const [ noticeMessage, setNoticeMessage ] = useState( '' );
	const [ snackbarTimer, setSnackbarTimer ] = useState( 0 );

	useGetApi( setApiData );

	useEffect( () => {
		if ( noticeValue ) {
			setSnackbarTimer(
				window.setTimeout( () => {
					setNoticeValue( null );
				}, 4000 )
			);
		}
	}, [ noticeValue ] );

	return (
		<div id="wrap">
			<h1>{ __( 'Admin Bar Tools Settings', 'admin-bar-tools' ) }</h1>
			{ noticeValue && (
				<Snackbar className={ noticeValue }>{ noticeMessage }</Snackbar>
			) }
			{ apiData ? (
				<apiContext.Provider
					value={ {
						apiData,
						setApiData,
						setNoticeValue,
						setNoticeMessage,
						snackbarTimer,
					} }
				>
					<Items
						title={ __(
							'Please select the items you want to display.',
							'admin-bar-tools'
						) }
						classValue="select-display"
					>
						<Checkbox itemKey="items" />
					</Items>
					<Items
						title={ __(
							'Choose how you want to register with Google SearchConsole.',
							'admin-bar-tools'
						) }
						classValue="select-radio"
					>
						<Radio itemKey="sc" />
					</Items>
					<Items
						title={ __(
							'Please set the location.',
							'admin-bar-tools'
						) }
						classValue="select-location"
					>
						<Select itemKey="locale" />
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
