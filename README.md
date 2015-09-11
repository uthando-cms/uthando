Uthando Cms
=======================

[![Build Status](https://travis-ci.org/uthando-cms/uthando.svg?branch=master)](https://travis-ci.org/uthando-cms/uthando)
[![Test Coverage](https://codeclimate.com/github/uthando-cms/uthando/badges/coverage.svg)](https://codeclimate.com/github/uthando-cms/uthando/coverage)
[![Code Climate](https://codeclimate.com/github/uthando-cms/uthando/badges/gpa.svg)](https://codeclimate.com/github/uthando-cms/uthando)
[![Dependency Status](https://www.versioneye.com/user/projects/55ed944e211c6b001f001670/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55ed944e211c6b001f001670)
[![Packagist](https://img.shields.io/packagist/v/uthando-cms/uthando.svg)]()

Introduction
------------
This is a simple, base application for Uthando CMS.
You can use it without any of the other modules as a base ZF2 MVC application as a base start for your projects.

Installation using Composer
---------------------------

The easiest way to install Uthando CMS is to use [Composer](https://getcomposer.org/). If you don't have it already installed, then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).


Install Uthando CMS:

    composer create-project uthando-cms/uthando path/to/install
    
    // if you are installing on a production server you may wish install only the required dependencies
    composer create-project --no-dev uthando-cms/uthando path/to/install



### Installation using a tarball with a local Composer

If you don't have composer installed globally then another way to install Uthando CMS is to download the tarball and install it:

1. Download the [tarball](https://github.com/uthando-cms/uthando/tarball/master), extract it and then install the dependencies with a locally installed Composer:

        cd my/project/dir
        curl -#L https://github.com/uthando-cms/uthando/tarball/master | tar xz --strip-components=1
    

2. Download composer into your project directory and install the dependencies:

        curl -s https://getcomposer.org/installer | php
        php composer.phar install

If you don't have access to curl, then install Composer into your project as per the [documentation](https://getcomposer.org/doc/00-intro.md).

### Installing extra modules and libraries

There are a number of modules you can add and these will get you up and running very quickly.
The official Uthando CMS modules are:

- Uthando Admin
- Uthando Article
- Uthando Business List
- Uthando Common
- Uthando Contact
- Uthando DomPdf
- Uthando File Manager
- Uthando Mail
- Uthando Navigation
- Uthando News
- Uthando Session Manager
- Uthando Testimonial
- Uthando Theme Manager
- Uthando Twitter
- Uthando User


Web server setup
----------------

### PHP CLI server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root
directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note:** The built-in CLI server is *for development only*.

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-app.localhost
        DocumentRoot /path/to/uthando-cms/public
        <Directory /path/to/zf2-app/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

    http {
        # ...
        include sites-enabled/*.conf;
    }


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/uthando-cms.localhost.conf`
it should look something like below:

    server {
        listen       80;
        server_name  zf2-app.localhost;
        root         /path/to/uthando-cms/public;

        location / {
            index index.php;
            try_files $uri $uri/ @php;
        }

        location @php {
            # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME /path/to/uthando-cms/public/index.php;
            include fastcgi_params;
        }
    }

Restart the nginx, now you should be ready to go!
