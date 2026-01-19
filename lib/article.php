<?php

function getArticleById(PDO $pdo, int $id): array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getArticles(PDO $pdo, ?int $limit = null, ?int $page = null): array|bool
{
    $sql = "SELECT * FROM articles ORDER BY id DESC";
    if ($limit !== null) {
        $page = $page ?? 1;
        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :limit OFFSET :offset";
    }
    $query = $pdo->prepare($sql);
    if ($limit !== null) {
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    }
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//$query->execute();
//$result = $query->fetchAll(PDO::FETCH_ASSOC);
//return $result;


function getTotalArticles(PDO $pdo): int|bool
{

    $query = $pdo->query("SELECT COUNT(*) FROM articles");
    return (int) $query->fetchColumn();
    /*
        @todo récupérer le nombre total d'article (avec COUNT)
    */

    //$result = $query->fetch(PDO::FETCH_ASSOC);
    //return $result['total'];
}

function saveArticle(PDO $pdo, string $title, string $content, ?string $image, int $category_id, ?int $id = null): bool
{
    if ($id === null) {
        $query = $pdo->prepare(" INSERT INTO articles (title, content, image, category_id) 
        VALUES (:title, :content, :image, :category_id) ");
        /*
            @todo si id est null, alors on fait une requête d'insection
        */
        //$query = ...
    } else {
        $query = $pdo->prepare(" 
        UPDATE articles 
        SET title = :title, 
        content = :content, 
        image = :image, 
        category_id = :category_id 
        WHERE id = :id ");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        /*
            @todo sinon, on fait un update
        */

        //$query = ...

        //$query->bindValue(':id', $id, $pdo::PARAM_INT);
    }
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':content', $content, PDO::PARAM_STR);
    $query->bindValue(':image', $image, PDO::PARAM_STR);
    $query->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    // @todo on bind toutes les valeurs communes

    return $query->execute();


    //return $query->execute();  
}

function deleteArticle(PDO $pdo, int $id): bool
{
    $query = $pdo->prepare(" DELETE FROM articles WHERE id = :id ");

    /*
        @todo Faire la requête de suppression
    */
    $query->bindValue(':id', $id, PDO::PARAM_INT);


    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
