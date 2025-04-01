<?php 
include_once "../classes/QnA.php";
use otazkyodpovede\QnA;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otazka = trim($_POST['otazka']);
    $odpoved = trim($_POST['odpoved']);

    if (!empty($otazka) && !empty($odpoved)) {
        $qna = new QnA();
        $qna->ulozOtazku($otazka, $odpoved);
    }
}

// Presmerovanie späť na hlavnú stránku po odoslaní formulára
header("Location: ../qna.php");
exit();
?>
