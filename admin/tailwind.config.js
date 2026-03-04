module.exports = {
    content: [
        './public/**/*.blade.php',
        './public/**/*.mjs',
        './public/**/*.html',
        '/src/pkg/**/*.blade.php',
        '/src/vendor/confetti-cms/*.blade.php',
        '/src/vendor/confetti-cms/*.mjs',
        '/src/vendor/confetti-cms/*.html',
    ],
    darkMode: 'class',
    theme: {
        fontFamily: {
            'headings': ['pluto'],
            'body': ['sans-serif'],
          },
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#d69051',
                    light: "#d69051",
                    dark: "#d69051",
                },
                secondary: {
                    DEFAULT: '#3dc2ff',
                    dark: "#36abe0",
                    light: "#50c8ff",
                },
            }
        },
    },
}
