<?php

// this contains the application url rules
return array(
    'tag/<tag>'=>'post/list',

    'posts/admin'=>'post/admin',
    'posts/create'=>'post/create',
    'posts/update/<id:\d+>'=>'post/update',
    'posts/search'=>'post/search',
    'posts/captcha'=>'post/captcha',
    'post/<year:\d{4}>/<month:\d{2}>/<day:\d{1,2}>'=>'post/PostedOnDate',
    'post/<year:\d{4}>/<month:\d{2}>'=>'post/PostedInMonth',
    'post/<slug:[a-z0-9-]+>'=>'post/show',
    'posts/*'=>'post/list',

    'cats'=>'category/list',
    'cats/admin'=>'category/admin',
    'cats/create'=>'category/create',
    'cats/update/<id:\d+>'=>'category/update',
    'cate/<slug:[a-z0-9-]+>'=>'category/show',
    'comments'=>'comment/list',
    'comment/update/<id:\d+>'=>'comment/update',
    'comment/delete/<id:\d+>'=>'comment/delete',
    'comment/approve/<id:\d+>'=>'comment/approve',
    'pages/admin'=>'page/admin',
    'pages/create'=>'page/create',
    'pages/update/<id:\d+>'=>'page/update',
    'page/<slug:[a-z0-9-]+>*'=>'page/show',


    'postsfeed'=>'site/postFeed',
    'commentsfeed'=>'site/commentFeed',
    'sitemap.xml'=>'site/sitemapxml',
    'site/users'=>'user/list',
    'user/users'=>'user/list',
    'post/users'=>'user/list',
    'comment/users'=>'user/list',
    'users'=>'user/list',

    'users/list'=>'user/list',
    'user/update/<id:\d+>'=>'user/update',
    'user/<id:\d+>'=>'user/show',
    'files/admin'=>'file/admin',
    'files/create'=>'file/create',
    'files/update/<id:\d+>'=>'file/update',
    'filems/admin'=>'filem/admin',
    'filems/create'=>'filem/create',
    'filems/update/<id:\d+>'=>'filem/update',
    'registration/<code:[a-z0-9]+>'=>'user/registration',
    'registration'=>'user/registration',
    'login'=>'user/login',
    'logout'=>'user/logout',
    'lostpass/<code:[a-z0-9]+>'=>'user/lostpass',
    'lostpass'=>'user/lostpass',
    'postbookmarks'=>'user/bookmarks',

);
