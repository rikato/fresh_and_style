$("#aanHuis").on("click", function (){
    $(".afspraak-container").toggleClass("show");
});
if(window.location.hash) {
    var hash = window.location.hash;
    $(hash).modal('toggle');
}