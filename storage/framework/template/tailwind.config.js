/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors:{
        "ngekos-black": "#070707",
        "ngekos-grey": "#5E6F76",
        "ngekos-orange": "#FF801A",
      }
    },
  },
  plugins: [],
}