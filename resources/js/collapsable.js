function UpdateCollapsible( aLink, updateClasses )
{
	if ( aLink.href == undefined )
	{
		console.warning( `Invalid collapsible 1, link: ${aLink.href}.`, aLink );
		return;
	}

	let hTag = aLink.href.split("#");
	if ( hTag?.length != 2 )
	{
		console.warning( `Invalid collapsible 2, link: ${aLink.href}.`, aLink );
		return;
	}
	hTag = hTag[1];

	const collapsible = document.getElementById( hTag );
	if ( collapsible == undefined )
	{
		console.warning( `Collapsible not found, hTag: ${hTag}.`, aLink );
		return;
	}

	// Remove or add depending on tags present.
	let currentClasses = collapsible.classList;
	let isShowing = false;
	for ( let j = 0; j < currentClasses.length; j++ )
	{
		if ( currentClasses[j] == "show" )
		{
			isShowing = true;
			break;
		}
	}

	const rememberId = collapsible.dataset["remember"];
	let rememberLocalId = rememberId == undefined ? undefined : `remember_collapse_${rememberId}`;

	// On Page Load.
	if ( !updateClasses )
	{
		const rememberState = rememberLocalId != undefined
			? localStorage.getItem( rememberLocalId )
			: undefined;

		if ( rememberState != undefined )
		{
			rememberLocalId = undefined;
			isShowing = rememberState == "showing";
		}
		else
			isShowing = !isShowing;
	}

	if ( isShowing )
	{
		currentClasses.remove( "show" );
		collapsible.style.height = `0`;
	}
	else {
		currentClasses.add( "show" );
		collapsible.style.height = `${collapsible.scrollHeight}px`;
	}

	// Save state.
	if ( rememberLocalId != undefined )
		localStorage.setItem( rememberLocalId, isShowing ? "showing" : "hidden" );

	collapsible.classList = currentClasses;
}

function OnPageLoad()
{
	let collapsibleLinks = document.querySelectorAll(`[data-toggle="collapse"]`);
    for ( let i = 0; i < collapsibleLinks.length; i++ )
    {
    	const collapsibleHost = collapsibleLinks[i];
    	collapsibleHost.addEventListener("click", ( e ) => {
    		e.preventDefault();
    		const aLink = e.target;

			UpdateCollapsible( aLink, true );
    	});
    	UpdateCollapsible( collapsibleHost, false );
    }
}
OnPageLoad();

import { router } from '@inertiajs/vue3'
router.on( "finish", () => {
	// console.log("finish");
	OnPageLoad();
} );

export function VueSetup()
{
	OnPageLoad();
	// console.log("VueSetup");
}
