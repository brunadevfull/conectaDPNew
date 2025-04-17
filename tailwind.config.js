/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./public/**/*.{html,php,js}",
      "./app/Views/**/*.{php,html}",
      "./app/Views/pages/**/*.{php,html}",
      "./app/Views/layouts/**/*.{php,html}"
    ],
    theme: {
      extend: {
        colors: {
          // Background colors from CSS variables
          'background': {
            '1': '#031633',
            '2': '#084298',
            '3': '#042454'
          },
          // Blue color palette from CSS variables
          'azul': {
            'light': '#e6e7ec',
            'light-hover': '#dadbe3',
            'light-active': '#b2b5c4',
            'normal': '#050f41',
            'normal-hover': '#050e3b',
            'normal-active': '#040c34',
            'dark': '#040c34',
            'dark-hover': '#050e3b',
            'dark-active': '#02071d',
            'darker': '#020517'
          },
          // Header specific colors
          'marinha': {
            DEFAULT: '#2160bd',
            'dark': '#084298'
          }
        },
        height: {
          'header': '146px',
          'header-sm': '120px'
        },
        backgroundImage: {
          'header-gradient': 'linear-gradient(to bottom, var(--background-color-1), var(--background-color-2))'
        },
        boxShadow: {
          'header': 'rgb(50 50 93 / 25%) 0px 13px 27px -5px, rgb(0 0 0 / 30%) 0px 8px 16px -8px',
          'default': '0 2px 6px -1px rgba(0, 0, 0, 0.16), 0 1px 4px -1px rgba(0, 0, 0, 0.04)'
        },
        fontFamily: {
          'sans': ['Open Sans', 'Arial', 'ui-sans-serif', 'system-ui']
        },
        zIndex: {
          'header': '1000',
          'fixed': '10'
        }
      },
    },
    plugins: [],
  }