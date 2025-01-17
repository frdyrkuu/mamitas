/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors:{
        "main" : "#df1018",
        "bd" : "#737373",
        "proceed": "#18D742"
      },
      blur: {
        '5px': '5px',
      },
    },
  },
  plugins: [],
}