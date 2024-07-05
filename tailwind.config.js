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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#F2B705',
                secondary: '#303A73',
                tertiary: '#363859',
            },
        },
    },

    plugins: [forms],
};
