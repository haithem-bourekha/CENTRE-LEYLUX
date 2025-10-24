FROM php:8.2-apache

# تثبيت امتداد MySQL
RUN docker-php-ext-install mysqli pdo_mysql

# نسخ المشروع أولاً
COPY . /var/www/html/

# تحديد مجلد العمل
WORKDIR /var/www/html/

# تفعيل rewrite
RUN a2enmod rewrite

# إنشاء مجلد Uploads إذا لم يكن موجودًا، ثم تغيير الصلاحيات
RUN mkdir -p /var/www/html/Uploads \
    && chown -R www-data:www-data /var/www/html/Uploads \
    && chmod -R 755 /var/www/html/Uploads

# فتح البورت
EXPOSE 80

# تشغيل Apache
CMD ["apache2-foreground"]