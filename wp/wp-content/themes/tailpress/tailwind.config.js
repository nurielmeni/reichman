const _ = require("lodash");
const theme = require("./theme.json");
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");

module.exports = {
  mode: "jit",
  content: [
    "./*/*.php",
    "./**/*.php",
    "../../plugins/NlsHunterFbf/*/*.php",
    "../../plugins/NlsHunterFbf/**/*.php",
    "./resources/css/*.css",
    "./resources/js/*.js",
    "./safelist.txt",
  ],
  theme: {
    container: {
      padding: {
        //DEFAULT: '1rem',
        // sm: '2rem',
        // lg: '0rem'
        DEFAULT: "0rem",
      },
      margin: {
        DEFAULT: "0.5rem 0",
      },
    },
    extend: {
      colors: tailpress.colorMapper(
        tailpress.theme("settings.color.palette", theme)
      ),
      width: {
        "1/31": "31%",
      },
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: tailpress.theme("settings.layout.wideSize", theme),
    },
  },
  plugins: [tailpress.tailwind],
};
