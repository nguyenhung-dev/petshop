<?php
require_once __DIR__ . '/../config/connectDB.php';

class Category
{
    private $dataManager;

    public function __construct()
    {
        $this->dataManager = databaseManager::getInstance();
    }

    public function createCategory($name, $title, $image = null)
    {
        $created_day = date('Y-m-d');
        $query = "INSERT INTO categories (name, title, created_day, image) VALUES ('$name', '$title', '$created_day', '$image')";
        return $this->dataManager->executeQuery($query);
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getValue($id, $currenId)
    {
        $query = "SELECT * FROM categories WHERE $id = $currenId";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getCategoryById($category_id)
    {
        $query = "SELECT * FROM categories WHERE category_id = $category_id";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_assoc() : null;
    }

    public function updateCategory($category_id, $name, $title, $image = null)
    {
        $query = "UPDATE categories SET name = '$name', title = '$title', image = '$image' WHERE category_id = $category_id";
        return $this->dataManager->executeQuery($query);
    }

    public function deleteCategoryById($category_id)
    {
        $query = "DELETE FROM categories WHERE category_id = $category_id";
        return $this->dataManager->executeQuery($query);
    }
}
?>