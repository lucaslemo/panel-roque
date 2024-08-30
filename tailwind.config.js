import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Http/Livewire/*.php',
    ],

    safelist: [
        'bg-red-100',
        'border-red-500',
        'text-red-900',
        'bg-teal-100',
        'border-teal-500',
        'text-teal-900',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'h1': ['52px', '110%'],
                'h2': ['40px', '110%'],
                'h3': ['32px', '110%'],
                'h4': ['26px', '110%'],
                'h5': ['20px', '110%'],
                'large': ['20px', '110%'],
                'normal': ['16px', '120%'],
                'small': ['14px', '110%'],
                'subtitle': ['12px', '110%'],
                'small-subtitle': ['10px', '110%'],
            },
            colors: {
                'primary': '#022266',
                'primary-100': '#E6E9F0',
                'primary-200': '#CCD3E0',
                'primary-300': '#B4BDD2',
                'primary-400': '#9AA7C2',
                'primary-500': '#8090B2',
                'primary-600': '#677AA3',
                'primary-700': '#4E6594',
                'primary-800': '#354E85',
                'primary-900': '#1C3976',
                'primary-action': '#0043D8',
                'secondary': '#FFCC00',
                'secondary-100': '#FFF5CC',
                'secondary-500': '#FFE066',
                'danger': '#FF7070',
                'title': '#1E1E1E',
                'subtitle-color': '#A3A3A3',
                'disabled': '#C7C7C7',
                'line': '#ECECEC',
                'background': '#F6F6F6',
                'background-100': '#ECECEC',
                'black': '#494949',
            },
            boxShadow: {
                'card': '0px 1px 3px rgba(0, 0, 0, 0.12), 0px 1px 2px rgba(0, 0, 0, 0.24)',
                'button': '0px 3px 6px rgba(0, 0, 0, 0.16), 0px 3px 6px rgba(0, 0, 0, 0.23)',
                'menu': '0px 10px 20px rgba(0, 0, 0, 0.19), 0px 6px 6px rgba(0, 0, 0, 0.23)',
                'hight-card': '0px 14px 28px rgba(0, 0, 0, 0.25), 0px 10px 10px rgba(0, 0, 0, 0.22)',
                'picker': '0px 19px 38px rgba(0, 0, 0, 0.30), 0px 15px 12px rgba(0, 0, 0, 0.22)',
                'modal': '0px 24px 48px rgba(0, 0, 0, 0.35), 0px 20px 16px rgba(0, 0, 0, 0.22)',
            },
        },
    },

    plugins: [forms],
};
