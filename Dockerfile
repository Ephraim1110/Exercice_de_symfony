# Utilisez l'image PHP 8.0 avec Apache
FROM php:8.0-apache

# Installez les extensions PHP requises pour Symfony
RUN docker-php-ext-install pdo pdo_mysql

# Activez le module Apache mod_rewrite
RUN a2enmod rewrite

# Copiez les fichiers de votre application Symfony dans le conteneur
COPY . C:\Users\ephra\MonTest\monCours1

# Configurez le répertoire de travail
WORKDIR C:\Users\ephra\MonTest\monCours1

# Exposez le port 80
EXPOSE 80

# Démarrez Apache au démarrage du conteneur
CMD ["apache2-foreground"]
