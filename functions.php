<?php
function validateMenuType(string $type): bool{
    $menuTypes = ['header',
                  'footer'];
                  if(in_array($type, $menuTypes)){
                    return true;
                  }else{
                    return false;  
                  }
}

function getMenuType(string $type): array{
    $menu = [];
    if(validateMenuType($type)){
        if($type ==='header'){
          $menu = [ 
            'home' => [
            'name' => 'Domov',
            'path' => 'index.php',
          ],
          'portfolio' =>[
            'name'=> 'Portfólio',
            'path'=> 'portfolio.php',
          ],
          'qna' =>[
            'name'=> 'Q&A',
            'path'=> 'qna.php',
          ],
          'kontakt' =>[
            'name'=> 'Kontakt',
            'path'=> 'kontakt.php',
          ]
        ];  
        }
    }
    return $menu;
}

function printMenu(array $menu){
    foreach($menu as $menuName => $menuData){
        echo '<li><a href="'.$menuData['path'].'">'.$menuData['name'].'</a></li>';
    }
}

function preparePortfolio(int $numberOfRows = 2, int $numberOfCols = 4): array{ 
  $portfolio = [];
  $colIndex = 1;
  for($i = 1; $i <= $numberOfRows; $i++){
    for($j = 1; $j <= $numberOfCols; $j++){
      $portfolio[$i][$j] = $colIndex;
      $colIndex++;
    }
  }
  return $portfolio;
}

function finishPortfolio(){
  $portfolio = preparePortfolio();
  foreach($portfolio as $row => $col){
    echo '<div class="row">';
    foreach($col as $index){
      echo '<div class ="col-25 portfolio text-white text-center" id="portfolio-'.$index.'"> 
      Web stránka '.$index.' 
      </div>';
    }
    echo '</div>';
  }
}
?>