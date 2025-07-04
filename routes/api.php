<?php
return [
    '/articles' => ['controller' => 'ArticleController', 'method' => 'getAllArticles'],
    '/article'  => ['controller' => 'ArticleController', 'method' => 'getArticle'],
    '/add_article' => ['controller' => 'ArticleController', 'method' => 'addArticle'],
    '/update_article' => ['controller' => 'ArticleController', 'method' => 'updateArticle'],
    '/delete_articles' => ['controller' => 'ArticleController', 'method' => 'deleteAllArticles'],
    '/delete_article' => ['controller' => 'ArticleController', 'method' => 'deleteArticle'],

    '/articles_by_category' => ['controller' => 'ArticleController', 'method' => 'getArticlesByCategory'],
    '/category_of_article' => ['controller' => 'ArticleController', 'method' => 'getCategoryOfArticle'],


    '/categories' => ['controller' => 'CategoryController', 'method' => 'getAllCategories'],
    '/category' => ['controller' => 'CategoryController', 'method' => 'getCategory'],
    '/add_category' => ['controller' => 'CategoryController', 'method' => 'addCategory'],
    '/update_category' => ['controller' => 'CategoryController', 'method' => 'updateCategory'],
    '/delete_category' => ['controller' => 'CategoryController', 'method' => 'deleteCategory'],
    '/delete_categories' => ['controller' => 'CategoryController', 'method' => 'deleteAllCategories'],

];
