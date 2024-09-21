<?php
// view_posts.php
session_start();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Twitka - Пости</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Twitka</h1>
            <nav>
                <a href="index.html">Головна</a>
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="post.html">Створити Пост</a>
                    <a href="logout.php">Вийти</a>
                <?php else: ?>
                    <a href="register.html">Реєстрація</a>
                    <a href="login.html">Логін</a>
                <?php endif; ?>
                <a href="view_post.html">Пости</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Всі Пости</h2>
        <?php
            $tweets_file = 'tweets.csv';
            if (!file_exists($tweets_file)) {
                echo "<p>Немає постів.</p>";
            } else {
                $file = fopen($tweets_file, 'r');
                $header = fgetcsv($file);
                while (($row = fgetcsv($file)) !== FALSE) {
                    $tweet = array_combine($header, $row);
                    echo "<div class='post'>";
                    echo "<strong>" . htmlspecialchars($tweet['username']) . "</strong> (" . htmlspecialchars($tweet['timestamp']) . ")<br>";
                    echo nl2br(htmlspecialchars($tweet['content'])) . "<br>";
                    if (!empty($tweet['media_path'])) {
                        $media_ext = pathinfo($tweet['media_path'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($media_ext), ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<img src='" . htmlspecialchars($tweet['media_path']) . "' alt='Медіа'><br>";
                        } elseif (in_array(strtolower($media_ext), ['mp4', 'avi', 'mov'])) {
                            echo "<video width='320' height='240' controls>
                                    <source src='" . htmlspecialchars($tweet['media_path']) . "' type='video/" . htmlspecialchars($media_ext) . "'>
                                    Ваш браузер не підтримує відео тег.
                                  </video><br>";
                        }
                    }
                    echo "</div>";
                }
                fclose($file);
            }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Twitka. Всі права захищені.</p>
    </footer>
</body>
</html>