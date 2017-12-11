$("#aanHuis").on("click", function (){
    $(".afspraak-container").toggleClass("show");
});
if(window.location.hash) {
    var hash = window.location.hash;
    $(hash).modal('toggle');
}

// Instantiate the Bootstrap carousel
$('.multi-item-carousel').carousel({
    interval: 6000

});

// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
$('.multi-item-carousel .item').each(function(){
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    if (next.next().length>0) {
        next.next().children(':first-child').clone().appendTo($(this));
    } else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
});


$(document).ready( function() {

    $("#txtEditor").Editor();

   $("#save-wysiwyg-form").on('click', function(){
       $('input.wysiwyg-value').attr('value', $("#txtEditor").Editor("getText"));
    })

    var getText = $(".wysiwyg-value-current").attr("value");
    $("#txtEditor").Editor("setText", getText)

});
