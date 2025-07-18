#!/bin/bash
set -e

echo "Deployment started ..."

# Pull the latest version of the app
git pull origin dev
echo "New changes copied to server !"

# Reloading Application So New Changes could reflect on website


echo "Deployment Finished!"