<?php
require_once("Model.php");

class Article extends Model
{

    private int $id;
    private string $name;
    private string $author;
    private string $description;

    protected static string $table = "articles";

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "author" => $this->author,
            "description" => $this->description
        ];
    }


    public static function create(mysqli $mysqli, string $name, string $author, string $description): Article
    {
        $stmt = $mysqli->prepare("INSERT INTO " . static::$table . " (name, author, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $author, $description);
        $stmt->execute();

        $id = $stmt->insert_id;
        return self::find($mysqli, $id);
    }

    public static function update(mysqli $mysqli, int $id, ?string $name, ?string $author, ?string $description): bool
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
