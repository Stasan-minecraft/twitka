<?php
// login.php
session_start();
$users_file = 'users.csv';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (file_exists($users_file)) {
        if (($handle = fopen($users_file, 'r')) !== FALSE) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== FALSE) {
                $user = array_combine($header, $data);
                if ($user['email'] === $email && password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.html");
                    exit;
                }
            }
            fclose($handle);
        }
    }

    echo "Невірний email або пароль.";
    exit;
} else {
    echo "Невірний запит.";
}
?>