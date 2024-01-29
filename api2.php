<?php 
$fData = file_get_contents("Data/json.json");
$arr1 = json_decode($fData);
$symData = json_decode(file_get_contents("Data/symbolsFinal.json"), true);


$resp = array();
$rescode = 0;
if(isset($_REQUEST) && isset($_REQUEST["constituency"]))
{
	$cnst = explode(" ",$_REQUEST["constituency"]);
	
	if(isset($cnst[0]) && !empty($cnst[0]))
	{
		$arr2 = array();
		foreach($arr1 as $ar)
		{
			$arr2[$ar->Constituency] = $ar;
		}
		if(array_key_exists($cnst[0], $arr2))
		{
			$rescode = 1;
			$resp["rescode"] = $rescode;
			$resp["message"] = "Record(s) found!";
			
			$dataArr = array();
			$dataArr["type"] = 1;
			$dataArr["constituency_id"] = "803045E4-E6AB-4D0B-BF59-19D5052F5BB2";
			$dataArr["record_id"] = "98F6F984-F89D-411B-9CFE-D6F526B2AE92";
			$dataArr["constituency"] = $arr2[$cnst[0]]->Constituency;
			$dataArr["candidate_name"] = $arr2[$cnst[0]]->Candidate;
			
			$dataArr["candidate_symbol"] = isset($symData[$arr2[$cnst[0]]->symbolfile])?"https://insaf-pk.com/election2024/assets/".$symData[$arr2[$cnst[0]]->symbolfile]: null;
			//$dataArr["candidate_symbol"] = null;
			$dataArr["candidate_image"] = null;
			$dataArr["symbol_name"] = str_replace("\\n\\n"," ",$arr2[$cnst[0]]->Symbol);
			//$dataArr["symbol_name"] = null;
			$dataArr["digit"] = 1;
			$resp["data"] = array($dataArr);
			$resp["extra"] = array();
			$resp["more"] = array();
			$resp["bin"] = array();
		}
		else
		{
			$resp["rescode"] = $rescode;
			$resp["message"] = "No record found!";
			$resp["data"] = array();
			$resp["extra"] = array();
			$resp["more"] = array();
			$resp["bin"] = array();
		}
	}
}
else
{
	$resp["rescode"] = $rescode;
	$resp["message"] = "constituency cannot be empty";
	$resp["data"] = array();
	$resp["extra"] = array();
	$resp["more"] = array();
	$resp["bin"] = array();
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resp);

?>