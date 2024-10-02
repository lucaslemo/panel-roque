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
            screens: {
                'laptop': '1024px',
                'desktop': '1920px',
            },
            spacing: {
                'desktop-margin': '70px',
                'laptop-margin': '45px',
                'mobile-margin': '30px',
                'big-mascot': '512px',
                'medium-mascot': '410px',
                'small-mascot': '338px',
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
                'label-color': '#8C8C8C',
                'border-color': '#BEBEBE',
                'disabled': '#E9ECEF',
                'line': '#ECECEC',
                'background': '#F6F6F6',
                'background-100': '#ECECEC',
                'black': '#494949',
            },
            boxShadow: {
                'card': '0 1px 2px rgba(0, 0, 0, 0.05)',
                'button': '0 2px 4px rgba(0, 0, 0, 0.1)',
                'menu': '0 4px 6px rgba(0, 0, 0, 0.1)',
                'hight-card': '0 10px 15px rgba(0, 0, 0, 0.1)',
                'picker': '0 20px 25px rgba(0, 0, 0, 0.1)',
                'modal': '0 25px 30px rgba(0, 0, 0, 0.1)',
            },
            keyframes: {
                pulse: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.03)' },
                },
            },
            animation: {
                pulse: 'pulse 0.4s ease-in-out',
            },
            zIndex: {
                '100': '100',
            }
        },
    },

    plugins: [forms],
};
