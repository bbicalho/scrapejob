<?php


// Baixa uma vez só e salva pra não ficar fazendo o mesmo request sempre

if(file_exists("unidas GetStores.json"))
{
	$json_string = file_get_contents("unidas GetStores.json");
}
else
{
	$json_string = file_get_contents("https://unidas.com.br/umbraco/surface/StoreCompress/GetStores");
	file_put_contents("unidas GetStores.json",$json_string);
}


$myarray = json_decode($json_string,true);

echo '<pre>';

echo '1 - '.count($myarray)."<BR>";
// echo '2 - '.count($myarray[0])."<BR>";
// echo '3 - '.count($myarray['agencias'])."<BR>";
// echo '4 - '.count($myarray['agencias'][0])."<BR>";
// echo '5 - '.count($myarray[0]['agencias'])."<BR>";

// print_r($myarray[0]['agencias']);
// print_r($myarray[0]);

echo '</pre>';

// die();

$final = $myarray;

$i = 0;


$header = array(
'Initial',
'CodeIATA',
'CodeICAO',
'ZipStoreOut',
'Description',
'FranchiseCode',
'Address',
'Name',
'Complement',
'Neighborhood',
'DescCounty',
'County',
'UFStoreOut',
'State',
'GeoCode',
'ServicePrice',
'Reference',
'AceptDevExpress',
'TimeStartOnWeek',
'TimeCloseOnWeek',
'Observation',
'TelStoreOut',
'Type',
'Rede',
'Latitude',
'Longitude',
'ChaveTraducao',
'LOJPSQ',
'ESTNOM',
'Distance');

$array_final = array();

foreach($final as $key=>$value)
{
	// ["aeroporto","codigoLocaliza","nome","telefone","whatsapp","latitude","longitude","enderecos","resumoHorariosFuncionamento","resumoExcecoesFuncionamento","agenciaParceiro","brasileira"]

	$linha = array();
	$linha['Initial'] = $value['Initial'];
	$linha['CodeIATA'] = $value['CodeIATA'];
	$linha['CodeICAO'] = $value['CodeICAO'];
	$linha['ZipStoreOut'] = $value['ZipStoreOut'];
	$linha['Description'] = $value['Description'];
	$linha['FranchiseCode'] = $value['FranchiseCode'];
	$linha['Address'] = $value['Address'];
	$linha['Name'] = $value['Name'];
	$linha['Complement'] = $value['Complement'];
	$linha['Neighborhood'] = $value['Neighborhood'];
	$linha['DescCounty'] = $value['DescCounty'];
	$linha['County'] = $value['County'];
	$linha['UFStoreOut'] = $value['UFStoreOut'];
	$linha['State'] = $value['State'];
	$linha['GeoCode'] = $value['GeoCode'];
	$linha['ServicePrice'] = $value['ServicePrice'];
	$linha['Reference'] = $value['Reference'];
	$linha['AceptDevExpress'] = $value['AceptDevExpress'];
	$linha['TimeStartOnWeek'] = $value['TimeStartOnWeek'];
	$linha['TimeCloseOnWeek'] = $value['TimeCloseOnWeek'];
	$linha['Observation'] = $value['Observation'];
	$linha['TelStoreOut'] = $value['TelStoreOut'];
	$linha['Type'] = $value['Type'];
	$linha['Rede'] = $value['Rede'];
	$linha['Latitude'] = $value['Latitude'];
	$linha['Longitude'] = $value['Longitude'];
	$linha['ChaveTraducao'] = $value['ChaveTraducao'];
	$linha['LOJPSQ'] = $value['LOJPSQ'];
	$linha['ESTNOM'] = $value['ESTNOM'];
	$linha['Distance'] = $value['Distance'];
	
	echo json_encode($linha).'<BR>';
	
	// $i++;
	
	// if($i > 5)
		// die();
	
	$array_final[] = $linha;
}


$fp = fopen('file.csv', 'w');

$BOM = "\xEF\xBB\xBF"; // UTF-8 BOM
fwrite($fp, $BOM);
            
fputcsv($fp, $header,";");
foreach ($array_final as $fields) {
    fputcsv($fp, $fields,";");
}

fclose($fp);

 // [aeroporto] => 1
            // [codigoLocaliza] => AAALT
            // [nome] => AGÊNCIA AEROPORTO - ALTA FLORESTA
            // [telefone] => 66 35212141
            // [whatsapp] => 08009792020
            // [latitude] => -9.87235
            // [longitude] => -56.105131
            // [enderecos] => Array
                // (
                    // [0] => Array
                        // (
                            // [tipo] => Retirada
                            // [logadouro] =>   JAIME VERISSIMO DE CAMPOS, S/N, AEROPORTO
                            // [cep] => 78580000
                            // [uf] => MT
                            // [cidade] => ALTA FLORESTA
                            // [codigoPais] => 0055
                        // )

                    // [1] => Array
                        // (
                            // [tipo] => Devolucao
                            // [logadouro] =>   JAIME VERISSIMO DE CAMPOS, S/N, AEROPORTO
                            // [cep] => 78580000
                            // [uf] => MT
                            // [cidade] => ALTA FLORESTA
                            // [codigoPais] => 0055
                        // )

                // )

            // [resumoHorariosFuncionamento] => Array
                // (
                    // [0] => Array
                        // (
                            // [diaSemana] => Segunda a Domingo
                            // [horarios] => Array
                                // (
                                    // [0] => Array
                                        // (
                                            // [inicio] => 12:00
                                            // [fim] => 13:00
                                        // )

                                // )

                            // [aberto24Horas] => 
                        // )

                    // [1] => Array
                        // (
                            // [diaSemana] => Feriado
                            // [horarios] => Array
                                // (
                                    // [0] => Array
                                        // (
                                            // [inicio] => 12:00
                                            // [fim] => 13:00
                                        // )

                                // )

                            // [aberto24Horas] => 
                        // )

                // )

            // [resumoExcecoesFuncionamento] => Array
                // (
                    // [abreNessesDias] => Array
                        // (
                            // [0] => Array
                                // (
                                    // [dia] => 2020-09-25T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [1] => Array
                                // (
                                    // [dia] => 2020-09-26T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [2] => Array
                                // (
                                    // [dia] => 2020-09-27T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [3] => Array
                                // (
                                    // [dia] => 2020-09-28T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [4] => Array
                                // (
                                    // [dia] => 2020-09-29T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [5] => Array
                                // (
                                    // [dia] => 2020-09-30T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [6] => Array
                                // (
                                    // [dia] => 2020-10-01T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [7] => Array
                                // (
                                    // [dia] => 2020-10-02T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [8] => Array
                                // (
                                    // [dia] => 2020-10-03T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [9] => Array
                                // (
                                    // [dia] => 2020-10-04T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [10] => Array
                                // (
                                    // [dia] => 2020-10-05T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [11] => Array
                                // (
                                    // [dia] => 2020-10-06T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [12] => Array
                                // (
                                    // [dia] => 2020-10-07T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [13] => Array
                                // (
                                    // [dia] => 2020-10-08T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [14] => Array
                                // (
                                    // [dia] => 2020-10-09T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [15] => Array
                                // (
                                    // [dia] => 2020-10-10T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [16] => Array
                                // (
                                    // [dia] => 2020-10-11T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [17] => Array
                                // (
                                    // [dia] => 2020-10-12T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [18] => Array
                                // (
                                    // [dia] => 2020-10-13T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [19] => Array
                                // (
                                    // [dia] => 2020-10-14T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [20] => Array
                                // (
                                    // [dia] => 2020-10-15T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [21] => Array
                                // (
                                    // [dia] => 2020-10-16T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [22] => Array
                                // (
                                    // [dia] => 2020-10-17T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [23] => Array
                                // (
                                    // [dia] => 2020-10-18T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [24] => Array
                                // (
                                    // [dia] => 2020-10-19T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [25] => Array
                                // (
                                    // [dia] => 2020-10-20T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [26] => Array
                                // (
                                    // [dia] => 2020-10-21T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [27] => Array
                                // (
                                    // [dia] => 2020-10-22T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [28] => Array
                                // (
                                    // [dia] => 2020-10-23T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [29] => Array
                                // (
                                    // [dia] => 2020-10-24T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [30] => Array
                                // (
                                    // [dia] => 2020-10-25T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [31] => Array
                                // (
                                    // [dia] => 2020-10-26T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [32] => Array
                                // (
                                    // [dia] => 2020-10-27T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [33] => Array
                                // (
                                    // [dia] => 2020-10-28T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [34] => Array
                                // (
                                    // [dia] => 2020-10-29T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [35] => Array
                                // (
                                    // [dia] => 2020-10-30T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                            // [36] => Array
                                // (
                                    // [dia] => 2020-10-31T00:00:00
                                    // [horarios] => Array
                                        // (
                                            // [0] => Array
                                                // (
                                                    // [inicio] => 12:00
                                                    // [fim] => 13:00
                                                // )

                                        // )

                                // )

                        // )

                // )

            // [agenciaParceiro] => 
            // [brasileira] => 1
        // )

?>
