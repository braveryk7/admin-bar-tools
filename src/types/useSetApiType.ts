import { ItemsWrapperType, ItemType } from './CheckboxType';

export type useSetApiType = {
	(
		itemKey: string,
		value: ItemsWrapperType< ItemType > | string | number
	): void;
};
