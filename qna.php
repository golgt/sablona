
<?php include_once "parts/header.php";?>
<?php include_once "parts/navbar.php"; ?>
<body>
  <main>
    <section class="banner">
      <div class="container text-white">
        <h1>Q&A</h1>
      </div>
    </section>
    <section class="container">
      <div class="row">
        <div class="col-100 text-center">
          <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam qui. Mollit deserunt culpa incididunt laborum commodo in culpa.</em></strong></p>
        </div>
      </div>
    </section>
     <center><form id="contact" method="post" action="db/spracovanieQnA.php">
      <input type="text" name="otazka" placeholder="Napíšte nám otázku" required> <br>
      <textarea name="odpoved" placeholder="Napíšte odpoved" required></textarea><br>
      <input type="submit" value="Odoslať">
    </form></center>
  <!--  <section class="container">
  <div class="accordion-container">-->
  <?php
      include_once "classes/QnA.php";
      use otazkyodpovede\QnA;

      $qna = new QnA();
      $qna -> vypisQnA();
    ?>
   
 <!-- </div>
</section>-->
  </main>
  <?php include_once "parts/footer.php";?>
<script src="js/accordion.js"></script>
<script src="js/menu.js"></script>
