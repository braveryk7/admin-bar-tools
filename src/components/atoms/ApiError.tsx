import { Panel, PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export const ApiError = () => {
	const messageList = [
		__( 'Admin Bar Toolsは、設定読み込みにWordPress REST APIを使用しています。', 'admin-bar-tools' ),
		__( 'もしこのエラーが続けて表示される場合は、WordPress REST APIが無効化されている可能性があります。', 'admin-bar-tools' ),
		__( 'WordPress REST APIはプラグインやテーマのfunctions.phpファイルで設定することができます。', 'admin-bar-tools' ),
		__( 'WordPress REST APIを有効化して再度アクセスしてください。', 'admin-bar-tools' ),
	];
	return (
		<Panel header={ __( 'API接続に失敗しました。', 'admin-bar-tools' ) } >
			<PanelBody>
				{ messageList.map( ( message, index ) => (
					<PanelRow key={ index }>{ message }</PanelRow>
				) ) }
			</PanelBody>
		</Panel>
	);
};
