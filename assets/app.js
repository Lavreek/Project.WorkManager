/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');

$(document).ready(function () {
    function updateUrl(key, value, reset = false) {
        let url = new URL(document.location.href);

        if (reset) {
            if (url.searchParams.has(key)) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.append(key, value);
            }

            return url;
        }

        if (url.searchParams.has(key)) {
            let condition = url.searchParams.get(key);

            if (condition === value + "=ASC") {
                url.searchParams.set(key, value + '=DESC');
            } else {
                url.searchParams.set(key, value + '=ASC');
            }
        } else {
            url.searchParams.append(key, value + '=ASC');
        }

        return url;
    }

   $('.sort').on('click', function (event) {
       event.preventDefault();
       let sorting = $(this).attr('data-sorting');
       window.location.replace(updateUrl('sorting', sorting));
   });

   $('.page').on('click', function (event) {
       event.preventDefault();
       let page = $(this).attr('href');
       window.location.replace(updateUrl('page', page, true));
   });
});
