import "../scss/app.scss";

import './bootstrap';

import './custom';
import './common';

// AdminKit (required)
// import "./modules/bootstrap";
import "./modules/sidebar";
import "./modules/theme";
import "./modules/feather";

// Charts
import "./modules/chartjs";

// Forms
import "./modules/flatpickr";

// Maps
import "./modules/vector-maps";

import 'jquery-validation/dist/jquery.validate.min.js';
import 'jquery-validation/dist/additional-methods.min.js';

// import 'laravel-datatables-vite';

import 'datatables.net-bs5';

import 'summernote/dist/summernote-lite.css';
import 'summernote/dist/summernote-lite.js';

import.meta.glob([
    '../images/**',
    '../img/**',
    '../webfonts/**',
    '../fonts/**',
]);
