import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.readTextAloud = function(text, lang = 'pt-BR', pitch = 1, rate = 1) {
    if ('speechSynthesis' in window) {
        let speech = new SpeechSynthesisUtterance();
        speech.text = text;
        speech.lang = lang;
        speech.pitch = pitch;
        speech.rate = rate;

        window.speechSynthesis.speak(speech);
    } else {
        console.error('SpeechSynthesis is not supported in this browser.');
    }
};

document.addEventListener('livewire:navigating', () => {
    if (window.intervalId) {
        clearInterval(window.intervalId);
        window.intervalId = undefined;
    }
}); 
