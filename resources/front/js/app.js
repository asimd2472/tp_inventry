import './bootstrap';

// validation plugin must be imported before any scripts that call .validate()
import 'jquery-validation/dist/jquery.validate.min.js';
import 'jquery-validation/dist/additional-methods.min.js';

import './custom';
import './common';
import './paralax';

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

// Date range Picker
import flatpckr from 'flatpickr';
window.flatpckr = flatpckr;
import 'flatpickr/dist/flatpickr.min.css';

import 'datatables.net-bs5';

// import './signature';







