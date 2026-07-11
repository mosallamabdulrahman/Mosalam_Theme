const path = require('path');
const fs = require('fs');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const blocksDir = path.resolve(__dirname, 'blocks');
const blockEntries = {};
fs.readdirSync(blocksDir, { withFileTypes: true })
  .filter((entry) => entry.isDirectory())
  .forEach((entry) => {
    const indexFile = path.join(blocksDir, entry.name, 'index.js');
    if (fs.existsSync(indexFile)) {
      blockEntries[`blocks/${entry.name}/build/index`] = indexFile;
    }
  });

// IMPORTANT: @wordpress/scripts' default webpack config cleans its
// output.path before every build (output.clean / CleanWebpackPlugin).
// Since our output.path is the theme root itself (so build files land at
// blocks/<name>/build/index.js instead of a top-level /build folder), that
// clean step would wipe the entire theme. Explicitly disable it and strip
// any clean plugin instance as a second safeguard.
const safePlugins = (defaultConfig.plugins || []).filter(
  (plugin) => !plugin || !plugin.constructor || !/clean/i.test(plugin.constructor.name)
);

module.exports = {
  ...defaultConfig,
  entry: {
    ...blockEntries,
    'assets/js/build/theme': path.resolve(__dirname, 'assets/js/theme.js'),
  },
  output: {
    ...defaultConfig.output,
    path: path.resolve(__dirname),
    filename: '[name].js',
    clean: false,
  },
  plugins: safePlugins,
};
