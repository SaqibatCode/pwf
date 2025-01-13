

   /** @type {import('tailwindcss').Config} */

   function withOpacity(variableName) {
    return ({ opacityValue }) => {
      if (opacityValue !== undefined) {
        return `rgba(var(${variableName}), ${opacityValue})`
      }
      return `rgba(var(${variableName}))`
    }
  }
   module.exports = {
    content: [
          "./resources/**/*.blade.php",
          "./resources/**/*.js",
          "./resources/**/*.vue",
     ],
     theme: {
        extend: {
          textColor: {
            skin: {
              primary: withOpacity('--text-primary'),
              gray: withOpacity('--text-gray'),
              secondary: withOpacity('--text-secondary'),
              unique: withOpacity('--text-unique'),
              inverted: withOpacity('--text-inverted'),
              odd: withOpacity('--text-odd'),
            },
          },
          backgroundColor: {
            skin: {
              'primary': withOpacity('--bg-primary'),
              'gray': withOpacity('--bg-gray'),
              'secondary': withOpacity('--bg-secondary'),
              'unique': withOpacity('--bg-unique'),
              'inverted': withOpacity('--bg-inverted'),
              // 'btn-accent': withOpacity('--color-btn-accent'),
              // 'btn-accent-hover': withOpacity('--color-btn-accent-hover'),
              // 'btn-muted': withOpacity('--color-btn-muted'),
              // 'btn-muted-hover': withOpacity('--color-btn-muted-hover'),
            }
          },
          fontFamily: {
            unbounded: ['"Unbounded"', 'sans-serif'],
          },
        },
      },
      plugins: [],
     }
