import './bootstrap';
import { VueSetup } from "./collapsable";
import { ModalsVueSetup } from "./modal";

import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"

import { V_FormatTitle } from "@/utility";

createInertiaApp({
	resolve: name => {
		const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
		return pages[`./Pages/${name}.vue`];
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h( App, props ) })
			.use( plugin )
			.mixin( { methods: {
				route,
				V_FormatTitle,
				// V_FormatTitle: ( title ) => V_FormatTitle( title, page.props.app.name ),
			} } )
			.mount( el );

		VueSetup();
		ModalsVueSetup();
	},
});
