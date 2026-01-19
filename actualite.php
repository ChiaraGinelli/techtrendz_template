<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/templates/header.php";

$error = false;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (is_numeric($id)) {
        $article = getArticleById($pdo, (int)$id);
        
        if (!$article) {
            $error = true;
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}
//@todo On doit récupérer l'id en paramètre d'url et appeler la fonction getArticleById récupérer l'article

?>

<?php if ($error):?>
        <div class="alert alert-danger" role="alert">
        Article introuvable
        </div>
    <?php else: ?>
<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <img src="<?= $article["image"] ?>" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?=htmlspecialchars($article["title"]);  ?> </h1>
        <p class="lead"><?=htmlspecialchars($article["content"]);  ?> </p>
    </div>
    <?php endif;?>
</div>


<?php require_once __DIR__ . "/templates/footer.php"; ?>