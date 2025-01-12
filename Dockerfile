# Gunakan gambar resmi PHP-FPM versi terbaru yang kompatibel
FROM php:8.1-fpm

# Install dependencies dan ekstensi yang diperlukan
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Salin file proyek ke dalam kontainer
COPY . /var/www/html

# Pastikan pemilik dan izin direktori benar
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Tentukan working directory untuk container
WORKDIR /var/www/html

# Port yang digunakan oleh PHP-FPM
EXPOSE 9000
