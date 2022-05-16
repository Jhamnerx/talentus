require('./bootstrap');
require('./main');
require('./utils');
require('./slider');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import Swal from 'sweetalert2';

window.Swal = Swal;
import iziToast from 'izitoast';
window.iziToast = iziToast;