<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/templates/header.php";

// @todo On doit appeler getArticale pour récupérer les articles et faire une boucle pour les afficher
$articles = getArticles($pdo);

?>

<h1>TechTrendz Actualités</h1>
<?php


?>
<div class="row text-center">
    <?php foreach($articles as $index=>$article): ?>

    <div class="col-md-4 my-2 d-flex">
        <div class="card">
            <img src="<?= $article["image"]; ?>" class="card-img-top" alt="<?= htmlspecialchars($article["title"]); ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($article["title"]); ?></h5>
                <a href="actualite.php?id=<?= $article["id"] ?>" class="btn btn-primary">Lire la suite</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php require_once __DIR__ . "/templates/footer.php"; ?>