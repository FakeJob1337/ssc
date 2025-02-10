<?php
$dep = $_POST['departament'];
$deps = join("', '",$dep);
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT shtat.pr2, shtat.surname, shtat.job, duty.start, duty.end, duty.days_num, duty.remains_day FROM shtat LEFT JOIN duty ON duty.person_id = shtat.id  WHERE pr2 IN ('$deps') ORDER BY `surname` ASC ";
$result = $conn->query($sql);
$months_name = [ 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' ];
$mounth_array = [
	'января' => 4, 
	'февраля' => 4, 
	'марта' => 4, 
	'апреля' => 4, 
	'мая' => 5, 
	'июня' => 4, 
	'июля' => 5, 
	'августа' => 4, 
	'сентября' => 4, 
	'октября' => 5, 
	'ноября' => 4, 
	'декабря' => 5
];


function getWeeks($timestamp)
{
	$timestamp = strtotime($timestamp);
    $maxday    = date("t",$timestamp);
    $thismonth = getdate($timestamp);
    $timeStamp = mktime(0,0,0,$thismonth['mon'],1,$thismonth['year']);    //Create time stamp of the first day from the give date.
    $startday  = date('w',$timeStamp);    //get first day of the given month
    $day = $thismonth['mday'];
    $weeks = 0;
    $week_num = 0;

    for ($i=0; $i<($maxday+$startday); $i++) {
        if(($i % 7) == 0){
            $weeks++;
        }
        if($day == ($i - $startday + 1)){
            $week_num = $weeks;
        }
      }     
    return $week_num;
}

echo '<table class="iksweb">
	<thead>
		<tr>
			<td rowspan="2">подразделение</td>
			<td rowspan="2">должность</td>
			<td rowspan="2">фио</td>
			<td colspan="2">период отпуска</td>
			<td rowspan="2">кол-во дней</td>
			<td rowspan="2">Остаток дней отпуска</td>
			<td>Месяц</td>
			<td colspan="5">Январь</td>
			<td colspan="4">Февраль</td>
			<td colspan="4">Март</td>
			<td colspan="4">Апрель</td>
			<td colspan="4">Май</td>
			<td colspan="4">Июнь</td>
			<td colspan="5">Июль</td>
			<td colspan="4">Август</td>
			<td colspan="4">Сентябрь</td>
			<td colspan="5">Октябрь</td>
			<td colspan="4">Ноябрь</td>
			<td colspan="5">Декабрь</td>
		</tr>
		<tr>
			<td>начало</td>
			<td>конец</td>
			<td>Неделя</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
			<td>13</td>
			<td>14</td>
			<td>15</td>
			<td>16</td>
			<td>17</td>
			<td>18</td>
			<td>19</td>
			<td>20</td>
			<td>21</td>
			<td>22</td>
			<td>23</td>
			<td>24</td>
			<td>25</td>
			<td>26</td>
			<td>27</td>
			<td>28</td>
			<td>29</td>
			<td>30</td>
			<td>31</td>
			<td>32</td>
			<td>33</td>
			<td>34</td>
			<td>35</td>
			<td>36</td>
			<td>37</td>
			<td>38</td>
			<td>39</td>
			<td>40</td>
			<td>41</td>
			<td>42</td>
			<td>43</td>
			<td>44</td>
			<td>45</td>
			<td>46</td>
			<td>47</td>
			<td>48</td>
			<td>49</td>
			<td>50</td>
			<td>51</td>
			<td>52</td>
        </thead>';
echo '<tbody>';
        while($row = $result->fetch(PDO::FETCH_NAMED)){
			$Sweek = 0;
			$Eweek = 0;
			if (isset($row['start']) or isset($row['end'])) {
				$Sweek = date("W", strtotime($row['start']));
				$Eweek = date("W", strtotime($row['end']));
				$Sslice = substr($row['start'], 8);
				$Eslice = substr($row['end'], 8);
			}
			
        	echo '
                <tr>
                    <td>'.$row['pr2'].'</td>
                    <td>'.$row['job'].'</td>
                    <td>'.$row['surname'].'</td>
                    <td>'.$row['start'].'</td>
                    <td>'.$row['end'].'</td>
                    <td>'.$row['days_num'].'</td>
                    <td>'.$row['remains_day'].'</td>
                    <td></td> ';
			for ($i=1; $i <= 52; $i++) {
				if ($Sweek <= $i and $Eweek >= $i) {
					if ($Sweek == $i) {
						echo "<td week='$i' style='background: green;'>$Sslice</td> ";
					}
					elseif ($Eweek == $i) {
						echo "<td week='$i' style='background: green;'>$Eslice</td> ";
					}
					else {
						echo "<td week='$i' style='background: green;'></td> ";
					}
					$w_array[$i] += 1;
				}	
				else {
					echo "<td week='$i'></td> ";
				}
			}
			echo '</tr>'; 
        }
echo	'<tr>     
			<td>'.'Итого'.'</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td> ';  
for ($i=1; $i <= 52; $i++) {
	if ($w_array[$i]) {
		echo "<td week='$i'>$w_array[$i]</td> ";
	}
	else{
		echo "<td week='$i'></td> ";
	}
}
echo	'</tr>';  
echo '</tbody>';