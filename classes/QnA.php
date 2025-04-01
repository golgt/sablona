<?php 
namespace otazkyodpovede;

use Exception;
use PDOException;
define('__ROOT__',dirname(dirname(__FILE__)));
require_once(__ROOT__.'/db/config.php');
use PDO;

class QnA{
    private $conn;
    public function __construct(){
        $this->connect();
    }
    private function connect(){ 
        $config = DATABASE;

        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
        try{
            $this ->conn = new PDO('mysql:host=' . $config['HOST'] . ';dbname=' . $config['DBNAME'] . ';port=' . $config['PORT'], $config['USER_NAME'], $config['PASSWORD'], $options);
        } catch(PDOException $e){
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }
    public function insertQnA(){
        try {
            $data = json_decode(file_get_contents(__ROOT__.'/data.json'), true);
            $otazky = $data["otazky"];
            $odpovede = $data["odpovede"];
    
            $this->conn->beginTransaction();
    
            $check_sql = "SELECT COUNT(*) FROM qna WHERE otazka = :otazka AND odpoved = :odpoved";
            $insert_sql = "INSERT INTO qna (otazka, odpoved) VALUES (:otazka, :odpoved)";
    
            $check_stmt = $this->conn->prepare($check_sql);
            $insert_stmt = $this->conn->prepare($insert_sql);
    
            for ($i = 0; $i < count($otazky); $i++) {
                $otazka = $otazky[$i];
                $odpoved = $odpovede[$i];
    
                // Kontrola, či už existuje
                $check_stmt->bindValue(':otazka', $otazka);
                $check_stmt->bindValue(':odpoved', $odpoved);
                $check_stmt->execute();
    
                if ($check_stmt->fetchColumn() == 0) { // Ak otázka neexistuje, vložíme ju
                    $insert_stmt->bindValue(':otazka', $otazka);
                    $insert_stmt->bindValue(':odpoved', $odpoved);
                    $insert_stmt->execute();
                }
            }
    
            $this->conn->commit();
            echo "Dáta boli vložené bez duplikátov.";
        } catch (Exception $e) {
            $this->conn->rollback();
            echo "Chyba pri vkladaní dát do databázy: " . $e->getMessage();
        }
    }
    
    public function vypisQnA(){
        try{                                             //funkcia na vypisanie qna
            $sql = "SELECT otazka, odpoved FROM qna";
            $statement = $this ->conn -> query($sql);

            echo"<ul>";
            while($row = $statement -> fetch()){
                echo"<li><strong>Otázka: </strong>" . htmlspecialchars($row['otazka']) . "</li>";
                echo"<li><strong>Odpoveď: </strong>" . htmlspecialchars($row['odpoved']) . "</li>";
            }
            echo "</ul>";
        } catch(PDOException $e){
            die("Chyba pri načítaní údajov: " . $e->getMessage());
        } finally{ $this ->conn = null; }
    }
    public function ulozOtazku($otazka, $odpoved){
        $check_sql = "SELECT COUNT(*) FROM qna WHERE otazka = :otazka AND odpoved = :odpoved";  //kontrola ci existuje
        $stmt = $this -> conn -> prepare($check_sql);
        $stmt -> bindValue(":otazka", $otazka);                                                 
        $stmt -> bindValue(":odpoved", $odpoved);
        $stmt -> execute();

        if($stmt -> fetchColumn() == 0){          //ak toazka a odpoved neexistuju vllozia sa do db
            $insert_sql = "INSERT INTO qna (otazka,odpoved) VALUES (:otazka, :odpoved)";
            $insert_stmt = $this -> conn -> prepare($insert_sql);
            $insert_stmt -> bindValue(":otazka", $otazka);
            $insert_stmt -> bindValue(":odpoved", $odpoved);
            $insert_stmt -> execute();
            echo "Uspene pridane";
        } else {
            echo "Otazka a odpoved sa tu uz nachadzajú!";
        }
    }
    public function spracovanieForm(){
        try{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              $otazka = $_POST['otazka'];
              $odpoved = $_POST['odpoved'];
              
              $this -> ulozOtazku( $otazka, $odpoved);
            }
        }catch(PDOException $e){
            die("Chyba pripojenia" . $e->getMessage());
        }
    }
}
?>