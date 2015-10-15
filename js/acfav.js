/* acfav.js
Part of Accessible Video plugin
FAQ open/close slider, based on http://www.designonslaught.com/a-simple-jquery-faq-style-show-and-hide/ */

(function($) {

	var element_to_toggle = '.acfav-toggle';
	var element_to_click  = '.acfav-toggle-link';

    $(element_to_toggle).hide();
    $(element_to_click).click(function () {
        $(this).next(element_to_toggle).slideToggle(400);
    });

})( jQuery );
