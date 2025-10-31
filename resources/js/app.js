import './bootstrap';

import Alpine from 'alpinejs';
import Sortable from 'sortablejs';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

window.Alpine = Alpine;
window.Sortable = Sortable;
window.toastr = toastr;

Alpine.start();

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
};