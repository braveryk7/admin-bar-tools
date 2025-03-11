import 'src/scss/index.scss';

import locales from '../common/locales.json';

import { ExternalLink, Snackbar, Spinner } from '@wordpress/components';
import { createContext, useEffect, useState, createRoot } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { ApiError } from 'src/components/atoms/ApiError';
import { Checkbox } from 'src/components/atoms/Checkbox';
import { Radio } from 'src/components/atoms/Radio';
import { Select } from 'src/components/atoms/Select';
import { Items } from 'src/components/molecules/Items';
import { useGetApi } from 'src/hooks/useGetApi';

import { apiType } from 'src/types/apiType';
import { apiContextType, noticeValueType } from 'src/types/useContextType';

export const apiContext = createContext( {} as apiContextType );

const AdminPage = () => {
	const [ apiData, setApiData ] = useState< apiType | undefined >( undefined );
	const [ apiError, setApiError ] = useState( false );
	const [ noticeValue, setNoticeValue ] = useState< noticeValueType | undefined >( undefined );
	const [ noticeMessage, setNoticeMessage ] = useState( '' );
	const [ snackbarTimer, setSnackbarTimer ] = useState( 0 );

	useGetApi( setApiData, setApiError );

	useEffect( () => {
		if ( noticeValue ) {
			setSnackbarTimer(
				window.setTimeout( () => {
					setNoticeValue( undefined );
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
			{ apiData && (
				<apiContext.Provider
					value={ {
						apiData,
						setApiData,
						setApiError,
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
							'Please select whether you want to use the Theme Support.',
							'admin-bar-tools'
						) }
						classValue="select-display"
					>
						<Checkbox itemKey="theme_support" />
					</Items>
					<p>
						{ __(
						// eslint-disable-next-line
						'Links to the official WordPress theme site, manuals, and user forums will be displayed.',
							'admin-bar-tools'
						) }
					</p>
					<p>
						{ __(
							'List of eligible WordPress themes.',
							'admin-bar-tools'
						) }
					</p>
					<ul>
						<li>
							<ExternalLink href="https://wp-cocoon.com/">Cocoon</ExternalLink>
						</li>
						<li>
							<ExternalLink href="https://jin-theme.com/">JIN</ExternalLink>
						</li>
						<li>
							<ExternalLink href="https://jinr.jp/">JIN:R</ExternalLink>
						</li>
						<li>
							<ExternalLink href="https://saruwakakun.design/">SANGO</ExternalLink>
						</li>
						<li>
							<ExternalLink href="https://the-sonic.jp/">THE SONIC</ExternalLink>
						</li>
					</ul>
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
						<Select itemKey="locale" locales={ locales } />
					</Items>
				</apiContext.Provider>
			) }
			{ ! apiData && ! apiError && <Spinner /> }
			{ apiError && <ApiError /> }
		</div>
	);
};

const rootElement = document.getElementById( 'admin-bar-tools-settings' );
if ( rootElement ) {
	const root = createRoot( rootElement );
	root.render( <AdminPage /> );
}

