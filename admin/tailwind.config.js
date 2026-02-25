module.exports = {
    content: [
        './**/*.blade.php',
        './**/*.mjs',
        './**/*.html',
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
