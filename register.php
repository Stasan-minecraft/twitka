<?php
// register.php
session_start();

// Define file paths
$users_file = 'users.csv';

// Hashing the password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Simple validation
    if (empty($username) || empty($email) || empty($password)) {
        echo "Всі поля обов'язкові.";
        exit;
    }

    // Check if the user exists
    if (file_exists($users_file)) {
        if (($handle = fopen($users_file, 'r')) !== FALSE) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== FALSE) {
                $user = array_combine($header, $data);
                if ($user['email'] === $email) {
                    echo "Користувач з таким email вже існує.";
                    fclose($handle);
                    exit;
                }
            }
            fclose($handle);
        }
    }

    // Hash password and save
    $hashed_password = hash_password($password);
    $new_user = [$username, $email, $hashed_password];
    $file = fopen($users_file, 'a');
    fputcsv($file, $new_user);
    fclose($file);

    // Redirect to login
    header("Location: login.html");
    exit;
} else {
    echo "Невірний запит.";
}
?>
