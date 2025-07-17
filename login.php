<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            header("Location: adm.php");
            exit;
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login - Administração</title>
    <style>
        /* Reset básico */
        * {
            box-sizing: border-box;
        }
        body {
            background: #121212;
            color: #eee;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #1e1e1e;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #f9a825;
            letter-spacing: 2px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: #2c2c2c;
            color: #eee;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            background: #3d3d3d;
            outline: none;
        }
        button {
            width: 100%;
            background: #f9a825;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 5px;
            font-weight: 700;
            color: #121212;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #c17900;
        }
        .error-message {
            background: #b00020;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            color: #fff;
        }
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off" novalidate>
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required autofocus />
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required />
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
