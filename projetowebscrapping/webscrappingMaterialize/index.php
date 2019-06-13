
<?php

header("Content-Type: application/json; charset=utf-8");
$cl = curl_init();
curl_setopt($cl, CURLOPT_URL,"https://balneabilidade.ima.sc.gov.br/relatorio/historico");
curl_setopt($cl, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($cl, CURLOPT_POST, true);
//curl_setopt($cl, CURLOPT_POSTFIELDS,'');
curl_setopt($cl, CURLOPT_POSTFIELDS,'municipioID=24&localID=40&ano=2019&redirect=true');
curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);

  $pagina=curl_exec($cl);


curl_close($cl);

//echo $pagina; ;
$html = new DOMDocument();
$html->loadHTML($pagina);
$html->preserveWhiteSpace = false;
 ///$html->saveHTML();
$tabelas = $html->getElementsByTagName('table');

foreach ($tabelas as $key => $value){
    if ($key % 2 !=0) {
      $pont = $tabelas->item($key)->getElementsByTagName('label');
      //$linha= $tabelas->item($key)->getElementsByTagName('td');
      //echo $pont[2]->nodeValue;
      if('Ponto de Coleta: Ponto 01'==$pont[2]->nodeValue){
        //echo ;
        $linhas = $tabelas->item($key+1)->getElementsByTagName('tr');
        foreach($linhas as $linha =>$val){
          $celulas = $val->getElementsByTagName('td');
          //$mydados[$linha][$i]=$val->nodeValue;
        // $i=0;
          foreach($celulas as $celula=> $valor) {
            $mydados[$linha][$celula]=$valor->nodeValue;
          
          
          }
        }
      }
	} 
}
echo json_encode($mydados);

//var_dump  ($mydados);"\n";

?>

