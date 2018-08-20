<?php

/**
 * Database `uthando-cms-3`
 */

return [
    /* `uthando-cms-3`.`comments` */
    'comments' => [
        ['id' => '3096319d-f01d-49eb-95a1-fbdb87deb415','post_id' => '4ef5bf8a-fbac-4518-afe9-3a59deb6f726','tree_root' => '3096319d-f01d-49eb-95a1-fbdb87deb415','parent_id' => NULL,'author' => 'Shaun Freeman','content' => 'Thanks for this post!','date_created' => '2018-08-12T19:44:15+00:00','lft' => '1','rgt' => '2','lvl' => '0']
    ],
    /* `uthando-cms-3`.`posts` */
    'posts' => [
        ['id' => '4ef5bf8a-fbac-4518-afe9-3a59deb6f726','status' => '0','title' => 'Twitter Bootstrap - Making a Professional Looking Site','seo' => 'twitter-bootstrap-making-a-professional-looking-site','content' => 'Twitter Bootstrap (shortly, Bootstrap) is a popular CSS framework allowing to make your website professionally looking and visually appealing, even if you don\'t have advanced designer skills.','date_created' => '2018-08-08T13:36:40+00:00','date_modified' => '2018-08-17T19:14:19+00:00'],
        ['id' => '776ceb09-f300-48bc-b400-0fd524532e6d','status' => '1','title' => 'Getting Started with Magento Extension Development - Book Review','seo' => 'getting-started-with-magento-extension-development-book-review','content' => 'Recently, I needed some good resource to start learning Magento e-Commerce system for one of my current web projects. For this project, I was required to write an extension module that would implement a customer-specific payment method.','date_created' => '2018-07-31T18:18:04+00:00','date_modified' => '2018-08-09T06:47:54+00:00'],
        ['id' => 'c4d11f76-3afb-4733-ad03-8a053df794c1','status' => '1','title' => 'A Free Book about Zend Framework','seo' => 'a-free-book-about-zend-framework','content' => 'I\'m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.','date_created' => '2018-07-31T18:11:29+00:00','date_modified' => '2018-08-01T18:58:03+00:00']
    ],
    /* `uthando-cms-3`.`post_tag` */
    'post_tag' => [
        ['post_id' => '4ef5bf8a-fbac-4518-afe9-3a59deb6f726','tag_id' => '5ad50227-a3e6-4e63-9e0e-1ef9ccc45d75'],
        ['post_id' => '4ef5bf8a-fbac-4518-afe9-3a59deb6f726','tag_id' => 'd93ce172-a93e-4363-bb41-a0e3a3923e75'],
        ['post_id' => '776ceb09-f300-48bc-b400-0fd524532e6d','tag_id' => '2b748225-218d-458c-b2a1-a0dc20f41d5b'],
        ['post_id' => '776ceb09-f300-48bc-b400-0fd524532e6d','tag_id' => 'cc47a688-df93-4d6e-80af-96b1bf9e6ef1'],
        ['post_id' => '776ceb09-f300-48bc-b400-0fd524532e6d','tag_id' => 'cecb8bff-d7ba-4cf2-ba84-bd12b3e12795'],
        ['post_id' => 'c4d11f76-3afb-4733-ad03-8a053df794c1','tag_id' => '2b748225-218d-458c-b2a1-a0dc20f41d5b'],
        ['post_id' => 'c4d11f76-3afb-4733-ad03-8a053df794c1','tag_id' => '57fc7ae9-6565-47cb-aeb3-ab9446f6f217'],
        ['post_id' => 'c4d11f76-3afb-4733-ad03-8a053df794c1','tag_id' => 'f8a3e338-623a-4851-95a7-de75de51163e']
    ],
    /* `uthando-cms-3`.`tags` */
    'tags' =>  [
        ['id' => '164d3272-e9ca-4c35-8d18-dde464f1dd82','name' => 'Linux','seo' => 'linux'],
        ['id' => '2b748225-218d-458c-b2a1-a0dc20f41d5b','name' => 'PHP','seo' => 'php'],
        ['id' => '57fc7ae9-6565-47cb-aeb3-ab9446f6f217','name' => 'Zend Framework','seo' => 'zend-framework'],
        ['id' => '5ad50227-a3e6-4e63-9e0e-1ef9ccc45d75','name' => 'Bootstrap','seo' => 'bootstrap'],
        ['id' => 'cc47a688-df93-4d6e-80af-96b1bf9e6ef1','name' => 'Magento','seo' => 'magento'],
        ['id' => 'cecb8bff-d7ba-4cf2-ba84-bd12b3e12795','name' => 'e-commerce','seo' => 'e-commerce'],
        ['id' => 'd93ce172-a93e-4363-bb41-a0e3a3923e75','name' => 'CSS','seo' => 'css'],
        ['id' => 'f8a3e338-623a-4851-95a7-de75de51163e','name' => 'Book','seo' => 'book']
    ],
    /* `uthando-cms-3`.`users` */
    'users' => [
        ['id' => 'd1b265d5-8ab2-4fd8-8bcd-8bdf697324d0','email' => 'admin@example.com','firstname' => 'Joe','lastname' => 'Admin','password' => '$2y$10$Y/xlyLCfoICI800jfYyUkObmG6lKyT0P4z85DbRpSLV5D0rxLgqPm','status' => '1','date_created' => '2018-08-19T13:18:01+00:00','pwd_reset_token' => NULL,'pwd_reset_token_creation_date' => '2018-08-19T13:18:01+00:00']
    ],
];
