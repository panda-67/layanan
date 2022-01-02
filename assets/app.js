/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/style.scss';

// start the Stimulus application
import './bootstrap';

import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor';

// ref: https://tobiasahlin.com/blog/move-from-jquery-to-vanilla-javascript/#document-ready

var ready = (callback) => {
    if (document.readyState != "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {
    ClassicEditor
        .create(document.querySelector('#layanan_description'))
        .catch(error => {
            console.log(`error`, error)
        });
});

const $ = require('jquery');
require('bootstrap')

// var myCarousel = document.querySelector('#myCarousel')
// var carousel = new bootstrap.Carousel(myCarousel)

// require('tinymce')
