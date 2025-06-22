#!/usr/bin/env bash
set -e

echo "🔧 Setting up SSL certificates for local development..."

# Check if mkcert is available
if command -v mkcert &> /dev/null; then
    echo "✅ mkcert found! Generating trusted certificates..."
    
    # Generate trusted certificates with mkcert for Nginx
    mkcert -cert-file localhost.crt -key-file localhost.key \
        localhost \
        127.0.0.1 \
        ::1 \
        SpaceRentBTP-v1.local \
        *.local
    
    # Also generate for Vite (copy to project root)
    cp localhost.crt ../../../localhost.pem
    cp localhost.key ../../../localhost-key.pem
    
    echo "✅ Generated trusted certificates:"
    echo "   - docker/nginx/ssl/localhost.crt (for Nginx)"
    echo "   - docker/nginx/ssl/localhost.key (for Nginx)" 
    echo "   - localhost.pem (for Vite, copied to root)"
    echo "   - localhost-key.pem (for Vite, copied to root)"
    echo "🌐 Your browser will trust these certificates!"
    
else
    echo "⚠️  mkcert not found. Generating self-signed certificates..."
    echo "📖 For trusted certificates, install mkcert first"
    
    # Generate enhanced self-signed certificate for Nginx
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout localhost.key \
        -out localhost.crt \
        -config <(
            echo '[dn]'
            echo 'CN=localhost'
            echo 'O=Local Development'
            echo 'C=US'
            echo '[req]'
            echo 'distinguished_name = dn'
            echo 'req_extensions = v3_req'
            echo '[v3_req]'
            echo 'basicConstraints = CA:FALSE'
            echo 'keyUsage = nonRepudiation, digitalSignature, keyEncipherment'
            echo 'subjectAltName = @alt_names'
            echo '[alt_names]'
            echo 'DNS.1 = localhost'
            echo 'DNS.2 = SpaceRentBTP-v1.local'
            echo 'DNS.3 = *.local'
            echo 'IP.1 = 127.0.0.1'
            echo 'IP.2 = ::1'
        )
    
    # Copy to root for Vite
    cp localhost.crt ../../../localhost.pem
    cp localhost.key ../../../localhost-key.pem
    
    echo "⚠️  Generated self-signed certificates (browsers will show warnings):"
    echo "   - docker/nginx/ssl/localhost.crt (for Nginx)"
    echo "   - docker/nginx/ssl/localhost.key (for Nginx)"
    echo "   - localhost.pem (for Vite, copied to root)"
    echo "   - localhost-key.pem (for Vite, copied to root)"
fi

# Set proper permissions
chmod 644 localhost.key localhost.crt
chmod 644 ../../../localhost*.pem

echo ""
echo "🎉 SSL setup complete!"
echo "📝 Quick install mkcert for trusted certificates:"
echo "   # macOS: brew install mkcert && mkcert -install"
echo "   # Ubuntu: sudo apt install libnss3-tools && [download mkcert binary]"
echo "📝 Add to hosts: echo '127.0.0.1 SpaceRentBTP-v1.local' | sudo tee -a /etc/hosts"