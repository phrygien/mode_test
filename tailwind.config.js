import forms from "@tailwindcss/forms"

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    'node_modules/preline/dist/*.js',
    "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("daisyui"),
    require('preline/plugin'),
  ],
}

