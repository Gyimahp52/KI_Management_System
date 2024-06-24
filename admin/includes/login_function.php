
<?php
function login($username, $password) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare('SELECT id, password, role FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        return $user['role'];
    } else {
        return false;
    }
}
?>