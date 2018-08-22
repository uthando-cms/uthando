<?php

/**
 * Database `uthando-cms-3`
 */

/* `uthando-cms-3`.`comments` */
$comments = [
    ['id' => '13e30a72-1669-467b-9e3e-234906d1a5fa','post_id' => 'e610d563-a408-42b4-8445-1db708ef714e','tree_root' => '13e30a72-1669-467b-9e3e-234906d1a5fa','parent_id' => NULL,'author' => 'Jack','content' => 'Thank you for posting this','date_created' => '2018-08-20T19:25:14+00:00','lft' => '1','rgt' => '2','lvl' => '0'],
    ['id' => '89d47cae-1517-4acb-965d-7334c820ba13','post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tree_root' => '89d47cae-1517-4acb-965d-7334c820ba13','parent_id' => NULL,'author' => 'Andy','content' => 'Thanks Man!','date_created' => '2018-08-20T19:20:34+00:00','lft' => '1','rgt' => '2','lvl' => '0'],
    ['id' => '8af31c75-8edd-448f-b195-c738a07240ec','post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tree_root' => '8af31c75-8edd-448f-b195-c738a07240ec','parent_id' => NULL,'author' => 'Fred','content' => 'Thank you for writting this.','date_created' => '2018-08-20T19:20:12+00:00','lft' => '1','rgt' => '2','lvl' => '0']
];

/* `uthando-cms-3`.`posts` */
$posts = [
    ['id' => '1402254b-030c-4d93-9015-c0cebe5355ac','status' => '0','title' => 'Disable IPv6 in Ubuntu','seo' => 'disable-ipv6-in-ubuntu','content' => 'IPv6 is the next internet protocol, but most equipment is not ready for this yet. So running a small server on my intranet I have no use for it and frankly it started causing me some problems.','date_created' => '2018-08-22T17:16:14+00:00','date_modified' => '2018-08-22T17:16:14+00:00'],
    ['id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','status' => '0','title' => 'How to Install MySQL or MariaDB on CentOS 7','seo' => 'how-to-install-mysql-or-mariadb-on-centos-7','content' => 'As of CentOS 7 the default database is MariaDB and a drop in replacement for MySQL and should be fine for most people but if you need MySQL, there are some features in MySQL and not in MariaDB and vice versa.','date_created' => '2018-08-20T19:18:50+00:00','date_modified' => '2018-08-20T19:18:50+00:00'],
    ['id' => '6ffbdc8e-546d-4da2-8e78-43bde918c864','status' => '1','title' => 'Nginx: Using Regex to Configure Dynamic Location Blocks','seo' => 'nginx-using-regex-to-configure-dynamic-location-blocks','content' => 'I love Nginx as a webserver, it\'s quick and easy to configure (if you know what you are doing). As a web developer (or should I say programmer), I like to make things as easy as possible in my development environment. As my projects have increased over time I have noticed my Nginx config growing to accommodate each project.','date_created' => '2018-08-20T19:15:51+00:00','date_modified' => '2018-08-20T19:15:51+00:00'],
    ['id' => 'e610d563-a408-42b4-8445-1db708ef714e','status' => '1','title' => 'Gigabyte Brix BXBT-1900 Not Booting without Monitor on Ubuntu Minimal 16.04','seo' => 'gigabyte-brix-bxbt-1900-not-booting-without-monitor-on-ubuntu-minimal-16-04','content' => 'I love my Gigabyte Brix BXBT-1900, I have been running it as a headless server since March 2016 and had no problems with it I originally put Ubuntu 14.04 LTS and got to going quite easily. When Ubuntu 16.04 LTS I did an in situ update to Ubuntu 16.04 for which my MySQL keep breaking when Ubuntu kept adding updates for it, I have posted on this before http://www.shaunfreeman.name/ubuntu-16-04-mysql-update-fails/.','date_created' => '2018-08-20T19:17:29+00:00','date_modified' => '2018-08-20T19:17:29+00:00']
];

/* `uthando-cms-3`.`post_tag` */
$post_tag = [
    ['post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tag_id' => '3f17611e-13de-4439-929d-1396943d3c4e'],
    ['post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tag_id' => '48a54272-e863-4684-a236-b36cd3d11a96'],
    ['post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tag_id' => 'dde3a281-47aa-4c5e-bf63-6a3d52d1be30'],
    ['post_id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3','tag_id' => 'ee2f5965-4910-4912-8e7f-089501711e16'],
    ['post_id' => '6ffbdc8e-546d-4da2-8e78-43bde918c864','tag_id' => '4626d207-94cf-469f-82e2-a73a9f492b6c'],
    ['post_id' => '6ffbdc8e-546d-4da2-8e78-43bde918c864','tag_id' => 'aa4fa2c7-506a-4889-9810-af14f36b2b87'],
    ['post_id' => '6ffbdc8e-546d-4da2-8e78-43bde918c864','tag_id' => 'c8150b57-a5df-4951-b26c-e8e31c487ade'],
    ['post_id' => '6ffbdc8e-546d-4da2-8e78-43bde918c864','tag_id' => 'ee2f5965-4910-4912-8e7f-089501711e16'],
    ['post_id' => 'e610d563-a408-42b4-8445-1db708ef714e','tag_id' => '3f17611e-13de-4439-929d-1396943d3c4e'],
    ['post_id' => 'e610d563-a408-42b4-8445-1db708ef714e','tag_id' => 'ee2f5965-4910-4912-8e7f-089501711e16'],
    ['post_id' => 'e610d563-a408-42b4-8445-1db708ef714e','tag_id' => 'f15918f3-a0da-439a-be65-b94b692e41ad']
];

/* `uthando-cms-3`.`tags` */
$tags = [
    ['id' => '3f17611e-13de-4439-929d-1396943d3c4e','name' => 'Linux','seo' => 'linux'],
    ['id' => '4626d207-94cf-469f-82e2-a73a9f492b6c','name' => 'php-fpm','seo' => 'php-fpm'],
    ['id' => '48a54272-e863-4684-a236-b36cd3d11a96','name' => 'CentOS','seo' => 'centos'],
    ['id' => 'aa4fa2c7-506a-4889-9810-af14f36b2b87','name' => 'PHP','seo' => 'php'],
    ['id' => 'c8150b57-a5df-4951-b26c-e8e31c487ade','name' => 'Nginx','seo' => 'nginx'],
    ['id' => 'dde3a281-47aa-4c5e-bf63-6a3d52d1be30','name' => 'MySQL','seo' => 'mysql'],
    ['id' => 'ee2f5965-4910-4912-8e7f-089501711e16','name' => 'Server','seo' => 'server'],
    ['id' => 'f15918f3-a0da-439a-be65-b94b692e41ad','name' => 'Ubuntu','seo' => 'ubuntu']
];

/* `uthando-cms-3`.`users` */
$users = [
    ['id' => 'd1b265d5-8ab2-4fd8-8bcd-8bdf697324d0','email' => 'admin@example.com','firstname' => 'Joe','lastname' => 'Admin','password' => '$2y$10$Y/xlyLCfoICI800jfYyUkObmG6lKyT0P4z85DbRpSLV5D0rxLgqPm','status' => '1','date_created' => '2018-08-19T13:18:01+00:00','pwd_reset_token' => NULL,'pwd_reset_token_creation_date' => '2018-08-19T13:18:01+00:00'],
    ['id' => 'e204c45d-ef8c-4c59-8e16-e4c45492981f','email' => 'user@example.com','firstname' => 'Jane','lastname' => 'User','password' => '$2y$10$/aF7M03.RIaF0B/8QSgJjeNnbMhsgEh2gpX0ScOHNBtFulW2m/z4i','status' => '1','date_created' => '2018-08-20T19:08:08+00:00','pwd_reset_token' => NULL,'pwd_reset_token_creation_date' => '2018-08-20T19:08:08+00:00']
];
