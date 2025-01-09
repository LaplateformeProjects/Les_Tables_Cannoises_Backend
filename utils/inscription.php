<?php

function inscription($pdo, $data) {
    $name = htmlspecialchars($data['name']);
    $first_name = htmlspecialchars($data['first_name']);
    $phone = htmlspecialchars($data['phone']);
    $email = htmlspecialchars($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    // Validation et conversion du rôle
    $role = htmlspecialchars($data['role']);
    $role = ($role === 'restaurateur') ? 1 : 0; // 1 pour restaurateur, 0 pour client

    // Insertion dans la base de données
    $query = $pdo->prepare("INSERT INTO users (name, first_name, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($query->execute([$name, $first_name, $phone, $email, $password, $role])) {
        return ["success" => true, "message" => "Utilisateur créé avec succès"];
    }
    return ["success" => false, "message" => "Erreur lors de l'inscription"];
}

?>
