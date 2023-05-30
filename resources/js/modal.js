import { FindParent } from "./utility.js";

const closeSelector = `[data-dismiss="modal"]`;
const modalOpenersSelector = `[data-toggle="modal"]`;

function SetupOpeners()
{
	const openers = document.querySelectorAll( modalOpenersSelector );
	for ( let i = 0; i < openers.length; i++ )
	{
		const opener = openers[i];
		let targetId = opener.dataset["target"];
		if ( targetId.indexOf( "#" ) !== 0 || targetId.length <= 1 )
			continue;

		targetId = targetId.substring( 1 );

		opener.addEventListener( "click", ( e ) => {
			e.preventDefault();
			const target = document.getElementById( targetId );
			if ( target == null )
				return;

			target["modal"]( "show" );
		});
	}
}

function SetupClosers()
{
	const closers = document.querySelectorAll( closeSelector );
	for ( let i = 0; i < closers.length; i++ )
	{
		const closer = closers[i];
		closer.addEventListener( "click", ( e ) => {
			e.preventDefault();
			const modal
				= FindParent( e.target, ( element ) => element.classList.contains( "modal" ) );

			if ( modal == null )
				return;

			modal["modal"]( "hide" );
		});
	}
}

function SetupBackgroundClosers()
{
	const modals = document.querySelectorAll( ".modal" );
	for ( let i = 0; i < modals.length; i++ )
	{
		const modal = modals[i];
		modal.addEventListener( "click", ( e ) => {
			if ( e.target !== modal )
				return;

			modal["modal"]( "hide" );
		});
	}
}

function SetupModal( modalElement )
{
	modalElement["modal"] = function( action )
	{
		if ( action !== "show" && action !== "hide" )
			throw new Error( "Invalid modal action." );

		const toShow = action == "show";
		const isShowing = this.classList.contains( "show" );
		if ( toShow == isShowing )
			return;

		if ( toShow )
		{
			this.style.display = "";
			setTimeout( () => { this.classList.add( "show" ) }, 0 );
		}
		else
			this.classList.remove( "show" );
	};

	// Update Visibility.
	const dialog = modalElement.querySelector( ".modal-dialog" );
	dialog.addEventListener( "transitionend", ( event ) =>
	{
		const isGoingToBeShown = modalElement.classList.contains( "show" );
		if ( !isGoingToBeShown )
			modalElement.style.display = "none";
	});

	dialog.addEventListener( "transitionstart", ( event ) =>
	{
		const isGoingToBeShown = modalElement.classList.contains( "show" );
		if ( isGoingToBeShown )
			modalElement.style.display = "flex";
	});

	// Transition if the modal is already visible.
	if ( modalElement.classList.contains( "show" ) )
	{
		modalElement.classList.remove( "show" );
		dialog.style.transition = "none";
		setTimeout( () => {
			dialog.style.transition = "";
			modalElement["modal"]( "show" );
		}, 0 );
	}
}

function SetupModals()
{
	const modals = document.querySelectorAll( ".modal" );
	for ( let i = 0; i < modals.length; i++ )
	{
		const modal = modals[i];
		SetupModal( modal );
	}

	SetupOpeners();
	SetupClosers();
	SetupBackgroundClosers();
}

export function ModalsVueSetup()
{
	SetupModals();
}

import { router } from '@inertiajs/vue3'
router.on( "finish", () => {
	SetupModals();
} );

SetupModals();
