<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    /*
        @todo faire la requête d'insertion d'utilisateur et retourner $query->execute();
        Attention faire une requête préparer et à binder les paramètres
    */

    $query = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password)
                            VALUES (:first_name, :last_name, :email, :password)");
    $query->bindValue(':first_name', $first_name);
    $query->bindValue(':last_name', $last_name);
    $query->bindValue(':email', $email);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query->bindValue(':password', $hash);
    $result = $query->execute();
    return $result;
}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    /*
        @todo faire une requête qui récupère l'utilisateur par email et stocker le résultat dans user
        Attention faire une requête préparer et à binder les paramètres
    */



    /*
        @todo Si on a un utilisateur et que le mot de passe correspond (voir fonction  native password_verify)
              alors on retourne $user
              sinon on retourne false
    */


    // On tente de récupérer un utilisateur à partir de l'email
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindValue(":email", $email);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user["password"])) {
        //regénéré l'id de session (sécurité: fixation de session)
        session_regenerate_id(true);
        //On stocke l'email dans la session
        $_SESSION["email"] = $user["email"];
        return $user;
    }
    return false;
}
