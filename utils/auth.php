<?php
function signup($pdo, $data) {
    $username = htmlspecialchars($data['username']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $query = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($query->execute([$username, $password])) {
        return ["success" => true, "message" => "Utilisateur créé avec succès"];
    }
    return ["success" => false, "message" => "Erreur lors de l'inscription"];
}

function login($pdo, $data) {
    $username = htmlspecialchars($data['username']);
    $password = $data['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        return ["success" => true, "message" => "Connexion réussie"];
    }
    return ["success" => false, "message" => "Identifiants incorrects"];
}
?>