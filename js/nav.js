/**
 * The nav stuff
 */

(function( window ){
	
	'use strict';

	var body = document.body,
		mask = document.createElement("div"),
		toggleSlideTop = document.querySelector( ".toggle-slide-top" ),
		slideMenuTop = document.querySelector( ".slide-menu-top" ),
		activeNav
	;
	mask.className = "mask";


	/* slide menu top */
	toggleSlideTop.addEventListener( "click", function(){
		console.log('clicked');
		classie.add( body, "smt-open" );
		document.body.appendChild(mask);
		activeNav = "smt-open";
	} );

	/* hide active menu if mask is clicked */
	mask.addEventListener( "click", function(){
		classie.remove( body, activeNav );
		activeNav = "";
		document.body.removeChild(mask);
	} );

	/* hide active menu if close menu button is clicked */
	[].slice.call(document.querySelectorAll(".close-menu")).forEach(function(el,i){
		el.addEventListener( "click", function(){
			classie.remove( body, activeNav );
			activeNav = "";
			document.body.removeChild(mask);
		} );
	});


})( window );