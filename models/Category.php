<?php
require_once("Model.php");

class Category extends Model {
    private int $id;
    private string $name;

    protected static string $table = "categories";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->name = $data["name"];
    }
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }


    public static function create(mysqli $mysqli, string $name): Category {
        $stmt = $mysqli->prepare("INSERT INTO " . static::$table . " (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $id = $stmt->insert_id;
        return self::find($mysqli, $id);
    }

    public static function update(mysqli $mysqli, int $id, string $name): bool {
        $stmt = $mysqli->prepare("UPDATE " . static::$table . " SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public static function delete(mysqli $mysqli, int $id): bool {
        $stmt = $mysqli->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function deleteAll(mysqli $mysqli): bool {
        return $mysqli->query("DELETE FROM " . static::$table);
    }
}
