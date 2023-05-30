
// Vue only.
import { router } from "@inertiajs/core";

export function V_FormatTitle( title )
{
	if ( title === null )
		return router.page.props.app.name;
	return `${title} - ${router.page.props.app.name}`;
}

export function ToUpperFirstChar( str )
{
	return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
}

export function Namespaceify( str )
{
	const splitName = str.split( /[ _]/ ); // Split on space or underscore.
	if ( splitName.length === 1 )
		return ToUpperFirstChar( str );

	let namespace = ToUpperFirstChar( splitName[ 0 ] );
	for ( let i = 1; i < splitName.length; i++ )
	{
		namespace += "_" + ToUpperFirstChar( splitName[ i ] );
	}

	return namespace;
}
