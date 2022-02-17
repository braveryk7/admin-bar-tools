import { apiType, locationItemsType, locationsType } from '../types/apiType';

export const getApiInitValue = () => {
	const locationItems: locationItemsType = {
		name: '',
		shortname: 'psi',
		status: false,
		url: '',
		admin: '',
		order: 0,
	};

	const locations: locationsType = {
		psi: { ...locationItems },
		lh: { ...locationItems },
		gsc: { ...locationItems },
		gc: { ...locationItems },
		gi: { ...locationItems },
		bi: { ...locationItems },
		twitter: { ...locationItems },
		facebook: { ...locationItems },
		hatena: { ...locationItems },
	};

	const abtOptions: apiType = {
		abt_options: {
			items: { ...locations },
			locale: '',
			sc: 0,
			version: 0,
		},
	};

	return abtOptions;
};
