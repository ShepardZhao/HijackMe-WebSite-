/**
 * Created by zhaoxun321 on 8/05/2014.
 */
$(document).ready(function(){

    var url ="https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=true&key=AIzaSyAdDu6W_NBjzSLP4rWagypCtqjrCW5kups";

    var request = $.ajax({
        url: url,
        type: "POST",
        dataType: "json"
    });

    request.done(function( msg ) {
        console.log(msg);
    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });


});