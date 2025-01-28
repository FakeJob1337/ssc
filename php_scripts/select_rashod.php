<?php
$date = $_POST['date'];
$dep = $_POST['departament'];
$deps = join("', '",$dep);	
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `miss`, `duty`,`trip`,`hospital`,`ill`,`mission`,`other`,`layoff`,`arrest` FROM `rsz` WHERE `date` = '$date' AND `dep` IN ('$deps')";
$result = $conn->query($sql);
$military_array = [
	"conscripts"=> [
		"arrest"=> [
			"Ж"=> "0",
			'Всего' => '0',
		],
		'duty' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'trip' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'hospital'=> [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'ill' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'mission' => [
			'Всего' => '0',
			'Ж' => '0'
		],
		'layoff' => [
			'Всего' => '0',
			'Ж' => '0'
		], 
		'miss' => [
			'Всего'=> '0',
			'Ж'=> '0',
		]

	],
	'contractor'=> [
		"arrest"=> [
			"Ж"=> "0",
			'Всего' => '0',
		],
		'duty' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'trip' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'hospital'=> [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'ill' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'mission' => [
			'Всего' => '0',
			'Ж' => '0'
		],
		'layoff' => [
			'Всего' => '0',
			'Ж' => '0'
		], 
		'miss' => [
			'Всего'=> '0',
			'Ж'=> '0',
		]

	]
];

$data_array = [
	"Офицеры" => [
		"arrest"=> [
			"Ж"=> "0",
			'Всего' => '0',
		],
		'duty' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'trip' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'hospital'=> [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'ill' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'mission' => [
			'Всего' => '0',
			'Ж' => '0'
		],
		'layoff' => [
			'Всего' => '0',
			'Ж' => '0'
		], 
		'miss' => [
			'Всего'=> '0',
			'Ж'=> '0',
		]

	],

	"Прапорщики" => [
		"arrest"=> [
			"Ж"=> "0",
			'Всего' => '0',
		],
		'duty' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'trip' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'hospital'=> [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'ill' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'mission' => [
			'Всего' => '0',
			'Ж' => '0'
		],
		'layoff' => [
			'Всего' => '0',
			'Ж' => '0'
		], 
		'miss' => [
			'Всего'=> '0',
			'Ж'=> '0',
		]

	],
];
$g_reasons = [	
		"arrest"=> [
			"Ж"=> "0",
			'Всего' => '0',
		],
		'duty' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'trip' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'hospital'=> [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'ill' => [
			'Всего'=> '0',
			'Ж'=> '0',
		],
		'mission' => [
			'Всего' => '0',
			'Ж' => '0'
		],
		'layoff' => [
			'Всего' => '0',
			'Ж' => '0'
		], 
		'miss' => [
			'Всего'=> '0',
			'Ж'=> '0',
		]
];
while($row = $result->fetch(PDO::FETCH_NAMED)){
	foreach ($row as $key => $value) {	
		$id_array = explode(" ", $value);
		foreach ($id_array as $i => $id) {
			if ($value == null) {
				continue;
			}


			$sql = "SELECT `sr`, `sex`, `is_conscripts` FROM `shtat` WHERE `id` = '$id'";
			$id_result = $conn->query($sql);
			$person = $id_result->fetch(PDO::FETCH_NAMED);
			if ($person['sr'] == 'Солдаты и сержанты') {
				if ($person['is_conscripts']) {
					$military_array['conscripts'][$key]['Всего'] += 1;
					if ($key == "trip" || $key == "hospital" || $key == "ill" || $key == "arrest") {
						$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$id'";
						$surname_id_result = $conn->query($sql);
						$name_str = "";
						while ($surname = $surname_id_result->fetch(PDO::FETCH_NUM)) {
							foreach ($surname as $k => $v) {
								$name_str = $name_str." ".$v;
		
							}
							$military_array['conscripts'][$key]["surnames"] .= $name_str;
						}
		
					}
				} else{
					$military_array['contractor'][$key]['Всего'] += 1;
					if ($person['sex'] == 'Ж') {
						$military_array['contractor'][$key]['Ж'] += 1;
						$g_reasons[$key]['Ж'] += 1;
					}
					if ($key == "trip" || $key == "hospital" || $key == "ill" || $key == "arrest") {
						$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$id'";
						$surname_id_result = $conn->query($sql);
						$name_str = "";
						while ($surname = $surname_id_result->fetch(PDO::FETCH_NUM)) {
							foreach ($surname as $k => $v) {
								$name_str = $name_str." ".$v;
		
							}
							$military_array['contractor'][$key]["surnames"] .= $name_str;
						}
		
					}
				}
				$g_reasons[$key]['Всего'] += 1;
				continue;
			}
			if ($person['sex'] == 'Ж') {
				$data_array[$person['sr']][$key]['Ж'] += 1;
				$data_array[$person['sr']][$key]['Ж'] += $data_array[$person['sr']][$key][$person['sex']] ?? 0;
				$g_reasons[$key]['Ж'] += 1;
			}

			$data_array[$person['sr']][$key]['Всего'] += 1;
			$g_reasons[$key]['Всего'] += 1;
			if ($key == "trip" || $key == "hospital" || $key == "ill" || $key == "arrest") {
				$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$id'";
				$surname_id_result = $conn->query($sql);
				$name_str = "";
				while ($surname = $surname_id_result->fetch(PDO::FETCH_NUM)) {
					foreach ($surname as $k => $v) {
						$name_str = $name_str." ".$v;

					}
					$data_array[$person['sr']][$key]["surnames"] .= $name_str;
				}

			}
			$data_array[$person['sr']][$key]['Ж'] ??= 0;
			$data_array[$person['sr']][$key]['Всего'] ??= 0;
			$g_reasons[$key]['Ж'] ??= 0;
			$g_reasons[$key]['Всего'] ??= 0;
		}

	}
}
// УБРАТЬ ХАРДКОД
// Штат
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Офицеры' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$data_array["Офицеры"]["shtat"]['Всего'] = $spisok_result_j->fetch()[0];
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Прапорщики' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$data_array["Прапорщики"]["shtat"]['Всего'] = $spisok_result_j->fetch()[0];
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Солдаты и сержанты' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$military_array["conscripts"]["shtat"]['Всего'] = $spisok_result_j->fetch()[0];

// Список
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sex` = 'Ж' AND `sr` = 'Офицеры' AND `surname` != 'Вакант' AND `pr2` IN ('$deps')";
$spisok_result = $conn->query($sql);
$data_array['Офицеры']['spisok']['Ж'] = $spisok_result->fetch()[0];	
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Офицеры' AND `surname` != 'Вакант' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$data_array['Офицеры']['spisok']['Всего'] = $spisok_result_j->fetch()[0];
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sex` = 'Ж' AND `sr` = 'Прапорщики' AND `surname` != 'Вакант' AND `pr2` IN ('$deps')";
$spisok_result = $conn->query($sql);
$data_array['Прапорщики']['spisok']['Ж'] = $spisok_result->fetch()[0];	
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Прапорщики' AND `surname` != 'Вакант' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$data_array['Прапорщики']['spisok']['Всего'] = $spisok_result_j->fetch()[0];

$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sex` = 'Ж' AND `sr` = 'Солдаты и сержанты' AND `surname` != 'Вакант' AND `is_conscripts` = '1' AND `pr2` IN ('$deps') ";
$spisok_result = $conn->query($sql);
$military_array['conscripts']['spisok']['Ж'] = $spisok_result->fetch()[0];	
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Солдаты и сержанты' AND `surname` != 'Вакант' AND `is_conscripts` = '1' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$military_array['conscripts']['spisok']['Всего'] = $spisok_result_j->fetch()[0];
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sr` = 'Солдаты и сержанты' AND `surname` != 'Вакант' AND `is_conscripts` = '0' AND `pr2` IN ('$deps')";
$spisok_result_j = $conn->query($sql);
$military_array['contractor']['spisok']['Всего'] = $spisok_result_j->fetch()[0];
$sql = "SELECT COUNT(id) FROM `shtat` WHERE `sex` = 'Ж' AND `sr` = 'Солдаты и сержанты' AND `surname` != 'Вакант' AND `is_conscripts` = '0' AND `pr2` IN ('$deps')";
$spisok_result = $conn->query($sql);
$military_array['contractor']['spisok']['Ж'] = $spisok_result->fetch()[0];	


// На лицо
$data_array['Офицеры']['face']['Ж'] = $data_array['Офицеры']['spisok']['Ж'] - $data_array['Офицеры']['miss']['Ж'];
$data_array['Офицеры']['face']['Всего'] = $data_array['Офицеры']['spisok']['Всего'] - $data_array['Офицеры']['miss']['Всего'];

$data_array['Прапорщики']['face']['Ж'] = $data_array['Прапорщики']['spisok']['Ж'] - $data_array['Прапорщики']['miss']['Ж'];
$data_array['Прапорщики']['face']['Всего'] = $data_array['Прапорщики']['spisok']['Всего'] - $data_array['Прапорщики']['miss']['Всего'];

$military_array['conscripts']['face']['Ж'] = $military_array['conscripts']['spisok']['Ж'] - $military_array['conscripts']['miss']['Ж'];
$military_array['conscripts']['face']['Всего'] = $military_array['conscripts']['spisok']['Всего'] - $military_array['conscripts']['miss']['Всего'];
$military_array['contractor']['face']['Ж'] = $military_array['contractor']['spisok']['Ж'] - $military_array['contractor']['miss']['Ж'];
$military_array['contractor']['face']['Всего'] = $military_array['contractor']['spisok']['Всего'] - $military_array['contractor']['miss']['Всего'];

// % укомплектованности
echo '</thead>
		<tr>
			<td colspan="2" rowspan="3">Категории</td>
			<td colspan="2" rowspan="3">По штату</td>
			<td colspan="2" rowspan="2">По списку</td>
			<td colspan="2" rowspan="2">На лицо</td>
			<td colspan="2" rowspan="2">Отсутствуют</td>
			<td colspan="13">Причины отстутсвия</td>
			<td rowspan="3">Процент укомплектованность</td>
		</tr>
		<tr>
			<td colspan="2">Отпуск</td>
			<td colspan="2">Командировка</td>
			<td colspan="2">Госпиталь</td>
			<td colspan="2">С/ч(Больница)</td>
			<td colspan="2">Арест</td>
			<td colspan="2">Наряд</td>
			<td>Увольнение</td>
		</tr>
		<tr>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
		</tr>
        </thead>';

// Генерация табл военнослужащих
foreach ($data_array as $key => $value) {
	echo	'<tr>';
	echo	'<td colspan="2" rowspan="2" class="ans">'.$key.'</td>';
	echo	'<td colspan="2" rowspan="2 class="ans"> '.$value['shtat']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['spisok']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['spisok']['Ж'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['face']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['face']['Ж'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['miss']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['miss']['Ж'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['duty']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['duty']['Ж'].'</td>';
	echo	'<td class="ans">'.$value['trip']['Всего'].'</td>';
	echo	'<td class="ans">'.$value['trip']['Ж'].'</td>';
	echo	'<td class="ans">'.$value['hospital']['Всего'].'</td>';
	echo	'<td class="ans">'.$value['hospital']['Ж'].'</td>';
	echo	'<td class="ans">'.$value['ill']['Всего'].'</td>';
	echo	'<td class="ans">'.$value['ill']['Ж'].'</td>';
	echo	'<td class="ans">'.$value['arrest']['Всего'].'</td>';
	echo	'<td class="ans">'.$value['arrest']['Ж'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['mission']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['mission']['Ж'].'</td>';
	echo	'<td rowspan="2" class="ans">'.$value['layoff']['Всего'].'</td>';
	echo	'<td rowspan="2" class="ans">'. $value['spisok']['Всего'] / $value['shtat']['Всего'] * 100 .'</td>';
	echo'</tr>';
	echo'<tr>';
	echo	'<td colspan="2" class="ans">'.$value['trip']['surnames'].'</td>';
	echo	'<td colspan="2" class="ans">'.$value['hospital']['surnames'].'</td>';
	echo	'<td colspan="2" class="ans">'.$value['ill']['surnames'].'</td>';
	echo	'<td colspan="2" class="ans">'.$value['arrest']['surnames'].'</td>';
	echo'</tr>';
}

echo '<tr>';
	echo '<td rowspan="4">Солдаты и сержанты</td>';
	echo '<td rowspan="2">По контракту</td>';
	echo '<td colspan="2" rowspan="4">'. $military_array["conscripts"]["shtat"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array['contractor']['spisok']['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array['contractor']['spisok']['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["face"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["face"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["miss"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["miss"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["duty"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["duty"]['Ж'].'</td>';
	echo '<td>'. $military_array["contractor"]["trip"]['Всего'].'</td>';
	echo '<td>'. $military_array["contractor"]["trip"]['Ж'].'</td>';
	echo '<td>'. $military_array["contractor"]["hospital"]['Всего'].'</td>';
	echo '<td>'. $military_array["contractor"]["hospital"]['Ж'].'</td>';
	echo '<td>'. $military_array["contractor"]["ill"]['Всего'].'</td>';
	echo '<td>'. $military_array["contractor"]["ill"]['Ж'].'</td>';
	echo '<td>'. $military_array["contractor"]["arrest"]['Всего'].'</td>';
	echo '<td>'. $military_array["contractor"]["arrest"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["mission"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["mission"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["contractor"]["layoff"]['Всего'].'</td>';
	echo '<td rowspan="4">'. ($military_array['contractor']['spisok']['Всего'] + $military_array['conscripts']['spisok']['Всего']) / $military_array["conscripts"]["shtat"]['Всего'] * 100 .'</td>';
echo '</tr>';
echo '<tr>';
	echo '<td colspan="2">'. $military_array["contractor"]["trip"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["contractor"]["hospital"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["contractor"]["ill"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["contractor"]["arrest"]['surnames'].'</td>';
echo '</tr>';
echo '<tr>';
	echo '<td rowspan="2">По призыву</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["spisok"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["spisok"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["face"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["face"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["miss"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["miss"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["duty"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["duty"]['Ж'].'</td>';
	echo '<td>'. $military_array["conscripts"]["trip"]['Всего'].'</td>';
	echo '<td>'. $military_array["conscripts"]["trip"]['Ж'].'</td>';
	echo '<td>'. $military_array["conscripts"]["hospital"]['Всего'].'</td>';
	echo '<td>'. $military_array["conscripts"]["hospital"]['Ж'].'</td>';
	echo '<td>'. $military_array["conscripts"]["ill"]['Всего'].'</td>';
	echo '<td>'. $military_array["conscripts"]["ill"]['Ж'].'</td>';
	echo '<td>'. $military_array["conscripts"]["arrest"]['Всего'].'</td>';
	echo '<td>'. $military_array["conscripts"]["arrest"]['Ж'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["mission"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["mission"]['Всего'].'</td>';
	echo '<td rowspan="2">'. $military_array["conscripts"]["layoff"]['Всего'].'</td>';
echo '</tr>';
echo '<tr>';
	echo '<td colspan="2">'. $military_array["conscripts"]["trip"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["conscripts"]["hospital"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["conscripts"]["ill"]['surnames'].'</td>';
	echo '<td colspan="2">'. $military_array["conscripts"]["arrest"]['surnames'].'</td>';
echo '</tr>';



// Общий штат, список и лицо
$data_array['g_shtat'] = $data_array["Офицеры"]["shtat"]['Всего'] + $data_array["Прапорщики"]["shtat"]['Всего'] + $military_array["conscripts"]["shtat"]['Всего'];
$data_array['g_spisok']['Всего'] = $data_array["Офицеры"]["spisok"]['Всего'] + $data_array["Прапорщики"]["spisok"]['Всего'] + $military_array["conscripts"]["spisok"]['Всего'] + $military_array["contractor"]["spisok"]['Всего'];
$data_array['g_spisok']['Ж'] = $data_array["Офицеры"]["spisok"]['Ж'] + $data_array["Прапорщики"]["spisok"]['Ж'] + $military_array["conscripts"]["spisok"]['Ж'] + $military_array["contractor"]["spisok"]['Ж'];

$data_array['g_face']['Всего'] = $data_array["Офицеры"]["face"]['Всего'] + $data_array["Прапорщики"]["face"]['Всего'] + $military_array["conscripts"]["face"]['Всего'] + $military_array["contractor"]["face"]['Всего'];
$data_array['g_face']['Ж'] = $data_array["Офицеры"]["face"]['Ж'] + $data_array["Прапорщики"]["face"]['Ж'] + $military_array["conscripts"]["face"]['Ж'] + $military_array["contractor"]["face"]['Ж'];



// Итого военнослужащих
echo'<tr>';
	echo'<td colspan="2">Итого в/служащих</td>';
	echo'<td colspan="2">'.$data_array["g_shtat"].'</td>';
	echo'<td>'.$data_array['g_spisok']['Всего'].'</td>';
	echo'<td>'.$data_array['g_spisok']['Ж'].'</td>';
	echo'<td>'.$data_array['g_face']['Всего'].'</td>';
	echo'<td>'.$data_array['g_face']['Ж'].'</td>';
	echo'<td>'.$g_reasons['miss']['Всего'].'</td>';
	echo'<td>'.$g_reasons['miss']['Ж'].'</td>';
	echo'<td>'.$g_reasons['duty']['Всего'].'</td>';
	echo'<td>'.$g_reasons['duty']['Ж'].'</td>';
	echo'<td>'.$g_reasons['trip']['Всего'].'</td>';
	echo'<td>'.$g_reasons['trip']['Ж'].'</td>';
	echo'<td>'.$g_reasons['hospital']['Всего'].'</td>';
	echo'<td>'.$g_reasons['hospital']['Ж'].'</td>';
	echo'<td>'.$g_reasons['ill']['Всего'].'</td>';
	echo'<td>'.$g_reasons['ill']['Ж'].'</td>';
	echo'<td>'.$g_reasons['arrest']['Всего'].'</td>';
	echo'<td>'.$g_reasons['arrest']['Ж'].'</td>';
	echo'<td>'.$g_reasons['mission']['Всего'].'</td>';
	echo'<td>'.$g_reasons['mission']['Ж'].'</td>';
	echo'<td>'.$g_reasons['layoff']['Всего'].'</td>';
	echo'<td>'.$data_array['g_spisok']['Всего'] / $data_array["g_shtat"] * 100 .'</td>';
echo'</tr>';


'<table class="iksweb">  
    </thead>
		<tr>
			<td colspan="2" rowspan="3">Категории</td>
			<td colspan="2" rowspan="3">По штату</td>
			<td colspan="2" rowspan="2">По списку</td>
			<td colspan="2" rowspan="2">На лицо</td>
			<td colspan="2" rowspan="2">Отсутствуют</td>
			<td colspan="13">Причины отстутсвия</td>
			<td rowspan="3">Процент укомплектованность</td>
		</tr>
		<tr>
			<td colspan="2">Отпуск</td>
			<td colspan="2">Командировка</td>
			<td colspan="2">Госпиталь</td>
			<td colspan="2">С/ч(Больница)</td>
			<td colspan="2">Арест</td>
			<td colspan="2">Наряд</td>
			<td>Увольнение</td>
		</tr>
		<tr>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
			<td>В т. ч. женщин</td>
			<td>Всего</td>
		</tr>
        </thead>
        <tbody>  
		<tr>
			<td colspan="2" rowspan="2">Офицеры</td>
			<td colspan="2" rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2" rowspan="2">Прапорщики</td>
			<td colspan="2" rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td rowspan="4">Солдаты и сержанты</td>
			<td rowspan="2">По контракту</td>
			<td colspan="2" rowspan="4"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="4"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td rowspan="2">По призыву</td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">Итого в/служащих</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td rowspan="3">Гражданский персонал</td>
			<td>основной штат</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Штатное расписание</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Итого</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">ИТОГО за ССЦ</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Личный состав остающихся в ПДД</td>
			<td colspan="21" rowspan="2"></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Л/c в готовности
к действиям по предназначению</td>
			<td></td>
		</tr>
	</tbody>
</table>';