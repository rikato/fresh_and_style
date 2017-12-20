$(document).ready( function() {
    //Sets the three form options for an appointment at home to not be shown at default.
    var appointmentOpen = false;
    //If the box for an appointment at home is checked, adds the class show to the inputs so they are visible and ads the required property to the fields.
    $("#aanHuis").on("click", function (){
        if(appointmentOpen === false){
            $(".afspraak-container").addClass("show");
            $(".afspraak-container input, .afspraak-container textarea").prop("required", true);
            appointmentOpen = true;
        }
        //If the box is unchecked removes the show class and required property from the inputs.
        else{
            $(".afspraak-container").removeClass("show");
            $(".afspraak-container input, .afspraak-container textarea").prop("required", false);
            appointmentOpen = false;
        }

    });
    if(window.location.hash) {
        var hash = window.location.hash;
        $(hash).modal('toggle');
    }

    // Makes the carousel auto rotate every 6 seconds
    $('.multi-item-carousel').carousel({
        interval: 600000
    });


    // For every slide in carousel, copy the next slide's picture in the slide.
    // Do this over for every cycle.
    // for every slide in carousel, copy the next slide's item in the slide.
    // Do the same for the next, next item.
    // $('.multi-item-carousel .item').each(function(){
    //     var next = $(this).next();
    //     if (!next.length) {
    //         next = $(this).siblings(':first');
    //     }
    //     next.children(':first-child').clone().appendTo($(this));
    //
    //     if (next.next().length>0) {
    //         next.next().children(':first-child').clone().appendTo($(this));
    //     } else {
    //         $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    //     }
    // });




    //getting the geolaction of a user
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Helaas ondersteund uw browser dit niet.");
        }
    }
    function showPosition(position) {
        window.location = "https://www.google.com/maps/dir/?api=1&origin="+position.coords.latitude+","+position.coords.longitude+"&destination=52.697959,6.190004";
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
