//// adds a new message to the flash messenger
function addMessage(message) {
    var flash = $('.flash');
    if (flash.is(":visible")) {
        flash.html(message);
    } else {
        flash = $('<div></div>', {
            "class": "flash",
            text: message,
            "css" : {
                "display" : "none"
            }
        }).prependTo('body').slideDown("slow");
    }
    flash.setRemoveTimeout(5000);
}

var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

//
//String.prototype.lowerize = function () {
//    return this.charAt(0).toLowerCase() + this.slice(1);
//};
//
//String.prototype.capitalize = function () {
//    return this.charAt(0).toUpperCase() + this.slice(1);
//};
//


//
//function empty(variable) {
//    if (variable == "" || variable == null || typeof variable === 'undefined') {
//        return true;
//    } else {
//        return false;
//    }
//}
//


//// mini plugin that will hide an element according to the timout given
(function ($) {
    $.fn.setRemoveTimeout = function (milisecs) {
        var element = $(this);
        if (element.length > 0) {
            setTimeout(function () {
                $(element).slideUp("slow",function(){
                    $(this).detach();
                });
            }, milisecs);
        }
        return element;
    };
})(jQuery);
//
//// plugin that will show or hide the loading image
//(function ($) {
//    $.fn.toggleLoadingImage = function () {
//        var element = $(this);
//        // we use .find for more secure results
//        var loadingImg = element.children('.loadingImg');
//        if (loadingImg.length > 0) {
//            loadingImg.detach();
//        } else {
//            $('<div />', {'class': 'loadingImg'}).appendTo(element);
//        }
//    };
//})(jQuery);
//
// "turn off" the lights and focus the specific element
(function ($) {
    $.fn.focusLight = function () {
        // set the default value for focusedDiv
        var element = $(this);
        //focusedDiv = typeof focusedDiv !== 'undefined' ? $(focusedDiv) : $(this);

        // add the shadow to the body
        $('<div />', {'id': 'shadow'}).appendTo('body');

        element.addClass('focused');

        return element;
    };
})(jQuery);

// "turn on" the lights
(function ($) {
    $.fn.unfocusLight = function () {
        var element = $(this);
        $('#shadow').detach();
        element.removeClass('focused');

        return element;
    };
})(jQuery);
//
//// creates a date only datetimepicker
//(function ($) {
//    $.fn.datePicker = function () {
//        // set the default value for focusedDiv
//        var element = $(this);
//        // add the shadow to the body
//        element.datetimepicker({
//            timepicker: false,
//            format: 'd-m-Y',
//            formatDate: 'd-m-Y',
//            closeOnDateSelect: true,
//            lang: 'el'
//        });
//
//        return element;
//    };
//})(jQuery);
//
//// creates a time only datetimepicker
//(function ($) {
//    $.fn.timePicker = function () {
//        // set the default value for focusedDiv
//        var element = $(this);
//        // add the shadow to the body
//        element.datetimepicker({
//            datepicker: false,
//            format: 'H:i',
//            closeOnDateSelect: true,
//            lang: 'el'
//        });
//
//        return element;
//    };
//})(jQuery);
//
//// create a default localized datetimepicker
//(function ($) {
//    $.fn.elDateTimePicker = function () {
//        // set the default value for focusedDiv
//        var element = $(this);
//        // add the shadow to the body
//        element.datetimepicker({
//            closeOnTimeSelect: true,
//            lang: 'el'
//        });
//
//        return element;
//    };
//})(jQuery);
//
