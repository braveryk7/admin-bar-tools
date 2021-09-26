import './scss/index.scss';

import { render } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { Checkbox } from './component/checkbox';

const AdminPage = () => {
	return (
		<div id="wrap">
			<h1>{ __( 'Admin Bar Tools Settings', 'admin-bar-tools' ) }</h1>
			<Checkbox />
		</div>
	);
};

render( <AdminPage />, document.getElementById( 'admin-bar-tools-settings' ) );
