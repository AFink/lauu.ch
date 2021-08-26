import "./bootstrap"

import "@ryangjchandler/alpine-clipboard";
import "alpinejs";

import Swup from 'swup';
import SwupPreloadPlugin from '@swup/preload-plugin';
import SwupSlideTheme from '@swup/slide-theme';

/*var swup = document.getElementById('swup');
if (swup) {
    window.swup = new Swup({
        plugins: [new SwupPreloadPlugin(), new SwupSlideTheme()]
    });
}

document.addEventListener('swup:contentReplaced', (event) => {
    window.livewire.restart();
}); */


import Swal from 'sweetalert2/src/sweetalert2.js';
window.Swal = Swal;

import moment from 'moment';
window.moment = moment;

import Picker from 'vanilla-picker';
window.Picker = Picker;

import 'livewire-sortable';

import './highlight.js';

import codemirror from 'codemirror';
window.codemirror = codemirror;


import Choices from 'choices.js';
window.Choices = Choices;
