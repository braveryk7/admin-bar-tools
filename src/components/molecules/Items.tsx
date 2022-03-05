import { ItemsPropsType } from '../../types/ComponentsType';

export const Items = ( props: ItemsPropsType ) => {
	const { classValue, title, children } = props;

	return (
		<div className={ 'abt-item-wrapper ' + classValue }>
			<h2>{ title }</h2>
			{ children }
		</div>
	);
};
