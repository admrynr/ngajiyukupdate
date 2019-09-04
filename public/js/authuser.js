$(document).ready(function(){
    $('.verify').on('click', function(){
        var name = $(this).data("name");
        var userid = $(this).data("id");
        var baseURL = window.location.origin;
        $( "#namecustomer" ).text(name);
        $("#btncustomer").on('click', function(){
            $.ajax({  method: "GET", url: baseURL+"/verify/"+userid, success: function(result){
                //alert(name+" Succesfully Changed!");
                $( ".rowverif" ).html(result);;
        }});
        
        //$( "#btncustomer" ).attr("href", "/verify/"+userid);
        });
    });
});