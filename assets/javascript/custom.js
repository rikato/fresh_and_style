$(document).ready( function() {
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




    //getting the geolaction of a user
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Helaas ondersteund uw browser dit niet.");
        }
    }
    function showPosition(position) {
        window.location = "https://www.google.com/maps/dir/?api=1&origin="+position.coords.latitude+","+position.coords.longitude+"&destination=52.697959,6,6.190004";
    }

    $("a.get-location").on("click", function(e) {
        e.preventDefault();
        getLocation();

    });



    $("#txtEditor").Editor();

   $("#save-wysiwyg-form").on('click', function(){
       $('input.wysiwyg-value').attr('value', $("#txtEditor").Editor("getText"));
    })

    var getText = $(".wysiwyg-value-current").attr("data-value");
    $("#txtEditor").Editor("setText", getText);
});
