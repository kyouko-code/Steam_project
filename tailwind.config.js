import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

function hexToRgb(hex) {
    const h = hex.replace('#', '');
    return [parseInt(h.slice(0, 2), 16), parseInt(h.slice(2, 4), 16), parseInt(h.slice(4, 6), 16)];
}

function toHex(rgb) {
    return '#' + rgb.map((v) => Math.round(v).toString(16).padStart(2, '0')).join('');
}

function blend(hexA, hexB, p) {
    const a = hexToRgb(hexA);
    const b = hexToRgb(hexB);
    return toHex(a.map((v, i) => v + (b[i] - v) * p));
}

function mochaScale(hex) {
    return {
        50:  blend(hex, '#eef1f8', 0.75),
        100: blend(hex, '#eef1f8', 0.6),
        200: blend(hex, '#eef1f8', 0.4),
        300: blend(hex, '#cdd6f4', 0.3),
        400: blend(hex, '#cdd6f4', 0.12),
        500: hex,
        600: blend(hex, '#11111b', 0.15),
        700: blend(hex, '#11111b', 0.3),
        800: blend(hex, '#11111b', 0.5),
        900: blend(hex, '#11111b', 0.7),
        950: blend(hex, '#11111b', 0.82),
    };
}

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'monospace'],
            },

            colors: {
                gray: {
                    50:  '#eef1f8',
                    100: '#cdd6f4',
                    200: '#bac2de',
                    300: '#a6adc8',
                    400: '#9399b2',
                    500: '#7f849c',
                    600: '#585b70',
                    700: '#45475a',
                    800: '#313244',
                    900: '#1e1e2e',
                    950: '#11111b',
                },

                // Catppuccin Mocha accents
                blue:    mochaScale('#89b4fa'),
                red:     mochaScale('#f38ba8'),
                green:   mochaScale('#a6e3a1'),
                emerald: mochaScale('#94e2d5'),
                purple:  mochaScale('#cba6f7'),
                violet:  mochaScale('#cba6f7'),
                amber:   mochaScale('#f9e2af'),
                yellow:  mochaScale('#f9e2af'),
                cyan:    mochaScale('#89dceb'),
                sky:     mochaScale('#74c7ec'),
                orange:  mochaScale('#fab387'),
                rose:    mochaScale('#eba0ac'),
                pink:    mochaScale('#f5c2e7'),
                teal:    mochaScale('#94e2d5'),
                indigo:  mochaScale('#b4befe'),
                maroon:  mochaScale('#eba0ac'),

                slate: {
                    50:  '#eef1f8',
                    100: '#cdd6f4',
                    200: '#bac2de',
                    300: '#a6adc8',
                    400: '#a6adc8',
                    500: '#9399b2',
                    600: '#7f849c',
                    700: '#6c7086',
                    800: '#45475a',
                    900: '#313244',
                    950: '#181825',
                },
            },
        },
    },

    plugins: [forms],
};