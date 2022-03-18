import { Panel, PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export const ApiError = () => {
	const messageList = [
		__( 'Admin Bar Tools uses the WordPress REST API for setting loading.', 'admin-bar-tools' ),
		__(
			'If you continue to see this error, the WordPress REST API may be disabled.',
			'admin-bar-tools'
		),
		__(
			// eslint-disable-next-line
			"The WordPress REST API can be set up in a plugin or in your theme's functions.php file.",
			'admin-bar-tools'
		),
		__(
			'Please activate the WordPress REST API and try accessing it again.',
			'admin-bar-tools'
		),
	];
	return (
		<Panel header={ __( 'API connection failed.', 'admin-bar-tools' ) } >
			<PanelBody>
				{ messageList.map( ( message, index ) => (
					<PanelRow key={ index }>{ message }</PanelRow>
				) ) }
			</PanelBody>
		</Panel>
	);
};
