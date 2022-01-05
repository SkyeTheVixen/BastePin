$(document).ready(function() {

    if(!window.location.href.endsWith("/")){
        console.log(window.location.href);
        window.location.href = window.location.href + "/";
    }

});