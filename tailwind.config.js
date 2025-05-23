import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'primary': {
                    DEFAULT: '#8B9EB7',
                    'light': '#A5B8D1',
                    'dark': '#6B7B91',
                },
                'secondary': {
                    DEFAULT: '#2C3E50',
                    'light': '#34495E',
                    'dark': '#1A2530',
                },
                'accent': {
                    DEFAULT: '#E74C3C',
                    'light': '#F39C12',
                    'dark': '#C0392B',
                },
                'background': {
                    DEFAULT: '#1A1F2B',
                    'light': '#2A2F3B',
                    'dark': '#0F141F',
                },
                'text': {
                    DEFAULT: '#E2E8F0',
                    'light': '#A0AEC0',
                    'dark': '#CBD5E0',
                }
            },
            fontFamily: {
                'sans': ['Source Sans Pro', ...defaultTheme.fontFamily.sans],
                'serif': ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            boxShadow: {
                'soft': '0 2px 4px rgba(0, 0, 0, 0.2)',
                'dark': '0 4px 6px rgba(0, 0, 0, 0.3)',
            },
        },
    },

    plugins: [forms],
};
