module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  prefix: 'tw-',
  theme: {
    extend: {
        colors: {
            primary: {
                dark: '#1c6eb2',
                regular: '#4299E1',
                light: '#d5e8f8'
            }
        }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
