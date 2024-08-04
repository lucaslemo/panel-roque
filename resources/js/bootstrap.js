import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Inputmask from "inputmask";

document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelector('.cpf-mask');
    Inputmask({
        mask: '999.999.999-99',
        jitMasking: true
    }).mask(elements);
    elements.dispatchEvent(new Event('input'));
});
