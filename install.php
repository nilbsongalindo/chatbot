 <?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "chatbot";

try {
	//faz conexão com o mysql
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    //Cria o database

     $sql = "CREATE DATABASE chatbot";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";

    //cria a tabela
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE faq(
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    pergunta VARCHAR(512) NOT NULL,
    resposta VARCHAR(512) NOT NULL,
    reg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table MyGuests created successfully";
    }


catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>