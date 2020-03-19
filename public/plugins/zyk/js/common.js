let theme = localStorage.getItem('theme');
if(theme == '' || theme == null){
    theme = 'light'
}

$('body').addClass('theme-' + theme);

/*
==================================================================
DOCUMENT ON READY
==================================================================
*/

$(document).ready(function(){

});

/*
==================================================================
FUNCTIONS
==================================================================
*/

const Common = {
    
}

// CHANGING THEME COLOR
function changeTheme(themeName){
    // Remove any class .theme- of body
    $('body').removeClass(function (index, className) {
        return (className.match(/(^|\s)theme-\S+/g) || []).join(' ');
    });

    // Add new theme class into body
    $('body').addClass('theme-' + themeName);

    // Write data theme into localstorage
    localStorage.setItem('theme', themeName);
}