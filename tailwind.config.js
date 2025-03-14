/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
      extend: {
        // Scale everything down to approximately 70%
        fontSize: {
          'xs': '0.5rem',     // 8px
          'sm': '0.6rem',     // ~10px 
          'base': '0.75rem',  // 12px
          'lg': '0.875rem',   // 14px
          'xl': '1rem',       // 16px
          '2xl': '1.125rem',  // 18px
          '3xl': '1.25rem',   // 20px
          '4xl': '1.5rem',    // 24px
        },
        spacing: {
          // Scale spacing values
          '0.5': '0.07rem',
          '1': '0.15rem',
          '2': '0.3rem',
          '3': '0.45rem',
          '4': '0.6rem',
          '5': '0.75rem',
          '6': '0.9rem',
          '8': '1.2rem',
          '10': '1.5rem',
          '12': '1.8rem',
          '16': '2.4rem',
          '20': '3rem',
        },
        borderRadius: {
          DEFAULT: '0.25rem',
          'lg': '0.35rem',
          'xl': '0.5rem',
        },
      }
    },
    plugins: [],
  }