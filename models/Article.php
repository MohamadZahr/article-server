<?php
require_once("Model.php");

class Article extends Model
{
    private int $id;
    private string $name;
    private string $author;
    private string $description;
    private ?int $category_id; 

    protected static string $table = "articles";

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
        $this->category_id = $data["category_id"] ?? null; 
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getAuthor(): string { return $this->author; }
    public function getDescription(): string { return $this->description; }
    public function getCategoryId(): ?int { return $this->category_id; }

    public function setName(string $name): void { $this->name = $name; }
    public function setAuthor(string $author): void { $this->author = $author; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setCategoryId(?int $category_id): void { $this->category_id = $category_id; }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "author" => $this->author,
            "description" => $this->description,
            "category_id" => $this->category_id
        ];
    }
    public static function create(mysqli $mysqli, string $name, string $author, string $description, ?int $category_id = null): Article
    {
        $stmt = $mysqli->prepare("INSERT INTO " . static::$table . " (name, author, description, category_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $author, $description, $category_id);
        $stmt->execute();

        $id = $stmt->insert_id;
        return self::find($mysqli, $id);
    }

    public static function update(mysqli $mysqli, int $id, ?string $name, ?string $author, ?string $description, ?int $category_id = null): bool
    {
        $fields = [];
        $params = [];
        $types = "";

        if ($name !== null) {
            $fields[] = "name = ?";
            $params[] = $name;
            $types .= "s";
        }
        if ($author !== null) {
            $fields[] = "author = ?";
            $params[] = $author;
            $types .= "s";
        }
        if ($description !== null) {
            $fields[] = "description = ?";
            $params[] = $description;
            $types .= "s";
        }
        if ($category_id !== null) {
            $fields[] = "category_id = ?";
            $params[] = $category_id;
            $types .= "i";
        }

        if (empty($fields)) return false;

        $sql = "UPDATE " . static::$table . " SET " . implode(", ", $fields) . " WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        $types .= "i";
        $params[] = $id;

        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public static function delete(mysqli $mysqli, int $id): bool
    {
        $stmt = $mysqli->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function deleteAll(mysqli $mysqli): bool
    {
        return $mysqli->query("DELETE FROM " . static::$table);
    }
}
