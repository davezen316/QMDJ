<?php
	date_default_timezone_set("Asia/Kuala_Lumpur");
	if(isset($_GET['txt_date']) and isset($_GET['hour']) and isset($_GET['minute'])){
		$date = $_GET['txt_date'];
		$min = $_GET['minute'];
		$hour = ($_GET['hour'] == "00"? "24" : $_GET['hour']);
		$hour24 = $_GET['hour'];
		$time = $hour24 . ":" . $min . ":00";
		//echo $_GET['txt_date'] . $time;

		try{
			//$link = mysqli_connect("localhost", "mykerjay_fsadmin", "p@ssw0rd", "mykerjay_fengshui") or die("Error " . mysql_errno($link));
			$link = mysqli_connect("mykerjaya.my", "mykerjay_fsadmin", "p@ssw0rd", "mykerjay_fengshui") or die("Error " . mysql_errno($link));
			mysqli_set_charset($link, "utf8");

			$query = "select * from day where gregorian = '" . $date . "'" ;
			//printf($query);
			$day_result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
			while($row = mysqli_fetch_array($day_result)){
				$id_day = $row["id_day"];
				$day_chinese = $row["chinese"];
				//echo "id:".$id_day.'<br>';
			}

			//retrieval of structure
			if(isset($id_day)){
				$query = "select day.chinese AS counter, yy.char AS yin_yang , qimen_num from day left join yin_yang yy ON day.qimen_yin_yang = yy.id_yin_yang where day.id_day = $id_day";
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					if($row['yin_yang'] == 'Yang'){
						$structure_no = '<font color = "red">'.$row['yin_yang'] . " " . $row['qimen_num'].'</font>';
					}
					else{
						$structure_no = $row['yin_yang'] . " " . $row['qimen_num'];
					}
					$structure_yin_yang = $row['yin_yang'];

					$qimen_no = $row['qimen_num'];
					$day_counter = $row['counter'];

					if ($row['yin_yang'] == 'Yin'){
						$query = "select position, sequence, hs.chinese from earth_plate_nine_yin_structure nys left join heavenly_stem hs on nys.heaven = hs.id_heavenly_stem where no_structure = $qimen_no order by position";
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						$structure = array();
						while($row = mysqli_fetch_assoc($result)){
							$structure[] = $row;
						}
					}
					else{
						$query = "SELECT position, sequence, hs.chinese FROM earth_plate_nine_yang_structure nys LEFT JOIN heavenly_stem hs ON nys.heaven = hs.id_heavenly_stem WHERE no_structure = $qimen_no ORDER BY position";
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						$structure = array();
						while($row = mysqli_fetch_assoc($result)){
							$structure[] = $row;
						}
					}
				}
				$id_month_query = "select id_month from ten_thousand_years where id_day =" . $id_day;
				$month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($month_result)){
					$id_month = $row["id_month"];
					$id_month_static = $row["id_month"];
					//echo "month:".$id_month.'<br>';
				}
				
				$id_month_trans_query = "select season_second_trans_period, season_second_trans_time from month where id_month = $id_month;";
				$trans_result = mysqli_query($link, $id_month_trans_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($trans_result)){
					$trans_day = $row["season_second_trans_period"];
					$trans_time =  $row["season_second_trans_time"];
				}
				//-------dummy---------------
				$month_info_query = "select season_first_trans_period,  season_second_trans_period, season_first_trans_time, season_second_trans_time, heaven, earth from month where id_month = $id_month";
				$month_info_result = mysqli_query($link, $month_info_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($month_info_result)){
					$first_day = $row["season_first_trans_period"];
					$second_day = $row["season_second_trans_period"];
					$first_time = $row["season_first_trans_time"];
					$second_time = $row["season_second_trans_time"];
					$month_earth_id = $row["earth"];
				}
				
				$first_gregorian_query = "select gregorian from day left join ten_thousand_years tty on day.id_day = tty.id_day where tty.id_month = $id_month and chinese = $first_day";
				$first_gregorian_result = mysqli_query($link, $first_gregorian_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($first_gregorian_result)){
					$first_gregorian = $row["gregorian"];
					$first_gregorian_month = date('m',strtotime($first_gregorian));
					$first_greorian_day = date('d', strtotime($first_gregorian));
				}
				
				if(!empty($second_day)){
					$second_gregorian_query = "select gregorian from day left join ten_thousand_years tty on day.id_day = tty.id_day where tty.id_month = $id_month and chinese = $second_day";
					$second_gregorian_result = mysqli_query($link, $second_gregorian_query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($second_gregorian_result)){
						$second_gregorian = $row["gregorian"];
						$second_gregorian_month = date('m',strtotime($second_gregorian));
						$second_greorian_day = date('d', strtotime($second_gregorian));
					}
					switch ($first_gregorian_month){
						case '01':
							if($first_greorian_day == '04'){
								$first_transition = true;
								$transition_earth = '2';
								$transition_day = '04';
							}
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '2';
								$transition_day = '05';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '2';
								$transition_day = '06';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '2';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '2';
								$transition_day = '08';
							}
							break;
						case '02':
							if($first_greorian_day == '03'){
								$first_transition = true;
								$transition_earth = '3';
								$transition_day = '03';
							}
							if($first_greorian_day == '04'){
								$first_transition = true;
								$transition_earth = '3';
								$transition_day = '04';
							}
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '3';
								$transition_day = '05';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '3';
								$transition_day = '06';
							}
							break;
						case '03':
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '4';
								$transition_day = '04';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '4';
								$transition_day = '05';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '4';
								$transition_day = '06';
							}
							break;
						case '04':
							if($first_greorian_day == '04'){
								$first_transition = true;
								$transition_earth = '5';
								$transition_day = '04';
							}
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '5';
								$transition_day = '05';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '5';
								$transition_day = '06';
							}
							break;
						case '05':
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '6';
								$transition_day = '05';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '6';
								$transition_day = '06';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '6';
								$transition_day = '07';
							}
							break;
						case '06':
							if($first_greorian_day == '05'){
								$first_transition = true;
								$transition_earth = '7';
								$transition_day = '05';
							}
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '7';
								$transition_day = '06';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '7';
								$transition_day = '07';
							}
							break;
						case '07':
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '8';
								$transition_day = '06';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '8';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '8';
								$transition_day = '08';
							}
							break;
						case '08':
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '9';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '9';
								$transition_day = '08';
							}
							if($first_greorian_day == '09'){
								$first_transition = true;
								$transition_earth = '9';
								$transition_day = '09';
							}
							break;
						case '09':
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '10';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '10';
								$transition_day = '08';
							}
							if($first_greorian_day == '09'){
								$first_transition = true;
								$transition_earth = '10';
								$transition_day = '09';
							}
							break;
						case '10':
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '11';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '11';
								$transition_day = '08';
							}
							if($first_greorian_day == '09'){
								$first_transition = true;
								$transition_earth = '11';
								$transition_day = '09';
							}
							break;
						case '11':
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '12';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '12';
								$transition_day = '08';
							}
							if($first_greorian_day == '09'){
								$first_transition = true;
								$transition_earth = '12';
								$transition_day = '09';
							}
							break;
						case '12':
							if($first_greorian_day == '06'){
								$first_transition = true;
								$transition_earth = '1';
								$transition_day = '06';
							}
							if($first_greorian_day == '07'){
								$first_transition = true;
								$transition_earth = '1';
								$transition_day = '07';
							}
							if($first_greorian_day == '08'){
								$first_transition = true;
								$transition_earth = '1';
								$transition_day = '08';
							}
							break;
					}

					switch ($second_gregorian_month){
						case '01':
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '2';
								$transition_day = '05';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '2';
								$transition_day = '06';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '2';
								$transition_day = '07';
							}
							break;
						case '02':
							if($second_greorian_day == '04'){
								$first_transition = false;
								$transition_earth = '3';
								$transition_day = '04';
							}
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '3';
								$transition_day = '05';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '3';
								$transition_day = '06';
							}
							break;
						case '03':
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '4';
								$transition_day = '04';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '4';
								$transition_day = '05';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '4';
								$transition_day = '06';
							}
							break;
						case '04':
							if($second_greorian_day == '04'){
								$first_transition = false;
								$transition_earth = '5';
								$transition_day = '04';
							}
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '5';
								$transition_day = '05';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '5';
								$transition_day = '06';
							}
							break;
						case '05':
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '6';
								$transition_day = '05';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '6';
								$transition_day = '06';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '6';
								$transition_day = '07';
							}
							break;
						case '06':
							if($second_greorian_day == '05'){
								$first_transition = false;
								$transition_earth = '7';
								$transition_day = '05';
							}
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '7';
								$transition_day = '06';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '7';
								$transition_day = '07';
							}
							break;
						case '07':
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '8';
								$transition_day = '06';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '8';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '8';
								$transition_day = '08';
							}
							break;
						case '08':
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '9';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '9';
								$transition_day = '08';
							}
							if($second_greorian_day == '09'){
								$first_transition = false;
								$transition_earth = '9';
								$transition_day = '09';
							}
							break;
						case '09':
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '10';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '10';
								$transition_day = '08';
							}
							if($second_greorian_day == '09'){
								$first_transition = false;
								$transition_earth = '10';
								$transition_day = '09';
							}
							break;
						case '10':
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '11';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '11';
								$transition_day = '08';
							}
							if($second_greorian_day == '09'){
								$first_transition = false;
								$transition_earth = '11';
								$transition_day = '09';
							}
							break;
						case '11':
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '12';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '12';
								$transition_day = '08';
							}
							if($second_greorian_day == '09'){
								$first_transition = false;
								$transition_earth = '12';
								$transition_day = '09';
							}
							break;
						case '12':
							if($second_greorian_day == '06'){
								$first_transition = false;
								$transition_earth = '1';
								$transition_day = '06';
							}
							if($second_greorian_day == '07'){
								$first_transition = false;
								$transition_earth = '1';
								$transition_day = '07';
							}
							if($second_greorian_day == '08'){
								$first_transition = false;
								$transition_earth = '1';
								$transition_day = '08';
							}
							break;
					}

					if($first_transition == true){
						$trans_day = $first_day;
						$trans_time = $first_time;
					}
					else{
						$trans_day = $second_day;
						$trans_time = $second_time;
					}
				}

				else{
					$trans_day = $first_day;
					$trans_time = $first_time;
				}

				//---------------------------
				if($id_month > 191001){
					$id_month_query = "select id_month from month where id_month = (select max(id_month) from month where id_month < $id_month)";
					$month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($month_result)){
						$id_month = $row["id_month"];
						//echo "month:".$id_month.'<br>';
					}
				}

				if($day_counter >= $trans_day){
					//print_r("yes".$trans_day);
					if($day_counter == $trans_day){
						if($time >= $trans_time){
							switch ($id_month) {
							    case '193060':
							        $id_month_query = "select id_month from month where id_month = 193007";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '193012':
							        $id_month_query = "select id_month from month where id_month = 193101";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '193350':
							        $id_month_query = "select id_month from month where id_month = 193306";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '193312':
							        $id_month_query = "select id_month from month where id_month = 193401";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '193630':
							        $id_month_query = "select id_month from month where id_month = 193604";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '193612':
							        $id_month_query = "select id_month from month where id_month = 193701";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '193870':
							        $id_month_query = "select id_month from month where id_month = 193808";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '193812':
							        $id_month_query = "select id_month from month where id_month = 193901";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '194160':
							        $id_month_query = "select id_month from month where id_month = 194107";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '194112':
							        $id_month_query = "select id_month from month where id_month = 194201";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '194440':
							        $id_month_query = "select id_month from month where id_month = 194405";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '194412':
							        $id_month_query = "select id_month from month where id_month = 194501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '194720':
							        $id_month_query = "select id_month from month where id_month = 194703";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '194412':
							        $id_month_query = "select id_month from month where id_month = 194501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '194970':
							        $id_month_query = "select id_month from month where id_month = 194908";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '194912':
							        $id_month_query = "select id_month from month where id_month = 195001";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '195250':
							        $id_month_query = "select id_month from month where id_month = 195206";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '195212':
							        $id_month_query = "select id_month from month where id_month = 195301";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '195530':
							        $id_month_query = "select id_month from month where id_month = 195504";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '195512':
							        $id_month_query = "select id_month from month where id_month = 195601";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '195780':
							        $id_month_query = "select id_month from month where id_month = 195709";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '195712':
							        $id_month_query = "select id_month from month where id_month = 195801";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '196060':
							        $id_month_query = "select id_month from month where id_month = 196007";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '196012':
							        $id_month_query = "select id_month from month where id_month = 196101";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '196340':
							        $id_month_query = "select id_month from month where id_month = 196305";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '196312':
							        $id_month_query = "select id_month from month where id_month = 196401";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '196630':
							        $id_month_query = "select id_month from month where id_month = 196604";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '196612':
							        $id_month_query = "select id_month from month where id_month = 196701";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '196870':
							        $id_month_query = "select id_month from month where id_month = 196808";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '196812':
							        $id_month_query = "select id_month from month where id_month = 196901";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '197150':
							        $id_month_query = "select id_month from month where id_month = 197106";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '197112':
							        $id_month_query = "select id_month from month where id_month = 197201";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '197440':
							        $id_month_query = "select id_month from month where id_month = 197405";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '197412':
							        $id_month_query = "select id_month from month where id_month = 197501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '197680':
							        $id_month_query = "select id_month from month where id_month = 197609";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '197612':
							        $id_month_query = "select id_month from month where id_month = 197701";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '197960':
							        $id_month_query = "select id_month from month where id_month = 197907";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '197912':
							        $id_month_query = "select id_month from month where id_month = 198001";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '198240':
							        $id_month_query = "select id_month from month where id_month = 198205";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '198212':
							        $id_month_query = "select id_month from month where id_month = 198301";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '198760':
							        $id_month_query = "select id_month from month where id_month = 198707";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '198712':
							        $id_month_query = "select id_month from month where id_month = 198801";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '199050':
							        $id_month_query = "select id_month from month where id_month = 199006";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '199012':
							        $id_month_query = "select id_month from month where id_month = 199101";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '199330':
							        $id_month_query = "select id_month from month where id_month = 199304";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '199312':
							        $id_month_query = "select id_month from month where id_month = 199401";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '199580':
							        $id_month_query = "select id_month from month where id_month = 199509";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '199512':
							        $id_month_query = "select id_month from month where id_month = 199601";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '199850':
							        $id_month_query = "select id_month from month where id_month = 199806";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '199812':
							        $id_month_query = "select id_month from month where id_month = 199901";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '200140':
							        $id_month_query = "select id_month from month where id_month = 200105";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '200112':
							        $id_month_query = "select id_month from month where id_month = 200201";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '200420':
							        $id_month_query = "select id_month from month where id_month = 200403";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '200412':
							        $id_month_query = "select id_month from month where id_month = 200501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '200670':
							        $id_month_query = "select id_month from month where id_month = 200608";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '200612':
							        $id_month_query = "select id_month from month where id_month = 200701";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '200950':
							        $id_month_query = "select id_month from month where id_month = 200906";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '200912':
							        $id_month_query = "select id_month from month where id_month = 201001";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '201240':
							        $id_month_query = "select id_month from month where id_month = 201205";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '201212':
							        $id_month_query = "select id_month from month where id_month = 201301";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '201490':
							        $id_month_query = "select id_month from month where id_month = 201410";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '201412':
							        $id_month_query = "select id_month from month where id_month = 201501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '201760':
							        $id_month_query = "select id_month from month where id_month = 201707";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '201712':
							        $id_month_query = "select id_month from month where id_month = 201801";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '202040':
							        $id_month_query = "select id_month from month where id_month = 202005";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '202012':
							        $id_month_query = "select id_month from month where id_month = 202101";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '202320':
							        $id_month_query = "select id_month from month where id_month = 202303";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '202312':
							        $id_month_query = "select id_month from month where id_month = 202401";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '202560':
							        $id_month_query = "select id_month from month where id_month = 202507";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '202512':
							        $id_month_query = "select id_month from month where id_month = 202601";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '202850':
							        $id_month_query = "select id_month from month where id_month = 202806";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '202812':
							        $id_month_query = "select id_month from month where id_month = 202901";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    case '1984100':
							        $id_month_query = "select id_month from month where id_month = 198411";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;
							    case '198412':
							        $id_month_query = "select id_month from month where id_month = 198501";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							        }
							        break;

							    default:
							        $id_month_query = "select id_month from month where id_month = (select min(id_month) from month where id_month > $id_month)";
							        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
							        while($row = mysqli_fetch_array($month_result)){
							            $id_month = $row["id_month"];
							            //echo "month:".$id_month.'<br>';
							        }
							}
						}
					}
					else{
						switch ($id_month) {
						    case '193060':
						        $id_month_query = "select id_month from month where id_month = 193007";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '193012':
						        $id_month_query = "select id_month from month where id_month = 193101";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '193350':
						        $id_month_query = "select id_month from month where id_month = 193306";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '193312':
						        $id_month_query = "select id_month from month where id_month = 193401";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '193630':
						        $id_month_query = "select id_month from month where id_month = 193604";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '193612':
						        $id_month_query = "select id_month from month where id_month = 193701";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '193870':
						        $id_month_query = "select id_month from month where id_month = 193808";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '193812':
						        $id_month_query = "select id_month from month where id_month = 193901";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '194160':
						        $id_month_query = "select id_month from month where id_month = 194107";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '194112':
						        $id_month_query = "select id_month from month where id_month = 194201";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '194440':
						        $id_month_query = "select id_month from month where id_month = 194405";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '194412':
						        $id_month_query = "select id_month from month where id_month = 194501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '194720':
						        $id_month_query = "select id_month from month where id_month = 194703";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '194412':
						        $id_month_query = "select id_month from month where id_month = 194501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '194970':
						        $id_month_query = "select id_month from month where id_month = 194908";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '194912':
						        $id_month_query = "select id_month from month where id_month = 195001";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '195250':
						        $id_month_query = "select id_month from month where id_month = 195206";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '195212':
						        $id_month_query = "select id_month from month where id_month = 195301";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '195530':
						        $id_month_query = "select id_month from month where id_month = 195504";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '195512':
						        $id_month_query = "select id_month from month where id_month = 195601";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '195780':
						        $id_month_query = "select id_month from month where id_month = 195709";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '195712':
						        $id_month_query = "select id_month from month where id_month = 195801";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '196060':
						        $id_month_query = "select id_month from month where id_month = 196007";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '196012':
						        $id_month_query = "select id_month from month where id_month = 196101";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '196340':
						        $id_month_query = "select id_month from month where id_month = 196305";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '196312':
						        $id_month_query = "select id_month from month where id_month = 196401";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '196630':
						        $id_month_query = "select id_month from month where id_month = 196604";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '196612':
						        $id_month_query = "select id_month from month where id_month = 196701";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '196870':
						        $id_month_query = "select id_month from month where id_month = 196808";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '196812':
						        $id_month_query = "select id_month from month where id_month = 196901";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '197150':
						        $id_month_query = "select id_month from month where id_month = 197106";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '197112':
						        $id_month_query = "select id_month from month where id_month = 197201";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '197440':
						        $id_month_query = "select id_month from month where id_month = 197405";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '197412':
						        $id_month_query = "select id_month from month where id_month = 197501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '197680':
						        $id_month_query = "select id_month from month where id_month = 197609";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '197612':
						        $id_month_query = "select id_month from month where id_month = 197701";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '197960':
						        $id_month_query = "select id_month from month where id_month = 197907";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '197912':
						        $id_month_query = "select id_month from month where id_month = 198001";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '198240':
						        $id_month_query = "select id_month from month where id_month = 198205";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '198212':
						        $id_month_query = "select id_month from month where id_month = 198301";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '198760':
						        $id_month_query = "select id_month from month where id_month = 198707";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '198712':
						        $id_month_query = "select id_month from month where id_month = 198801";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '199050':
						        $id_month_query = "select id_month from month where id_month = 199006";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '199012':
						        $id_month_query = "select id_month from month where id_month = 199101";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '199330':
						        $id_month_query = "select id_month from month where id_month = 199304";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '199312':
						        $id_month_query = "select id_month from month where id_month = 199401";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '199580':
						        $id_month_query = "select id_month from month where id_month = 199509";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '199512':
						        $id_month_query = "select id_month from month where id_month = 199601";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '199850':
						        $id_month_query = "select id_month from month where id_month = 199806";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '199812':
						        $id_month_query = "select id_month from month where id_month = 199901";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '200140':
						        $id_month_query = "select id_month from month where id_month = 200105";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '200112':
						        $id_month_query = "select id_month from month where id_month = 200201";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '200420':
						        $id_month_query = "select id_month from month where id_month = 200403";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '200412':
						        $id_month_query = "select id_month from month where id_month = 200501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '200670':
						        $id_month_query = "select id_month from month where id_month = 200608";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '200612':
						        $id_month_query = "select id_month from month where id_month = 200701";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '200950':
						        $id_month_query = "select id_month from month where id_month = 200906";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '200912':
						        $id_month_query = "select id_month from month where id_month = 201001";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '201240':
						        $id_month_query = "select id_month from month where id_month = 201205";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '201212':
						        $id_month_query = "select id_month from month where id_month = 201301";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '201490':
						        $id_month_query = "select id_month from month where id_month = 201410";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '201412':
						        $id_month_query = "select id_month from month where id_month = 201501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '201760':
						        $id_month_query = "select id_month from month where id_month = 201707";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '201712':
						        $id_month_query = "select id_month from month where id_month = 201801";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '202040':
						        $id_month_query = "select id_month from month where id_month = 202005";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '202012':
						        $id_month_query = "select id_month from month where id_month = 202101";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '202320':
						        $id_month_query = "select id_month from month where id_month = 202303";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '202312':
						        $id_month_query = "select id_month from month where id_month = 202401";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '202560':
						        $id_month_query = "select id_month from month where id_month = 202507";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '202512':
						        $id_month_query = "select id_month from month where id_month = 202601";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '202850':
						        $id_month_query = "select id_month from month where id_month = 202806";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '202812':
						        $id_month_query = "select id_month from month where id_month = 202901";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    case '1984100':
						        $id_month_query = "select id_month from month where id_month = 198411";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;
						    case '198412':
						        $id_month_query = "select id_month from month where id_month = 198501";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						        }
						        break;

						    default:
						        $id_month_query = "select id_month from month where id_month = (select min(id_month) from month where id_month > $id_month)";
						        $month_result = mysqli_query($link, $id_month_query) or die("Error in the consult.." . mysqli_error($link));
						        while($row = mysqli_fetch_array($month_result)){
						            $id_month = $row["id_month"];
						            //echo "month:".$id_month.'<br>';
						        }
						}
					}
				}
				$id_year_query = "select id_year from ten_thousand_years where id_day =" . $id_day;
				$year_result = mysqli_query($link, $id_year_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($year_result)){
					$id_year = $row["id_year"];
					//echo "year:".$id_year.'<br>';
				}

				$query = "select d.heaven, hs.chinese from day d left join heavenly_stem hs on d.heaven = hs.id_heavenly_stem where id_day=" . $id_day;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_day_heaven = $row['heaven'];
					$day_heaven = $row["chinese"];
					//echo "day_heaven:".$day_heaven.'<br>';
				}

				$query = "select d.earth, es.chinese from day d left join earthly_stem es on d.earth = es.id_earthly_stem where id_day = " . $id_day;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_day_earth = $row['earth'];
					$day_earth = $row["chinese"];
					//echo "day_earth:".$day_earth.'<br>';
				}

				$query = "select m.heaven, hs.chinese from month m left join heavenly_stem hs on m.heaven = hs.id_heavenly_stem where id_month=" . $id_month;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_month_heaven = $row["heaven"];
					$month_heaven = $row["chinese"];
					//echo "month_heaven:".$month_heaven.'<br>';
				}

				$query = "select m.earth, es.chinese from month m left join earthly_stem es on m.earth = es.id_earthly_stem where id_month = " . $id_month;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_month_earth = $row["earth"];
					$month_earth = $row["chinese"];
					//echo "month_earth:".$month_earth.'<br>';
				}

				$query = "select y.heaven, hs.chinese from year y left join heavenly_stem hs on y.heaven = hs.id_heavenly_stem where id_year=" . $id_year;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_year_heaven = $row["heaven"];
					$year_heaven = $row["chinese"];
					//echo "year_heaven:".$year_heaven.'<br>';
				}

				$query = "select y.earth, es.chinese from year y left join earthly_stem es on y.earth = es.id_earthly_stem where id_year = " . $id_year;
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_year_earth = $row["earth"];
					$year_earth = $row["chinese"];
					//echo "year_earth:".$year_earth.'<br>';
				}

				if(isset($hour) and isset($min)){
					$query = "select heaven from day where id_day=$id_day";
					$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($result)){
						$id_day_master = $row["heaven"];
					}


				switch ($hour){
					case '23':

						$query = "SELECT hs.id_heavenly_stem , es.id_earthly_stem, hs.chinese AS heaven, es.chinese AS earth
									FROM five_rat_chasing_day frcd
									LEFT JOIN heavenly_stem hs ON frcd.heaven = hs.id_heavenly_stem 
									LEFT JOIN earthly_stem es ON frcd.hour = es.id_earthly_stem
									where frcd.day = $id_day_master and id_five_rat between 11 and 20";
						//print_r($query);
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$id_hour_heaven = $row["id_heavenly_stem"];
							$id_hour_earth = $row["id_earthly_stem"];
							$hour_heaven = $row["heaven"];
							$hour_earth = $row["earth"];
						}
						
						$query = "SELECT hs.id_heavenly_stem , hs.chinese AS heaven
									FROM five_rat_chasing_day frcd
									LEFT JOIN heavenly_stem hs ON frcd.heaven = hs.id_heavenly_stem 
									LEFT JOIN earthly_stem es ON frcd.hour = es.id_earthly_stem
									where frcd.day = $id_day_master and id_five_rat between 1 and 10";
						//print_r($query);
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$fake_id_hour_heaven = $row["id_heavenly_stem"];
							$fake_hour_heaven = $row["heaven"];
						}

						break;
					case '00':
						$query = "SELECT hs.id_heavenly_stem , es.id_earthly_stem, hs.chinese AS heaven, es.chinese AS earth
							FROM five_rat_chasing_day frcd
							LEFT JOIN heavenly_stem hs ON frcd.heaven = hs.id_heavenly_stem 
							LEFT JOIN earthly_stem es ON frcd.hour = es.id_earthly_stem
							where frcd.day = $id_day_master and id_five_rat between 11 and 20";
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$id_hour_heaven = $row["id_heavenly_stem"];
							$id_hour_earth = $row["id_earthly_stem"];
							$hour_heaven = $row["heaven"];
							$hour_earth = $row["earth"];
						}
						break;

					default:
						$query = "SELECT hs.id_heavenly_stem , es.id_earthly_stem, hs.chinese AS heaven, es.chinese AS earth
							FROM five_rat_chasing_day frcd
							LEFT JOIN heavenly_stem hs ON frcd.heaven = hs.id_heavenly_stem 
							LEFT JOIN earthly_stem es ON frcd.hour = es.id_earthly_stem
							where frcd.day = $id_day_master and (frcd.start = $hour or frcd.end = $hour)";

						//print_r($query);

						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$id_hour_heaven = $row["id_heavenly_stem"];
							$id_hour_earth = $row["id_earthly_stem"];
							$hour_heaven = $row["heaven"];
							$hour_earth = $row["earth"];
						}
					}
				}

				$query_lead_stem = "SELECT lead_stem, hs.chinese
							FROM stream s
							LEFT JOIN sixty_jia_zi sjz ON s.id_stream = sjz.stream
							LEFT JOIN heavenly_stem hs ON s.lead_stem =hs.id_heavenly_stem
							WHERE sjz.heaven = $id_hour_heaven AND sjz.earth = $id_hour_earth";
				$result = mysqli_query($link, $query_lead_stem) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$id_lead_stem = $row["lead_stem"];
					$lead_stem = $row["chinese"];
				}
				//------------------------------horse star calculation start here------------------------------//
				$query_horse_star = "select es.chinese from horse_star hstar left join earthly_stem es on hstar.horse_star = es.id_earthly_stem where hstar.hour = $id_hour_earth;";
				$result = mysqli_query($link, $query_horse_star) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$horse_star = $row["chinese"];
				}
				//-------------------------------horse star calculation end here-------------------------------//
				//calculation for heaven plate
				foreach ($structure as $index => $earth_plate){
					if($earth_plate['chinese'] == $lead_stem){
						$heaven_plate_sequence_initial = $earth_plate['position'];
					}

					if($hour_heaven == "甲"){
						if($earth_plate['chinese'] == $lead_stem){
							$heaven_plate_initial = $earth_plate['position'];
						}
					}

					else{
						if($earth_plate['chinese'] == $hour_heaven){
							$heaven_plate_initial = $earth_plate['position'];
						}
					}
				}
				//if heaven_plate_sequence_initial & heaven_plate_initial is in 5 the calculation doesn't work, force set both to 2
				if(!isset($heaven_plate_sequence_initial)){
					$heaven_plate_sequence_initial = 2;
				}
				if(!isset($heaven_plate_initial)){
					$heaven_plate_initial = 2;
				}
				//force set ends here

				$heaven_plate_sequence=array();
				$earth_center_conflict = false;
				if ($heaven_plate_sequence_initial == 5){
					$heaven_plate_sequence[0] = $structure[1]["chinese"];
					$heaven_plate_sequence_initial = 2;
					$earth_center_conflict = true;
				}
				else
				{
					$heaven_plate_sequence[0] = $structure[($heaven_plate_sequence_initial-1)]["chinese"];
				}
				
				$earth_plate_position = $heaven_plate_sequence_initial;
				for($x=1;$x<8;$x++){
					switch ($earth_plate_position){
						case 4:
						$heaven_plate_sequence[$x] = $structure[8]['chinese'];
						$earth_plate_position = 9;
						break;
			
						case 9:
						$heaven_plate_sequence[$x] = $structure[1]['chinese'];
						$earth_plate_position = 2;
						break;
			
						case 2:
						$heaven_plate_sequence[$x] = $structure[6]['chinese'];
						$earth_plate_position = 7;
						break;
						
						case 7:
						$heaven_plate_sequence[$x] = $structure[5]['chinese'];
						$earth_plate_position = 6;
						break;
						
						case 6:
						$heaven_plate_sequence[$x] = $structure[0]['chinese'];
						$earth_plate_position = 1;
						break;
						
						case 1:
						$heaven_plate_sequence[$x] = $structure[7]['chinese'];
						$earth_plate_position = 8;
						break;
						
						case 8:
						$heaven_plate_sequence[$x] = $structure[2]['chinese'];
						$earth_plate_position = 3;
						break;
						
						case 3:
						$heaven_plate_sequence[$x] = $structure[3]['chinese'];
						$earth_plate_position = 4;
						break;
					}
				}

				$heaven_center_conflict = false;
				if ($heaven_plate_initial == 5){
					$heaven_plate[1] = $heaven_plate_sequence[0];
					$heaven_plate_initial = 2;
					$heaven_center_conflict = true;
				}
				else
				{
					$pos = $heaven_plate_initial - 1;
					$heaven_plate[$pos] = $heaven_plate_sequence[0];
				}

				$heaven_plate_position = $heaven_plate_initial;
				for($x=1;$x<8;$x++){
					switch ($heaven_plate_position){
						case 4:
						$heaven_plate[8] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 9;
						break;
			
						case 9:
						$heaven_plate[1] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 2;
						break;
			
						case 2:
						$heaven_plate[6] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 7;
						break;
						
						case 7:
						$heaven_plate[5] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 6;
						break;
						
						case 6:
						$heaven_plate[0] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 1;
						break;
						
						case 1:
						$heaven_plate[7] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 8;
						break;
						
						case 8:
						$heaven_plate[2] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 3;
						break;
						
						case 3:
						$heaven_plate[3] = $heaven_plate_sequence[$x];
						$heaven_plate_position = 4;
						break;
					}
				}
				//heaven plate plotting end here
				
				//door calculation start here
				$query = "SELECT number FROM sixty_jia_zi WHERE heaven = $id_hour_heaven AND earth = $id_hour_earth";
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$jiazi_position = $row['number'];
				}

				if($earth_center_conflict == true)
				{
					$door_heaven_conflict = 5;
				}
				else{
					$door_heaven_conflict = $heaven_plate_sequence_initial;
				}
				$eight_door_sequence_initial = $door_heaven_conflict;
				$eight_door_jiazi = $eight_door_sequence_initial;
				if($structure_yin_yang == "Yang"){
					for($x=1;$x<$jiazi_position;$x++){
						$eight_door_jiazi++;
						if($eight_door_jiazi > 9){
							$eight_door_jiazi = 1;
						}
					}
				}
				else{
					for($x=1;$x<$jiazi_position;$x++){
						$eight_door_jiazi--;
						if($eight_door_jiazi < 1){
							$eight_door_jiazi = 9;
						}
					}
				}
				if($eight_door_jiazi == 5){
					$eight_door_jiazi = 2;
				}
				$eight_door_initial_position = $eight_door_jiazi;
				$door_pos = $eight_door_initial_position - 1;
				$eight_door_plate = array("","","","","","","","","");

				$door_query = "SELECT id_door, chinese FROM door WHERE position = $heaven_plate_sequence_initial;";
				$result = mysqli_query($link, $door_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$envoy = $row['chinese'];
					$first_door_counter = $row['id_door'];
				}
				$eight_door_plate[$door_pos] = $envoy;
				$counter = $first_door_counter + 1;
				$counter = ($counter >= 9 ? 1 : $counter);
				for($x=0;$x<=6;$x++){
					$counter = ($counter >= 9 ? 1 : $counter);
					$door_query = "SELECT chinese, english FROM door WHERE id_door = $counter;";
					$result = mysqli_query($link, $door_query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($result)){
						$next_door = $row['chinese'];
					}
					//print_r($counter);
					switch($eight_door_initial_position){
						case 4:
						$eight_door_plate[8] = $next_door;
						$eight_door_initial_position = 9;
						break;
			
						case 9:
						$eight_door_plate[1] = $next_door;
						$eight_door_initial_position = 2;
						break;
			
						case 2:
						$eight_door_plate[6] = $next_door;
						$eight_door_initial_position = 7;
						break;
						
						case 7:
						$eight_door_plate[5] = $next_door;
						$eight_door_initial_position = 6;
						break;
						
						case 6:
						$eight_door_plate[0] = $next_door;
						$eight_door_initial_position = 1;
						break;
						
						case 1:
						$eight_door_plate[7] = $next_door;
						$eight_door_initial_position = 8;
						break;
						
						case 8:
						$eight_door_plate[2] = $next_door;
						$eight_door_initial_position = 3;
						break;
						
						case 3:
						$eight_door_plate[3] = $next_door;
						$eight_door_initial_position = 4;
						break;
					}
					$counter++;
				}
				
				//print_r("<br>jiazi:".$jiazi_position);
				//print_r("<br>initial:".$eight_door_initial_position."<br>");
				//print_r($eight_door_plate);
				//------------------door plotting end here-----------------------------//

 				//------------------------------star plotting start here--------------------------------//
 				$star_sequence_initial = $heaven_plate_sequence_initial;
 				$star_center_conflict = $earth_center_conflict;
 				$star_query = "SELECT id_star, chinese FROM star WHERE position = $heaven_plate_sequence_initial;";
 				$result = mysqli_query($link, $star_query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$first_star_counter = $row['id_star'];
					if($star_center_conflict != true){
						$lead_star = $row['chinese'];
					}

					else{
						$qin_query = "SELECT id_star, chinese FROM star WHERE position = 5;";
						$result = mysqli_query($link, $qin_query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$lead_star = $row['chinese'];
						}

						$rui_query = "SELECT id_star, chinese FROM star WHERE position = 2;";
						$result = mysqli_query($link, $rui_query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							$true_star = $row['chinese'];
						}
					}
				}
				$star_plate = array("","","","","","","","","");
				$star_plate_initial_pos = $heaven_plate_initial;
				$star_plate_first_pos = $star_plate_initial_pos - 1;

				$hidden_tian = array("","","","","","","","","");
				$set_hidden_stem = 0;
				if($star_center_conflict != true){
					$star_plate[$star_plate_first_pos] = $lead_star;
				}
				else{
					$star_plate[$star_plate_first_pos] = $true_star."<br>".$lead_star."&nbsp;&nbsp;";
					$hidden_tian[$star_plate_first_pos] = $structure[4]['chinese'];
				}
				//$star_plate[$star_plate_first_pos] = ($star_center_conflict != true? $lead_star : $true_star."<br>".$lead_star."&nbsp;&nbsp;");
				
				$star_counter = $first_star_counter + 1;
				$star_counter = ($star_counter >= 9 ? 1 : $star_counter);
				for($x=0;$x<=7;$x++){
					$set_hidden_stem = 0;
					$star_counter = ($star_counter >= 9 ? 1 : $star_counter);
					$star_query = "SELECT chinese FROM star WHERE id_star = $star_counter;";
					$result = mysqli_query($link, $star_query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($result)){
						if($star_counter == 6){
								$up_star = $row['chinese'];
								$rui_query = "SELECT id_star, chinese FROM star WHERE position = 5;";
								$result = mysqli_query($link, $rui_query) or die("Error in the consult.." . mysqli_error($link));
								while($row = mysqli_fetch_array($result)){
									$down_star = $row['chinese'];
								}
								$next_star = $up_star."<br>".$down_star."&nbsp;&nbsp;";
								$set_hidden_stem = 1;
							// }
							//$next_star = ($star_center_conflict!=true? $row['chinese'] : $true_star."<br>".$lead_star."&nbsp;&nbsp;");
						}
						else{
							$next_star = $row['chinese'];
						}
					}

					switch($star_plate_initial_pos){
						case 4:
						$star_plate[8] = $next_star;
						$hidden_tian[8] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 9;
						break;
			
						case 9:
						$star_plate[1] = $next_star;
						$hidden_tian[1] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 2;
						break;
			
						case 2:
						$star_plate[6] = $next_star;
						$hidden_tian[6] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 7;
						break;
						
						case 7:
						$star_plate[5] = $next_star;
						$hidden_tian[5] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 6;
						break;
						
						case 6:
						$star_plate[0] = $next_star;
						$hidden_tian[0] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 1;
						break;
						
						case 1:
						$star_plate[7] = $next_star;
						$hidden_tian[7] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 8;
						break;
						
						case 8:
						$star_plate[2] = $next_star;
						$hidden_tian[2] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 3;
						break;
						
						case 3:
						$star_plate[3] = $next_star;
						$hidden_tian[3] = ($set_hidden_stem == 1? $structure[4]['chinese'] : "");
						$star_plate_initial_pos = 4;
						break;
					}
					$star_counter++;
				}

				//------------------------------star plotting end here----------------------------------//

				//dummy deity calculation
				$yang_deities = array("符","蛇","阴","合","陈","雀","地","天");
				$yang_deities_eng = array("Grandee","Snake","Yin","Combo","Dangle","Phoenix","Earth","Heaven");
				$yin_deities = array("符","天","地","玄","虎","合","阴","蛇");
				$yin_deities_eng = array("Grandee","Heaven","Earth","Tortoise","Tiger","Combo","Yin","Snake");
				if ($structure_yin_yang == "Yang"){
					if($hour_heaven == "甲"){
						$query = "SELECT position FROM earth_plate_nine_yang_structure nys LEFT JOIN heavenly_stem hs ON nys.heaven = hs.id_heavenly_stem WHERE no_structure = $qimen_no and nys.heaven = $id_lead_stem";
					}
					else{
						$query = "SELECT position FROM earth_plate_nine_yang_structure nys LEFT JOIN heavenly_stem hs ON nys.heaven = hs.id_heavenly_stem WHERE no_structure = $qimen_no and nys.heaven = $id_hour_heaven";
					}
				}
				else{
					if($hour_heaven == "甲"){
						$query = "SELECT position FROM earth_plate_nine_yin_structure nys LEFT JOIN heavenly_stem hs ON nys.heaven = hs.id_heavenly_stem WHERE no_structure = $qimen_no and nys.heaven = $id_lead_stem";
					}
					else{
						$query = "SELECT position FROM earth_plate_nine_yin_structure nys LEFT JOIN heavenly_stem hs ON nys.heaven = hs.id_heavenly_stem WHERE no_structure = $qimen_no and nys.heaven = $id_hour_heaven";
					}
				}
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$position = $row["position"];
				}
				//if position is in 5 the query won't able to pull anything, force set the position to 2 ? unknown
				if(!isset($position)){
				 	$position = 2;
				}

				if ($structure_yin_yang == "Yang"){
					if ($position == 5){
						$position = 2;
						$deity[1] = $yang_deities[0];
						$deity_eng[1] = $yang_deities_eng[0];
						for($x=1;$x<8;$x++){
							switch ($position){
								case 4:
								$deity[8] = $yang_deities[$x];
								$deity_eng[8] = $yang_deities_eng[$x];
								$position = 9;
								break;
					
								case 9:
								$deity[1] = $yang_deities[$x];
								$deity_eng[1] = $yang_deities_eng[$x];
								$position = 2;
								break;
					
								case 2:
								$deity[6] = $yang_deities[$x];
								$deity_eng[6] = $yang_deities_eng[$x];
								$position = 7;
								break;
								
								case 7:
								$deity[5] = $yang_deities[$x];
								$deity_eng[5] = $yang_deities_eng[$x];
								$position = 6;
								break;
								
								case 6:
								$deity[0] = $yang_deities[$x];
								$deity_eng[0] = $yang_deities_eng[$x];
								$position = 1;
								break;
								
								case 1:
								$deity[7] = $yang_deities[$x];
								$deity_eng[7] = $yang_deities_eng[$x];
								$position = 8;
								break;
								
								case 8:
								$deity[2] = $yang_deities[$x];
								$deity_eng[2] = $yang_deities_eng[$x];
								$position = 3;
								break;
								
								case 3:
								$deity[3] = $yang_deities[$x];
								$deity_eng[3] = $yang_deities_eng[$x];
								$position = 4;
								break;
							}
						}
					}
					 
					else{
						$pos = $position - 1;
						$deity[$pos] = $yang_deities[0];
						$deity_eng[$pos] = $yang_deities_eng[0];
						
						for($x=1;$x<8;$x++){
							switch ($position){
								case 4:
								$deity[8] = $yang_deities[$x];
								$deity_eng[8] = $yang_deities_eng[$x];
								$position = 9;
								break;
					
								case 9:
								$deity[1] = $yang_deities[$x];
								$deity_eng[1] = $yang_deities_eng[$x];
								$position = 2;
								break;
					
								case 2:
								$deity[6] = $yang_deities[$x];
								$deity_eng[6] = $yang_deities_eng[$x];
								$position = 7;
								break;
								
								case 7:
								$deity[5] = $yang_deities[$x];
								$deity_eng[5] = $yang_deities_eng[$x];
								$position = 6;
								break;
								
								case 6:
								$deity[0] = $yang_deities[$x];
								$deity_eng[0] = $yang_deities_eng[$x];
								$position = 1;
								break;
								
								case 1:
								$deity[7] = $yang_deities[$x];
								$deity_eng[7] = $yang_deities_eng[$x];
								$position = 8;
								break;
								
								case 8:
								$deity[2] = $yang_deities[$x];
								$deity_eng[2] = $yang_deities_eng[$x];
								$position = 3;
								break;
								
								case 3:
								$deity[3] = $yang_deities[$x];
								$deity_eng[3] = $yang_deities_eng[$x];
								$position = 4;
								break;
							}
						}
					}
				}
				else{
					if ($position == 5){
						$position = 2;
						$deity[1] = $yin_deities[0];
						$deity_eng[3] = $yin_deities_eng[0];
						for($x=1;$x<8;$x++){
							switch ($position){
								case 4:
								$deity[8] = $yin_deities[$x];
								$deity_eng[8] = $yin_deities_eng[$x];
								$position = 9;
								break;
					
								case 9:
								$deity[1] = $yin_deities[$x];
								$deity_eng[1] = $yin_deities_eng[$x];
								$position = 2;
								break;
					
								case 2:
								$deity[6] = $yin_deities[$x];
								$deity_eng[6] = $yin_deities_eng[$x];
								$position = 7;
								break;
								
								case 7:
								$deity[5] = $yin_deities[$x];
								$deity_eng[5] = $yin_deities_eng[$x];
								$position = 6;
								break;
								
								case 6:
								$deity[0] = $yin_deities[$x];
								$deity_eng[0] = $yin_deities_eng[$x];
								$position = 1;
								break;
								
								case 1:
								$deity[7] = $yin_deities[$x];
								$deity_eng[7] = $yin_deities_eng[$x];
								$position = 8;
								break;
								
								case 8:
								$deity[2] = $yin_deities[$x];
								$deity_eng[2] = $yin_deities_eng[$x];
								$position = 3;
								break;
								
								case 3:
								$deity[3] = $yin_deities[$x];
								$deity_eng[3] = $yin_deities_eng[$x];
								$position = 4;
								break;
							}
						}
					}
					 
					else{
						$pos = $position - 1;
						$deity[$pos] = $yin_deities[0];
						$deity_eng[$pos] = $yin_deities_eng[0];
						
						for($x=1;$x<8;$x++){
							switch ($position){
								case 4:
								$deity[8] = $yin_deities[$x];
								$deity_eng[8] = $yin_deities_eng[$x];
								$position = 9;
								break;
					
								case 9:
								$deity[1] = $yin_deities[$x];
								$deity_eng[1] = $yin_deities_eng[$x];
								$position = 2;
								break;
					
								case 2:
								$deity[6] = $yin_deities[$x];
								$deity_eng[6] = $yin_deities_eng[$x];
								$position = 7;
								break;
								
								case 7:
								$deity[5] = $yin_deities[$x];
								$deity_eng[5] = $yin_deities_eng[$x];
								$position = 6;
								break;
								
								case 6:
								$deity[0] = $yin_deities[$x];
								$deity_eng[0] = $yin_deities_eng[$x];
								$position = 1;
								break;
								
								case 1:
								$deity[7] = $yin_deities[$x];
								$deity_eng[7] = $yin_deities_eng[$x];
								$position = 8;
								break;
								
								case 8:
								$deity[2] = $yin_deities[$x];
								$deity_eng[2] = $yin_deities_eng[$x];
								$position = 3;
								break;
								
								case 3:
								$deity[3] = $yin_deities[$x];
								$deity_eng[3] = $yin_deities_eng[$x];
								$position = 4;
								break;
							}
						}
					}
				}
				//deity end here

				//death and emptiness
				$query = "SELECT es.chinese AS earth, esii.chinese AS earth_ii
							FROM stream s
							LEFT JOIN earthly_stem es ON s.death_emptiness_earth = es.id_earthly_stem
							LEFT JOIN earthly_stem esii ON s.death_emptiness_earth_ii = esii.id_earthly_stem
							WHERE s.lead_stem = $id_lead_stem;";
				$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
				while($row = mysqli_fetch_array($result)){
					$death_emptiness = $row["earth"] . $row["earth_ii"];
					$death = $row["earth"];
					$emptiness = $row["earth_ii"];
				}
				//death and emptiness ends here
				//fake hour heaven kick in if the hour is 23
				if(isset($fake_hour_heaven) && !empty($fake_hour_heaven)){
					$hour_heaven = $fake_hour_heaven;
				}
				//-------------fake hour ends here-----------
				//special structure retrieval
				$bad_special_structure = array("","","","","","","","","");
				$good_special_structure = array("","","","","","","","","");
				$y = 0;
				$b = 8;

				for($x=0;$x<=7;$x++){
					$y = ($y == 4? 5 : $y);
					$earth = $structure[$y]["chinese"];

					switch ($y){
						case 0:
							$palace = '坎';
							break;
						case 1:
							$palace = '坤';
							break;
						case 2:
							$palace = '震';
							break;
						case 3:
							$palace = '巽';
							break;
						case 5:
							$palace = '乾';
							break;
						case 6:
							$palace = '兌';
							break;
						case 7:
							$palace = '艮';
							break;
						case 8:
							$palace = '离';
							break;
					}
					//kick in jia hour, day, month, year master jia calculation
					if ($day_heaven == "甲") {
						$query_jia_day_heaven = "SELECT lead_stem, hs.chinese
							FROM stream s
							LEFT JOIN sixty_jia_zi sjz ON s.id_stream = sjz.stream
							LEFT JOIN heavenly_stem hs ON s.lead_stem =hs.id_heavenly_stem
							WHERE sjz.heaven = $id_day_heaven AND sjz.earth = $id_day_earth";
						$result = mysqli_query($link, $query_jia_day_heaven) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							//$day_heaven = $row["chinese"];
							$ss_day = $row["chinese"];
						}
					}
					else{
						$ss_day = $day_heaven;
					}

					if ($month_heaven == "甲") {
						$query_jia_month_heaven = "SELECT lead_stem, hs.chinese
							FROM stream s
							LEFT JOIN sixty_jia_zi sjz ON s.id_stream = sjz.stream
							LEFT JOIN heavenly_stem hs ON s.lead_stem =hs.id_heavenly_stem
							WHERE sjz.heaven = $id_month_heaven AND sjz.earth = $id_month_earth";
						$result = mysqli_query($link, $query_jia_month_heaven) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							//$month_heaven = $row["chinese"];
							$ss_month = $row["chinese"];
						}
					}
					else{
						$ss_month = $month_heaven;
					}

					if ($year_heaven == "甲") {
						$query_jia_year_heaven = "SELECT lead_stem, hs.chinese
							FROM stream s
							LEFT JOIN sixty_jia_zi sjz ON s.id_stream = sjz.stream
							LEFT JOIN heavenly_stem hs ON s.lead_stem =hs.id_heavenly_stem
							WHERE sjz.heaven = $id_year_heaven AND sjz.earth = $id_year_earth";
						$result = mysqli_query($link, $query_jia_year_heaven) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							//$year_heaven = $row["chinese"];
							$ss_year = $row["chinese"];
						}
					}
					else{
						$ss_year = $year_heaven;
					}
					//special  calculation ends here

					if($heaven_plate[$y] == $day_heaven AND $heaven_plate[$y] == $lead_stem){
						$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$heaven_plate[$y]%' OR heaven LIKE '日干' OR heaven LIKE '符首' OR heaven IS NULL";
					}
					elseif ($heaven_plate[$y] == $day_heaven) {
						$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$heaven_plate[$y]%' OR heaven LIKE '日干' OR heaven IS NULL";
					}
					elseif ($heaven_plate[$y] == $lead_stem) {
						$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$heaven_plate[$y]%' OR heaven LIKE '符首' OR heaven IS NULL" ;
					}
					else{
						$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$heaven_plate[$y]%' OR heaven IS NULL";
					}
					//print_r($query);
					$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
					while($row = mysqli_fetch_array($result)){
						//check earth
						unset($earth_element);
						$earth_contains = 0;
						if($row['earth'] !== NULL){
							$earth_element[0] = $structure[$y]['chinese'];
							if($structure[$y]['chinese'] == $hour_heaven){
								$earth_element[] = '时干';
							}

							if($structure[$y]['chinese'] == $ss_day){
								$earth_element[] = '日干';
							}
							if($structure[$y]['chinese'] == $ss_month){
								$earth_element[] = '月干';
							}
							if($structure[$y]['chinese'] == $ss_year){
								$earth_element[] = '年干';
							}
							if($structure[$y]['chinese'] == $lead_stem){
								$earth_element[] = '符首';
							}

							if ($y == 1) {
								$earth_element[] = $structure[4]['chinese'];
								if($structure[4]['chinese'] == $hour_heaven){
								$earth_element[] = '时干';
								}

								if($structure[4]['chinese'] == $ss_day){
									$earth_element[] = '日干';
								}
								if($structure[4]['chinese'] == $ss_month){
									$earth_element[] = '月干';
								}
								if($structure[4]['chinese'] == $ss_year){
									$earth_element[] = '年干';
								}
								if($structure[4]['chinese'] == $lead_stem){
									$earth_element[] = '符首';
								}
							}
							
							//print_r($earth_element);
							foreach ($earth_element as $earth_compare) {
								if(preg_match('/'.$earth_compare.'/', $row['earth']) == 1){
									$earth_contains += 1;
								}
							}

							//print_r("position:".$y.' | earth in query:'.$row['earth'].$earth_contains."　　　");
							if($earth_contains >= 1){
								//check door
								if($row['door'] !== NULL){
									unset($door_element);
									$door_contains = 0;
									$door_element[0] = $eight_door_plate[$y];
									if($eight_door_plate[$y] === $envoy){
										$door_element[] = '值使';
									}
									foreach ($door_element as $door_compare) {
										if(preg_match('/'.$door_compare.'/', $row['door']) == 1){
											$door_contains += 1;
										}
									}
									if($door_contains >= 1){
									//if(preg_match('/'.$eight_door_plate[$y].'/', $row['door']) == 1){
										//check star
										if($row['star'] !== NULL){
											if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
												//check deity
												if($row['deity'] !== NULL){
													if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
														if($row['palace'] !== NULL){
															if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
														else{
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
												}
												else{
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
										}
										else{
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
								}
								else{
									if($row['star'] !== NULL){
										if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
											//check deity
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
									else{
										if($row['deity'] !== NULL){
											if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
										else{
											if($row['palace'] !== NULL){
												if(preg_match('/'.$palace.'/', $row['palace']) == 1){
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
											else{
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
									}
								}
							}
						}
						else{
							if($row['door'] !== NULL){
								unset($door_element);
								$door_contains = 0;
								$door_element[0] = $eight_door_plate[$y];
								if($eight_door_plate[$y] === $envoy){
									$door_element[] = '值使';
								}
								foreach ($door_element as $door_compare) {
									if(preg_match('/'.$door_compare.'/', $row['door']) == 1){
										$door_contains += 1;
									}
								}
								if($door_contains >= 1){
								//if(preg_match('/'.$eight_door_plate[$y].'/', $row['door']) == 1){
									//check star
									if($row['star'] !== NULL){
										if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
											//check deity
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
									else{
										if($row['deity'] !== NULL){
											if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
										else{
											if($row['palace'] !== NULL){
												if(preg_match('/'.$palace.'/', $row['palace']) == 1){
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
											else{
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
									}
								}
							}
							else{
								if($row['star'] !== NULL){
									if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
										//check deity
										if($row['deity'] !== NULL){
											if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
										else{
											if($row['palace'] !== NULL){
												if(preg_match('/'.$palace.'/', $row['palace']) == 1){
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
											else{
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
									}
								}
								else{
									if($row['deity'] !== NULL){
										if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
											if($row['palace'] !== NULL){
												if(preg_match('/'.$palace.'/', $row['palace']) == 1){
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
											else{
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
									}
									else{
										if($row['palace'] !== NULL){
											if(preg_match('/'.$palace.'/', $row['palace']) == 1){
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
										else{
											if($row['characteristic'] == 0){
												if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
													$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
												}
											}
											else{
												if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
													$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
												}
											}
										}
									}
								}
							}
						}
					}
					//$y++;

					//develop #0001: hidden tian calculation starts here
					if(!empty($hidden_tian[$y])){
						if($hidden_tian[$y] == $ss_day AND $hidden_tian[$y] == $lead_stem){
							$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$hidden_tian[$y]%' OR heaven LIKE '日干' OR heaven LIKE '符首' OR heaven IS NULL";
						}
						elseif ($hidden_tian[$y] == $ss_day) {
							$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$hidden_tian[$y]%' OR heaven LIKE '日干' OR heaven IS NULL";
						}
						elseif ($heaven_plate[$y] == $lead_stem) {
							$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$hidden_tian[$y]%' OR heaven LIKE '符首' OR heaven IS NULL" ;
						}
						else{
							$query = "SELECT * FROM special_structure WHERE heaven LIKE '%$hidden_tian[$y]%' OR heaven IS NULL";
						}
						//print_r($query);
						$result = mysqli_query($link, $query) or die("Error in the consult.." . mysqli_error($link));
						while($row = mysqli_fetch_array($result)){
							//check earth
							unset($earth_element);
							$earth_contains = 0;
							if($row['earth'] !== NULL){
								$earth_element[0] = $structure[$y]['chinese'];
								if($structure[$y]['chinese'] == $hour_heaven){
									$earth_element[] = '时干';
								}

								if($structure[$y]['chinese'] == $ss_day){
									$earth_element[] = '日干';
								}
								if($structure[$y]['chinese'] == $ss_month){
									$earth_element[] = '月干';
								}
								if($structure[$y]['chinese'] == $ss_year){
									$earth_element[] = '年干';
								}
								if($structure[$y]['chinese'] == $lead_stem){
									$earth_element[] = '符首';
								}
								//print_r($earth_element);
								foreach ($earth_element as $earth_compare) {
									if(preg_match('/'.$earth_compare.'/', $row['earth']) == 1){
										$earth_contains += 1;
									}
								}

								//print_r("position:".$y.' | earth in query:'.$row['earth'].$earth_contains."　　　");
								if($earth_contains >= 1){
									//check door
									if($row['door'] !== NULL){
										unset($door_element);
										$door_contains = 0;
										$door_element[0] = $eight_door_plate[$y];
										if($eight_door_plate[$y] === $envoy){
											$door_element[] = '值使';
										}
										foreach ($door_element as $door_compare) {
											if(preg_match('/'.$door_compare.'/', $row['door']) == 1){
												$door_contains += 1;
											}
										}
										if($door_contains >= 1){
										//if(preg_match('/'.$eight_door_plate[$y].'/', $row['door']) == 1){
											//check star
											if($row['star'] !== NULL){
												if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
													//check deity
													if($row['deity'] !== NULL){
														if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
															if($row['palace'] !== NULL){
																if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																	if($row['characteristic'] == 0){
																		if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																			$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																		}
																	}
																	else{
																		if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																			$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																		}
																	}
																}
															}
															else{
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
													}
													else{
														if($row['palace'] !== NULL){
															if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
														else{
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
												}
											}
											else{
												if($row['deity'] !== NULL){
													if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
														if($row['palace'] !== NULL){
															if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
														else{
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
												}
												else{
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
										}
									}
									else{
										if($row['star'] !== NULL){
											if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
												//check deity
												if($row['deity'] !== NULL){
													if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
														if($row['palace'] !== NULL){
															if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
														else{
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
												}
												else{
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
										}
										else{
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
								}
							}
							else{
								if($row['door'] !== NULL){
									unset($door_element);
									$door_contains = 0;
									$door_element[0] = $eight_door_plate[$y];
									if($eight_door_plate[$y] === $envoy){
										$door_element[] = '值使';
									}
									foreach ($door_element as $door_compare) {
										if(preg_match('/'.$door_compare.'/', $row['door']) == 1){
											$door_contains += 1;
										}
									}
									if($door_contains >= 1){
									//if(preg_match('/'.$eight_door_plate[$y].'/', $row['door']) == 1){
										//check star
										if($row['star'] !== NULL){
											if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
												//check deity
												if($row['deity'] !== NULL){
													if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
														if($row['palace'] !== NULL){
															if(preg_match('/'.$palace.'/', $row['palace']) == 1){
																if($row['characteristic'] == 0){
																	if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																		$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
																else{
																	if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																		$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																	}
																}
															}
														}
														else{
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
												}
												else{
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
										}
										else{
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
								}
								else{
									if($row['star'] !== NULL){
										if(preg_match('/'.$star_plate[$y].'/', $row['star']) == 1){
											//check deity
											if($row['deity'] !== NULL){
												if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
													if($row['palace'] !== NULL){
														if(preg_match('/'.$palace.'/', $row['palace']) == 1){
															if($row['characteristic'] == 0){
																if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																	$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
															else{
																if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																	$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
																}
															}
														}
													}
													else{
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
											}
											else{
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
									}
									else{
										if($row['deity'] !== NULL){
											if(preg_match('/'.$deity[$y].'/', $row['deity']) == 1){
												if($row['palace'] !== NULL){
													if(preg_match('/'.$palace.'/', $row['palace']) == 1){
														if($row['characteristic'] == 0){
															if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
																$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
														else{
															if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
																$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
															}
														}
													}
												}
												else{
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
										}
										else{
											if($row['palace'] !== NULL){
												if(preg_match('/'.$palace.'/', $row['palace']) == 1){
													if($row['characteristic'] == 0){
														if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
															$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
													else{
														if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
															$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
														}
													}
												}
											}
											else{
												if($row['characteristic'] == 0){
													if(preg_match('/'.$row['chinese'].'/', $bad_special_structure[$y]) == 0){
														$bad_special_structure[$y] = $bad_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
												else{
													if(preg_match('/'.$row['chinese'].'/', $good_special_structure[$y]) == 0){
														$good_special_structure[$y] = $good_special_structure[$y] . $row['chinese'] . "<br>";
													}
												}
											}
										}
									}
								}
							}
						}
					}
					//hidden tian calculation ends here
					$y++;
				}
				//special structure retrieval ends here

				//special structure calculation for the hidden stem
				//special structure calculation for the hidden stream
			}
		}

		catch(Exception $e){
			echo "<script>alert('selection out of bound')</script>";
		}
	}
	//Author: Dave Chen
?>