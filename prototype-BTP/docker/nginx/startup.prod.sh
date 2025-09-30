#!/bin/bash
set -e

nginx -t

echo "Starting NGINX in production mode"
exec nginx -g 'daemon off;'
