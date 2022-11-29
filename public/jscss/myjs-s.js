$(document).ready((function() {
    var e;

    function t() {
        clearInterval(e)
    }
    e = setInterval((function() {
        $(".gsc-resultsbox-visible").length && (
            $(".gsc-resultsbox-visible").find(".gs-webResult").length ? (
                $(".search-noresults").hide(), t()) : 
            $(".gsc-resultsbox-visible").find(".gs-snippet").length && 
            $(".gsc-resultsbox-visible").find(".gs-snippet").each((function() {
            "No Results" == $(this).html() && (
                $(".search-noresults").show(),
                $("#___gcse_0").hide(),
                t())
        })))
    }), 2e3)
})),
$(document).on("click", ".gsc-expansionArea .gsc-imageResult.gsc-imageResult-popup.gsc-result", (function(e) {
    let t = $(this).find(".gs-previewLink").attr("href");
    window.location.href = t
}));