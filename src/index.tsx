import './scss/index.scss';

import { render } from '@wordpress/element';

import { Checkbox } from './component/checkbox';

const AdminPage = () => {
	return (
		<div id="wrap">
			<Checkbox />
		</div>
	);
};

render( <AdminPage />, document.getElementById( 'admin-bar-tools-settings' ) );
