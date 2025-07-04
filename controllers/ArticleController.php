<?php

require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../connection/connection.php';

class ArticleController extends BaseController
{

    public function getAllArticles()
    {
        global $mysqli;

        try {
            $articles = Article::all($mysqli);
            $data = array_map(fn($article) => $article->toArray(), $articles);
            self::success($data);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function getArticle()
    {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing article ID", 400);
                return;
            }

            $article = Article::find($mysqli, (int) $id);
            self::success($article->toArray());
        } catch (Exception $e) {
            self::error($e->getMessage(), 404);
        }
    }

    public function addArticle()
    {
        global $mysqli;

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $name = $data['name'] ?? null;
            $author = $data['author'] ?? null;
            $description = $data['description'] ?? null;

            if (!$name || !$author || !$description) {
                self::error("Missing required fields", 422);
                return;
            }

            $article = Article::create($mysqli, $name, $author, $description);
            self::success($article->toArray(), 201);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function updateArticle()
    {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing article ID", 400);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'] ?? null;
            $author = $data['author'] ?? null;
            $description = $data['description'] ?? null;

            if ($name === null && $author === null && $description === null) {
                self::error("No fields to update", 422);
                return;
            }

            $updated = Article::update($mysqli, (int) $id, $name, $author, $description);
            if ($updated) {
                $article = Article::find($mysqli, (int) $id);
                self::success($article->toArray());
            } else {
                self::error("Update failed", 500);
            }
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function deleteArticle()
    {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing article ID", 400);
                return;
            }

            $deleted = Article::delete($mysqli, (int) $id);
            if ($deleted) {
                self::success(["deleted" => true], 204);
            } else {
                self::error("Article not found", 404);
            }
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function deleteAllArticles()
    {
        global $mysqli;

        try {
            Article::deleteAll($mysqli);
            self::success(["deleted_all" => true], 204);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function getArticlesByCategory()
    {
        global $mysqli;

        try {
            $category_id = $_GET['id'] ?? null;
            if (!$category_id) {
                self::error("Missing category ID", 400);
                return;
            }

            $stmt = $mysqli->prepare("SELECT * FROM articles WHERE category_id = ?");
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $articles = [];
            while ($row = $result->fetch_assoc()) {
                $articles[] = (new Article($row))->toArray();
            }

            self::success($articles);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function getCategoryOfArticle()
    {
        global $mysqli;

        try {
            $article_id = $_GET['id'] ?? null;
            if (!$article_id) {
                self::error("Missing article ID", 400);
                return;
            }

            $article = Article::find($mysqli, (int)$article_id);
            $category_id = $article->toArray()['category_id'] ?? null;

            $category = Category::find($mysqli, $category_id);
            self::success($category->toArray());
        } catch (Exception $e) {
            self::error($e->getMessage(), 404);
        }
    }
}
