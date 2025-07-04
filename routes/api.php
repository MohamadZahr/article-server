<?php
return [
    '/articles' => ['controller' => 'ArticleController', 'method' => 'getAllArticles'],
    '/article'  => ['controller' => 'ArticleController', 'method' => 'getArticle'],
    '/add_article' => ['controller' => 'ArticleController', 'method' => 'addArticle'],
    '/update_article' => ['controller' => 'ArticleController', 'method' => 'updateArticle'],
    '/delete_articles' => ['controller' => 'ArticleController', 'method' => 'deleteAllArticles'],
    '/delete_article' => ['controller' => 'ArticleController', 'method' => 'deleteArticle'],
];
