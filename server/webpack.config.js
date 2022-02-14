const path = require("path");

module.exports = {
  entry: "./public/js/dependencies.js",
  output: {
    filename: "main.js",
    path: path.resolve(__dirname, "public/dist"),
  },
  resolve: {
    modules: [path.resolve(__dirname, "node_modules")],
  },
};
