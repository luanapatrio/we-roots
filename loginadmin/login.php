<?php
// Configurações do banco de dados
$servername = "localhost"; // ou o endereço do seu servidor
$username = "root";
$password = "";
$dbname = "weroots_db";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processar o formulário de login (se submetido)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["password"];
    $codigo_seguranca = $_POST["security-code"];

    

    // Sanitizar entradas (IMPORTANTE para segurança!)
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha); // Em produção, use password_hash() e password_verify()
    $codigo_seguranca = $conn->real_escape_string($codigo_seguranca);


    // Consultar o banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
       
        $row = $result->fetch_assoc();
        echo "acessou | " . var_dump($row) . var_dump(md5($senha)) . var_dump($codigo_seguranca);

        // Verificar senha (PRECISA DE MELHORIA EM PRODUÇÃO! Utilize password_verify())
        if (md5($senha) == $row["senha"] && $codigo_seguranca == $row["codigo_seguranca"]) {
            session_start();
            $_SESSION["usuario_logado"] = $email; // Armazena o email na sessão
            header("Location: ../gerenciamento/2-home-gerenciamento/gerenciamento.html"); // Redireciona para a página de gerenciamento
            exit();
        } else {
            $erro = "Senha ou código de segurança incorretos.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<!-- ... (Seu código HTML do formulário aqui, igual ao login.html, mas sem o link no botão) ... -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Administrador</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="imagens/logo.png" type="image/x-icon">
</head>
<body>
        <!-- Cabeçalho -->
        <header>
            <div class="header-container">
                <button class="menu-btn" aria-label="Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21" stroke="#2C5530" stroke-width="2" stroke-linecap="round"/>
                        <path d="M3 6H21" stroke="#2C5530" stroke-width="2" stroke-linecap="round"/>
                        <path d="M3 18H21" stroke="#2C5530" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                
                <div class="logo-container">
                    <img src="imagens/logo.png" alt="Logo" class="logo">
                </div>
                
                <div class="header-right">
                    <a href="/carrinho/carrinho.html" class="cart-icon" aria-label="Carrinho">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="#2C5530" stroke-width="2"/>
                            <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="#2C5530" stroke-width="2"/>
                            <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="#2C5530" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="#" class="user-icon" aria-label="Usuário">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#2C5530" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#2C5530" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </header>
    <main>
        <div class="login-container">
            <div class="login-box">
                <!-- Nova estrutura de formulário incluindo o PHP -->
                <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!-- ... (campos do formulário) ... -->
                    <h2>BEM-VINDO, ADMINISTRADOR</h2>
                    <label for="email">*E-mail ou CPF</label>
                    <input type="email" id="email" name="email" placeholder="E-mail ou CPF">

                    <label for="password">*Senha</label>
                    <input type="password" id="password" name="password" placeholder="Senha">

                    <label for="security-code">*Código de segurança</label>
                    <input type="password" id="security-code" name="security-code" placeholder="Código de segurança">
                    
                    <button type="submit" class="login-btn">ENTRAR</button>
                    <?php if (isset($erro)): ?>
                        <p style="color: red;"><?php echo $erro; ?></p>
                    <?php endif; ?>
                </form>

                <!-- 
                Estrutura de formulário antiga | html
                <form class="login-form">
                    <h2>BEM-VINDO, ADMINISTRADOR</h2>
                    <label for="email">*E-mail ou CPF</label>
                    <input type="email" id="email" name="email" placeholder="E-mail ou CPF">

                    <label for="password">*Senha</label>
                    <input type="password" id="password" name="password" placeholder="Senha">

                    <label for="security-code">*Código de segurança</label>
                    <input type="password" id="security-code" name="security-code" placeholder="Código de segurança">
                    
                    <button type="submit" class="login-btn"><a href="/gerenciamento/2-home-gerenciamento/gerenciamento.html">ENTRAR</a></button>
                </form> -->
            </div>
        </div>
    </main>
</body>

<!-- Até aqui -->

</html>