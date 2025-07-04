<?php

require_once __DIR__ . '/../connection/connection.php';

// Sample categories
$categories = [
    'Technology',
    'Health',
    'Science',
    'Business',
    'Travel'
];

// Insert categories
$category_ids = [];
$category_stmt = $mysqli->prepare("INSERT INTO categories (name) VALUES (?)");

foreach ($categories as $category) {
    $category_stmt->bind_param("s", $category);
    $category_stmt->execute();
    $category_ids[] = $category_stmt->insert_id;
}

$category_stmt->close();

// Sample articles
$articles = [
    ['name' => 'AI in 2025', 'author' => 'John Doe', 'description' => 'The future of AI...', 'category_id' => $category_ids[0]],
    ['name' => 'Healthy Living Tips', 'author' => 'Jane Smith', 'description' => 'Simple ways to stay healthy.', 'category_id' => $category_ids[1]],
    ['name' => 'SpaceX Mission', 'author' => 'Elon M.', 'description' => 'Next-gen space travel.', 'category_id' => $category_ids[2]],
    ['name' => 'Startup Fundraising', 'author' => 'VC Expert', 'description' => 'How to raise your seed round.', 'category_id' => $category_ids[3]],
    ['name' => 'Top 10 Places to Visit', 'author' => 'Globe Trotter', 'description' => 'Explore new destinations.', 'category_id' => $category_ids[4]]
];

// Insert articles
$article_stmt = $mysqli->prepare("INSERT INTO articles (name, author, description, category_id) VALUES (?, ?, ?, ?)");

foreach ($articles as $article) {
    $article_stmt->bind_param("sssi", $article['name'], $article['author'], $article['description'], $article['category_id']);
    $article_stmt->execute();
}

$article_stmt->close();
