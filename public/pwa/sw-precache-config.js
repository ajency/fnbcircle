var appRoot = require('app-root-path');
var packageJson = require(appRoot + '/package.json');
var templatepath = appRoot + '/pwa/custom-service-worker.tmpl';

module.exports = {
  cacheId: packageJson.name, // name of cache used by browser cache storage API
  staticFileGlobs: [ // currently only caching files required for the offline page
    'css/font-awesome/css/font-awesome.min.css',
    'css/bootstrap.min.css',
    'css/main.css',
    'img/404.png ',
    'img/logo-fnb.png',
    'js/offline-detection.js',
    'static/offline.html'
  ],
  dynamicUrlToDependencies: {
    '/': 'index.php'
  },
  importScripts: ['push.js'],
  skipWaiting: false, // if true activates the service immediately after install
  clientsClaim: false, // if true controls all tabs from domain immediately after activation
  templateFilePath: templatepath,
  verbose: true
};