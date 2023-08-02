import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    light: '#7dd3fc',
                    DEFAULT: '#075985',
                    dark: '#082f49',
                },
                secondary: {
                    light: '#3de7d2',
                    DEFAULT: '#2dd4bf',
                    dark: '#0d9488',
                }
            },
            backgroundImage: {
                'red-bg': "url('../../public/assets/bg.jpg')",
                'footer-texture': "url('/img/footer-texture.png')",
            }
        },
    },

    plugins: [forms],
};
