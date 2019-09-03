$(document).ready(function(){
    $('.verify').on('click', function(){
        var name = $(this).data("name");
        var userid = $(this).data("id");
        alert("/verify/"+userid);
        $( "#namecustomer" ).text(name) ;
        $( "#btncustomer" ).attr("href", "/verify/"+userid);
    });
});