#!bin/bash
# script for generating service-worker.js file under public folder

currdir="$(pwd)"
echo "...........generating service worker from '$currdir' .........."

# used googles automated service worker generation tool. Check docs at https://github.com/GoogleChromeLabs/sw-precache
sw-precache --config="./pwa/sw-precache-config.js" --verbose