try {
    window.$ = window.jQuery = require('jquery');
    window.moment = require('moment');

    require('bootstrap');
    require('admin-lte');
    require('popper.js');
} catch (e) {}
