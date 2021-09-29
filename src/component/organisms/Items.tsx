import { ItemsPropsType } from '../../types/ItemsType';

export const Items = ( props: ItemsPropsType ) => {
	const { classValue, title, children } = props;

	return (
		<div className={ 'abt-item-wrapper ' + classValue }>
			<h2>{ title }</h2>
			{ children }
		</div>
	);
};
