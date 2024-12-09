( function( $ ) {
$( document ).ready(function() {
$('#cssmenus').prepend('<div id="menu-button">Menu</div>');
	$('#cssmenus #menu-button').on('click', function(){
		var menu = $(this).next('ul');
		if (menu.hasClass('open')) {
			menu.removeClass('open');
		}
		else {
			menu.addClass('open');
		}
	});
});
} )( jQuery );

/* var $divs = $("div.srtbx");
$( document ).ready(function() {
    var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        return $(a).find('input[name=srt]').val() > $(b).find('input[name=srt]').val();
    });
    $("#srtdiv").html(alphabeticallyOrderedDivs);
});
*/
