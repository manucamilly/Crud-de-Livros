<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: pink;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: white;
            background-color: #ff007f;
            padding: 10px;
            text-align: center;
        }

        form {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 500px;
            border-radius: 10px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
        }

        form input[type="text"],
        form input[type="number"],
        form select,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button[type="submit"] {
            background-color: #ff007f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            background-color: white;
            margin: 20px auto;
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #ff007f;
            color: white;
        }

        table td a {
            text-decoration: none;
            color: #ff007f;
            margin-right: 10px;
        }

        table td a.delete {
            color: red;
        }
    </style>
</head>
<body>
<?php
require_once('classes/livros.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;

        case 'read':
            $rows = $crud->read();
            break;

        case 'update':
            if (isset($_POST['id'])) {
                $crud->update($_POST);
            }
            $rows = $crud->read();
            break;

        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;

        default:
            $rows = $crud->read();
            break;
    }
} else {
    $rows = $crud->read();
}
?>

<h1>Biblioteca</h1>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $crud->readOne($id);

    if (!$result) {
        echo "<p>Registro não encontrado.</p>";
        exit();
    }
    $autor = $result['autor'];
    $isbn = $result['isbn'];
    $ano_publicacao = $result['ano_publicacao'];
    $genero = $result['genero'];
    $editora = $result['editora'];
    $quantidade_disponivel = $result['quantidade_disponivel'];
    $resenha = $result['resenha'];
    ?>

    <form action="?action=update" method="POST">
        <h2>Atualize o cadastro do seu Livro</h2>

        <input type="hidden" name="id" value="<?php echo $id ?>">

        <label for="autor">Nome do Autor</label>
        <input type="text" name="autor" value="<?php echo $autor ?>" placeholder="Nome do Autor" required>

        <label for="isbn">ISBN</label>
        <input type="number" name="isbn" value="<?php echo $isbn ?>" placeholder="Identificação do Livro" required>

        <label for="ano_publicacao">Ano de Publicação</label>
        <input type="date" name="ano_publicacao" value="<?php echo $ano_publicacao ?>" placeholder="Ano de Publicação" required>

        <label for="genero">Gênero</label>
        <select name="genero" required>
            <option value="Romance" <?php if ($genero === 'Romance') echo 'selected' ?>>Romance</option>
            <option value="Comédia" <?php if ($genero === 'Comédia') echo 'selected' ?>>Comédia</option>
            <option value="Terror" <?php if ($genero === 'Terror') echo 'selected' ?>>Terror</option>
            <option value="Fantasia" <?php if ($genero === 'Fantasia') echo 'selected' ?>>Fantasia</option>
            <option value="Ficção" <?php if ($genero === 'Ficção') echo 'selected' ?>>Ficção</option>
            <option value="Aventura" <?php if ($genero === 'Aventura') echo 'selected' ?>>Aventura</option>
            <option value="Poesia" <?php if ($genero === 'Poesia') echo 'selected' ?>>Poesia</option>
            <option value="Drama" <?php if ($genero === 'Drama') echo 'selected' ?>>Drama</option>
            <option value="Ação" <?php if ($genero === 'Ação') echo 'selected' ?>>Ação</option>
            <option value="Auto-Ajuda" <?php if ($genero === 'Auto-Ajuda') echo 'selected' ?>>Auto-Ajuda</option>
        </select>

        <label for="editora">Editora</label>
        <input type="text" name="editora" value="<?php echo $editora ?>" placeholder="Nome da Editora" required>

        <label for="quantidade_disponivel">Quantidade Disponível de Livros</label>
        <input type="number" name="quantidade_disponivel" value="<?php echo $quantidade_disponivel ?>" placeholder="Quantidade Disponível de Livros" required>

        <label for="resenha">Resenha do Livro</label>
        <textarea id="resenha" name="resenha" rows="5" required><?php echo $resenha ?></textarea>

        <button type="submit" name="enviar" onclick="return confirm('Tem certeza que deseja atualizar?')">ATUALIZAR</button>
    </form>

<?php

} else {

    ?>

    <form action="?action=create" method="POST">
        <h2>Cadastre seu Livro</h2>

        <label for="autor">Nome do Autor</label>
        <input type="text" name="autor" placeholder="Nome do Autor" required>

        <label for="isbn">ISBN</label>
        <input type="number" name="ISBN" placeholder="Identificação do Livro" required>

        <label for="ano_publicacao">Ano de Publicação</label>
        <input type="date" name="ano_publicacao" placeholder="Ano de Publicação" required>

        <label for="genero">Gênero</label>
        <select name="genero" required>
            <option value="Romance">Romance</option>
            <option value="Comédia">Comédia</option>
            <option value="Terror">Terror</option>
            <option value="Fantasia">Fantasia</option>
            <option value="Ficção">Ficção</option>
            <option value="Aventura">Aventura</option>
            <option value="Poesia">Poesia</option>
            <option value="Drama">Drama</option>
            <option value="Ação">Ação</option>
            <option value="Auto-Ajuda">Auto-Ajuda</option>
        </select>

        <label for="editora">Editora</label>
        <input type="text" name="editora" placeholder="Nome da Editora" required>

        <label for="quantidade_disponivel">Quantidade Disponível de Livros</label>
        <input type="number" name="quantidade_disponivel" placeholder="Quantidade Disponível de Livros" required>

        <label for="resenha">Resenha do Livro</label>
        <textarea id="resenha" name="resenha" rows="5" required></textarea>

        <button type="submit">CADASTRAR</button>
    </form>

<?php
}
?>

<table>
    <tr>
        <th>ID</th>
        <th>Autor</th>
        <th>ISBN</th>
        <th>Ano de Publicação</th>
        <th>Gênero</th>
        <th>Editora</th>
        <th>Quantidade Disponível de Livros</th>
        <th>Resenha</th>
        <th>Ações</th>
    </tr>

    <?php
    if (isset($rows)) {
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['autor'] . "</td>";
            echo "<td>" . $row['isbn'] . "</td>";
            echo "<td>" . $row['ano_publicacao'] . "</td>";
            echo "<td>" . $row['genero'] . "</td>";
            echo "<td>" . $row['editora'] . "</td>";
            echo "<td>" . $row['quantidade_disponivel'] . "</td>";
            echo "<td>" . $row['resenha'] . "</td>";
            echo "<td>";
            echo "<a href='?action=update&id=" . $row['id'] . "'>Editar</a>";
            echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja deletar esse cadastro?\")' class='delete'>Deletar</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>Não há cadastros a serem exibidos</td></tr>";
    }
    ?>
</table>

</body>
</html>
