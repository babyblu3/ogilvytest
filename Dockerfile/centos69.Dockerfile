# Drupal 7 Requirements
# https://www.drupal.org/docs/7/system-requirements/drupal-7-php-requirements
# http://mmenozzi.github.io/2016/01/22/php-web-development-with-docker/

# https://hub.docker.com/_/centos/
FROM centos:6.9

# -----------------------------------------------------------------------------
# Install Apache + PHP
# -----------------------------------------------------------------------------

# Install Apache Web Server (HTTPD)
# https://github.com/CentOS/CentOS-Dockerfiles/blob/master/httpd/centos6/Dockerfile
RUN yum -y update; yum clean all
RUN yum -y install httpd; yum clean all

EXPOSE 80

# Install PHP Modules
# https://support.rackspace.com/how-to/centos-6-apache-and-php-install/
RUN yum -y install php php-mysql php-devel php-gd php-pecl-memcache php-pspell php-mbstring php-snmp php-xmlrpc php-xml \
    && yum clean all

# -----------------------------------------------------------------------------
# Global Apache configuration changes
# -----------------------------------------------------------------------------

# Update DocumentIndex to include index.php (line 402)

# Update AllowOverride from None to All - enabled mod_rewite (line 304, 338, 557, 585, 862)
# https://www.e2enetworks.com/help/knowledge-base/how-to-enable-mod_rewrite-on-apache-on-centos/
# https://askubuntu.com/questions/429869/is-this-a-correct-way-to-enable-htaccess-in-apache-2-4-7-on-ubuntu-12-04

# Update ErrorLog to write to stdout - /proc/self/fd/2 (line 485)
# Update CustomLog to write to stdout - /proc/self/fd/1 (line 528)
# https://docs.docker.com/config/containers/logging/
COPY ./config/httpd.conf /etc/httpd/conf/httpd.conf

# -----------------------------------------------------------------------------
# Global PHP configuration changes
# -----------------------------------------------------------------------------

# Update realpath_cache_size to 64M
COPY ./config/php.ini /etc/php.ini

# -----------------------------------------------------------------------------
# Simple startup script to avoid some issues observed with container restart 
# -----------------------------------------------------------------------------

# Copy Drupal project file into container as it seems to hadle requests more faster (for testing only)
# ADD htdocs/ /var/www/html/

COPY run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

CMD ["/run-httpd.sh"]

# change default working back to httpd document root
WORKDIR /var/www/html




