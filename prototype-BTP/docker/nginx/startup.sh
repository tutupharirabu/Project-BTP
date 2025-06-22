#!/bin/bash

# Check if mkcert certificates exist, if not create self-signed as fallback
if [ ! -f /etc/nginx/ssl/localhost.crt ] && [ ! -f /etc/nginx/ssl/localhost.key ]; then
    echo "🔍 mkcert certificates not found, creating self-signed certificates as fallback..."
    
    # Create SSL directory
    mkdir -p /etc/nginx/ssl
    
    # Generate self-signed certificate with multiple SANs
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout /etc/nginx/ssl/localhost.key \
        -out /etc/nginx/ssl/localhost.crt \
        -config <(
            echo '[dn]'
            echo 'CN=localhost'
            echo '[req]'
            echo 'distinguished_name = dn'
            echo '[SAN]'
            echo 'subjectAltName=DNS:localhost,DNS:SpaceRentBTP-v1.local,DNS:*.local,IP:127.0.0.1,IP:::1'
            echo '[v3_req]'
            echo 'basicConstraints = CA:FALSE'
            echo 'keyUsage = nonRepudiation, digitalSignature, keyEncipherment'
            echo 'subjectAltName = @SAN'
        ) \
        -extensions v3_req
    
    chmod 644 /etc/nginx/ssl/localhost.key
    chmod 644 /etc/nginx/ssl/localhost.crt
    
    echo "⚠️  Self-signed certificates created. For trusted certificates, run setup script with mkcert."
else
    echo "✅ SSL certificates found!"
fi

# Remove old default certificates if they exist
if [ -f /etc/nginx/ssl/default.crt ]; then
    rm -f /etc/nginx/ssl/default.crt /etc/nginx/ssl/default.key /etc/nginx/ssl/default.csr
fi

# Setup cron job to restart nginx every 6 hours
(crontab -l 2>/dev/null; echo "0 */6 * * * nginx -s reload") | crontab -

# Start crond in background
crond -l 2 -b

# Test nginx configuration
nginx -t

if [ $? -eq 0 ]; then
    echo "✅ NGINX configuration is valid"
    echo "🚀 NGINX started, daemon will restart every 6 hours"
    echo "🌐 Access your app at: https://SpaceRentBTP-v1.local"
    
    # Start nginx in foreground
    nginx
else
    echo "❌ NGINX configuration test failed"
    exit 1
fi