/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/forms.css';
import './styles/taskPanel.css';
// start the Stimulus application
import './bootstrap';


var navbar = $("#navbar");
    
$(window).on('scroll',()=>{    
    if ($(window).scrollTop() >= 40 && !window.matchMedia("(max-width:575px)").matches) 
        navbar.addClass('hidden-nav');
     else 
        navbar.removeClass('hidden-nav');
});



