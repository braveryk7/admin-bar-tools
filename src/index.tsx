import './scss/index.scss';

import { render } from '@wordpress/element';

import { Checkbox } from './component/checkbox';

const AdminPage = () => {
	return <Checkbox />;
};

render( <AdminPage />, document.getElementById( 'admin-bar-tools-settings' ) );
