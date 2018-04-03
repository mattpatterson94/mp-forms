const path = require('path');

module.exports = {
  entry: {
    'project-planner': './inc/frontend/forms/project-planner/assets/js/index.js'
  },
  mode: 'development',
  output: {
    filename: 'inc/frontend/forms/[name]/assets/build/index.js',
    path: __dirname
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ["babel-loader"]
      }
    ]
  }
};
