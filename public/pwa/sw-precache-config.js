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
    'static/offline.html'
  ],
  skipWaiting: true,
  clientsClaim: false, // control pages immediately after activation
  templateFilePath: templatepath,
  verbose: true
};