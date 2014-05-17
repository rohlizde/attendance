
// A $( document ).ready() block.
$(document).ready(function() {
    //flashes delay
    $('.flash').delay(2000).fadeOut();
    setHoverOn('[name="user"]', "#userBox");
});
function setHoverOn(main, window) {
    $(main).on({
        mouseenter: function() {
            clearTimeout($(this).data('timeoutId'));
            $(window).slideDown("fast");
        },
        mouseleave: function() {
            var someElement = $(main),
                    timeoutId = setTimeout(function() {
                        $(window).slideUp("fast");
                    }, 300);
            //set the timeoutId, allowing us to clear this trigger if the mouse comes back over
            someElement.data('timeoutId', timeoutId);
        }
    });
    $(window).on({
        mouseleave: function() {
            var someElement = $(main),
                    timeoutId = setTimeout(function() {
                        $(window).slideUp("fast");
                    }, 300);
            //set the timeoutId, allowing us to clear this trigger if the mouse comes back over
            someElement.data('timeoutId', timeoutId);
        },
        mouseenter: function() {
            clearTimeout($(main).data('timeoutId'));
            $(window).slideDown("fast");
        }
    });
    $('.dropdown').hover(function() {
        $('.dropdown-toggle', this).trigger('click');
    });
}
;