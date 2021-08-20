(function($) {

    var cells = $('.expandable__cell');

    cells.find('.item--basic').click(function(e) {
        var thisCell = $(this).closest('.expandable__cell');

        if (thisCell.hasClass('is--collapsed')) {
            $(cells).not(thisCell).removeClass('is--expanded').addClass('is--collapsed');
            thisCell.removeClass('is--collapsed').addClass('is--expanded');
            hash = $(thisCell).attr('id');
            history.pushState(null, null, window.location.protocol +'//'+ window.location.host + window.location.pathname + '#' + hash);
            $('html, body').animate({
                scrollTop: ($('#' + hash).offset().top -130)
            });
        } else {
            thisCell.removeClass('is--expanded').addClass('is--collapsed');
        }
    });

    $(".expand__close").on("click",function(e){
        var thisCell = $(this).closest('.expandable__cell');
        thisCell.removeClass('is--expanded').addClass('is--collapsed');
    });

    $(document).ready(function() {
        var hash = window.location.hash.substring(1);

        if (hash.length && isNaN(parseFloat(hash))) {
            $('#' + hash).removeClass("is--collapsed").addClass("is--expanded");
            $('html, body').animate({
                scrollTop: ($('#' + hash).offset().top -130)
            });
        }
    });

})(jQuery);
