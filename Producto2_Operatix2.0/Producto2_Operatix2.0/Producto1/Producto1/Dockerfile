FROM php:8.4-apache 

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Cambiar DocumentRoot a la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT="/var/www/html/public"


RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Copiar Laravel al contenedor (si decides no montar por volumen)
# COPY ./laravel /var/www

# Permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
