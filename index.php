<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_cliente = $_POST['nome_cliente'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data_servico = $_POST['data_servico'];
    $valor = $_POST['valor'];

    // Upload da foto do produto
    $foto_produto = '';
    if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] == 0) {
        $foto_nome = time() . '_' . $_FILES['foto_produto']['name'];
        $foto_caminho = 'uploads/' . $foto_nome;
        if (move_uploaded_file($_FILES['foto_produto']['tmp_name'], $foto_caminho)) {
            $foto_produto = $foto_caminho;
        }
    }

    // Inserção dos dados no banco
    $sql = "INSERT INTO servicos (nome_cliente, telefone, email, data_servico, valor, foto_produto)
            VALUES (:nome_cliente, :telefone, :email, :data_servico, :valor, :foto_produto)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_cliente' => $nome_cliente,
        ':telefone' => $telefone,
        ':email' => $email,
        ':data_servico' => $data_servico,
        ':valor' => $valor,
        ':foto_produto' => $foto_produto
    ]);

    echo "Serviço cadastrado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Serviço</title>
    <style>
        /* Estilos para centralizar e estilizar o formulário */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="cadastro_servico.php" method="post" enctype="multipart/form-data">
        <h2>Cadastro de Serviço</h2>
        
        <label for="nome_cliente">Nome do Cliente:</label>
        <input type="text" id="nome_cliente" name="nome_cliente" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="data_servico">Data do Serviço:</label>
        <input type="date" id="data_servico" name="data_servico" required>

        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" step="0.01" required>

        <label for="foto_produto">Foto do Produto:</label>
        <input type="file" id="foto_produto" name="foto_produto">

        <button type="submit">Cadastrar Serviço</button>
    </form>
</body>
</html>
