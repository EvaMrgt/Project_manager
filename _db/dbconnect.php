<?php
class connexionDB {
    private $host    = 'localhost';
    private $name    = 'projectmanager'; 
    private $user    = 'root';       
    private $pass    = '';         
    private $connexion;
    function __construct($host = null, $name = null, $user = null, $pass = null){
        if($host != null){
            $this->host = $host;           
            $this->name = $name;           
            $this->user = $user;          
            $this->pass = $pass;
        }
        try{
            $this->connexion = new PDO('mysql:host='. $this->host . ';dbname=' . $this->name,
                $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8', 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }catch (PDOException $e){
            echo 'Erreur : Impossible de se connecter  à la BDD !'.$e;
            die();
        }
    }
    public function getConnection() {
        return $this->connexion;
    }

    public function initDb(){
        try {
            $conn = new PDO("mysql:host=$this->host", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("CREATE DATABASE IF NOT EXISTS $this->name");
            $conn->exec("USE $this->name");
            $conn->beginTransaction();
            $tables = [
                'user' => "CREATE TABLE IF NOT EXISTS user (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL UNIQUE,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    INDEX idx_email (email)
                )",
                'projets' => "CREATE TABLE IF NOT EXISTS projets (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            titre VARCHAR(255) NOT NULL,
                            description_courte TEXT NOT NULL,
                            image VARCHAR(255) NOT NULL,
                            user_id INT NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
                        )"
            ];
            $messages = [];
            foreach ($tables as $tableName => $createTableSql) {
                $checkTableSql = "SHOW TABLES LIKE '$tableName'";
                $tableExists = $conn->query($checkTableSql)->rowCount() > 0;
                if (!$tableExists) {
                    $conn->exec($createTableSql);
                    $messages[] = "Table '$tableName' créée avec succès.";
                } else {
                    $messages[] = "La table '$tableName' existe déjà.";
                }
            }
            $conn->commit();
            $_SESSION['message'] = implode("\n", $messages);
        } catch (PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
    }
}
$db = new connexionDB();
$conn = $db->getConnection();
$db->initDb();

?>