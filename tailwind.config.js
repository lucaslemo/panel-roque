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
                'secondary': '#FFCC00',
                'secondary-100': '#FFF5CC',
                'secondary-500': '#FFE066',
                'danger': '#FF7070',
                'text-title': '#1E1E1E',
                'text-gray': '#A3A3A3',
                'disabled': '#C7C7C7',
                'border': '#ECECEC',
                'background': '#F6F6F6',
                'background-100': '#ECECEC',
                'black': '#494949',
            },
        },
    },

    plugins: [forms],
};
