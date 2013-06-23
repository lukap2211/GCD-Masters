// $(document).ready(function(){
$(function(){

    // Scroll Spy
    $('#navbar').scrollspy();

    // ADMIN section

    // tabs

    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })

    $('a[data-toggle="tab"]').on('shown', function (e) {
        e.target // activated tab
        e.relatedTarget // previous tab
    })

    $('#myTab a[href="#profile"]').tab('show'); // Select tab by name
    // $('#myTab a:first').tab('show'); // Select first tab
    // $('#myTab a:last').tab('show'); // Select last tab
    // $('#myTab li:eq(2) a').tab('show'); // Select third tab (0-indexed)

});