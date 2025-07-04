<?php

require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../connection/connection.php';

class CategoryController extends BaseController {

    public function getAllCategories() {
        global $mysqli;

        try {
            $categories = Category::all($mysqli);
            $data = array_map(fn($cat) => $cat->toArray(), $categories);
            self::success($data);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function getCategory() {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing category ID", 400);
                return;
            }

            $category = Category::find($mysqli, (int)$id);
            self::success($category->toArray());
        } catch (Exception $e) {
            self::error($e->getMessage(), 404);
        }
    }

    public function addCategory() {
        global $mysqli;

        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'] ?? null;

            if (!$name) {
                self::error("Missing category name", 422);
                return;
            }

            $category = Category::create($mysqli, $name);
            self::success($category->toArray(), 201);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function updateCategory() {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing category ID", 400);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'] ?? null;

            if (!$name) {
                self::error("Missing category name to update", 422);
                return;
            }

            $updated = Category::update($mysqli, (int)$id, $name);
            if ($updated) {
                $category = Category::find($mysqli, (int)$id);
                self::success($category->toArray());
            } else {
                self::error("Update failed", 500);
            }
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function deleteCategory() {
        global $mysqli;

        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                self::error("Missing category ID", 400);
                return;
            }

            $deleted = Category::delete($mysqli, (int)$id);
            if ($deleted) {
                self::success(["deleted" => true], 204);
            } else {
                self::error("Category not found or not deleted", 404);
            }
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }

    public function deleteAllCategories() {
        global $mysqli;

        try {
            Category::deleteAll($mysqli);
            self::success(["deleted_all" => true], 204);
        } catch (Exception $e) {
            self::error($e->getMessage());
        }
    }
}
