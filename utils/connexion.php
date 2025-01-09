<?php

function connexion($pdo, $data) {
    $email = htmlspecialchars($data['email']);
    $password = $data['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        return ["success" => true, "message" => "Connexion réussie"];
    }
    return ["success" => false, "message" => "Identifiants incorrects"];
}

?>