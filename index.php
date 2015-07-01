<!DOCTYPE html >
<?php
	include 'fortune_teller.php';
?>
<html>
<head>
	<title>Qi Men Dun Jia</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" type="text/css" href="jquery/jquery.datetimepicker.css"/>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script>
	// --- Button UI ---
	  $(function() {
		$( "input[type=submit], a, button" )
		  .button()
		  .click(function( event ) {
			event.preventDefault();
		  });
	  });
	  $(function() {
		$( "input[type=button], a, button" )
		  .button()
		  .click(function( event ) {
			event.preventDefault();
		  });
	  }); // --- Button UI end ---
	  
	  // --- Post form without refresh page ---
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'index.php',
            data: $('form').serialize(),
            success: function () {
              alert('form was submitted');
            }
          });

        });

      }); // --- Post form without refresh page end---
    </script>
</head>

<body>
	<div id='test_area'>
	</div>
	  <div id="background">
			  <div id="page">
					 <div class="header">
						<div class="footer">
							<div class="body">
									<div id="sidebar">
									    <a href="index.php"><img id="logo" src="images/logo.png" with="600" height="150" alt="" title=""/></a>
										<ul class="navigation">
										    <li class="active" ><a href="index.php">HOME</a></li>
											<li><a href="about.html">ABOUT</a></li>
											<li><a href="blog.html">BLOG</a></li>
											<li class="last" ><a href="contact.html">CONTACT</a></li>
										</ul>
										
										<div class="connect">
										    <a href="http://facebook.com/freewebsitetemplates" class="facebook">&nbsp;</a>
											<a href="http://twitter.com/fwtemplates" class="twitter">&nbsp;</a>
											<a href="http://www.youtube.com/fwtemplates" class="vimeo">&nbsp;</a>
										</div>
										
										<div class="footenote">
										  <span>&copy; Copyright &copy; 6014.</span>
										  <span><a href="index.html">MO Freelance</a> all rights reserved</span>
										</div>
										
									</div>
									<div id="content" >
									    <img src="images/fate.jpg" width="766" height="950" alt="" title="">
									    <div class=featured>
											<div class="body">
												<form name = "qmdjForm" method ="GET" action = "">
												<table>
												<tr>
												<td>
												<table width="475">
													<tr>
														<td align='left'>Name :</td>
														<td><input  name = "txt_name" type = "text" value = <?php echo(isset($_GET['txt_name'])? str_replace("%60","&nbsp;",rawurlencode($_GET['txt_name'])) : '')?>></td>
														<td align='left'>Gender :</td>
														<td>
															<select name = "gender">
																<option selected><?php echo(isset($_GET['gender']) ? $_GET['gender'] : '')?></option>
																<option>Male</option><option>Female</option>
															</select>
														</td>
													</tr><!-- 
													<tr>
														<td width = '100px'> </td>
														<td>
															
														</td>
													</tr> -->
													<tr>
														<td align='left'>Date :</td>
														<td><input name = "txt_date" type = "text" id = "datepicker" value = <?php echo(isset($_GET['txt_date'])? $_GET['txt_date'] : date('Y-m-d'))?>></td>
														<td align='left'>Time : </td>
														<td>
															<select name = "hour" id="select_hour">
																<option selected><?php echo(isset($_GET['hour']) ? $_GET['hour'] : date('H'))?></option>
																<option>01</option><option>02</option><option>03</option><option>04</option><option>05</option>
																<option>06</option><option>07</option><option>08</option><option>09</option><option>10</option>
																<option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
																<option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>
																<option>21</option><option>22</option><option>23</option><option>00</option>
															</select>
															<select name = "minute" id="select_minute">
																<option selected><?php echo(isset($_GET['minute']) ? $_GET['minute']: date('i'))?></option>
																<option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option>
																<option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>
																<option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option>
																<option>31</option><option>32</option><option>33</option><option>34</option><option>35</option><option>36</option><option>37</option><option>38</option><option>39</option><option>40</option>
																<option>41</option><option>42</option><option>43</option><option>44</option><option>45</option><option>46</option><option>47</option><option>48</option><option>49</option><option>50</option>
																<option>51</option><option>52</option><option>53</option><option>54</option><option>55</option><option>56</option><option>57</option><option>58</option><option>59</option><option>00</option>
															</select>
														</td>
													</tr>
													<tr>
														<td colspan="4"><input name = "submit" type = "Submit" name = "searchButton" value = "Search" onClick = "searchFunction()"></td>
													</tr>
												</table>

												<table class = "HDMYtable" border = '1'>
													<tr>
														<td width = '100px'>Hour</td>
														<td width = '100px'>Day</td>
														<td width = '100px'>Month</td>
														<td width = '100px'>Year</td>
													</tr>
													<tr>
														<td height = '25px'><?php echo(isset($hour_heaven) ?  $hour_heaven : '' )?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $day_heaven : '' )?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $month_heaven : '' )?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $year_heaven : '' )?></td>
													</tr>
													<tr>
														<td height = '25px'><?php echo(isset($hour_earth) ?  $hour_earth : '' )?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $day_earth : '')?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $month_earth : '')?></td>
														<td height = '25px'><?php echo(isset($id_day) ?  $year_earth : '')?></td>
													</tr>
												</table>
												</td>
												<td>
												<table class = "importantInfotable">
													<tr>
														Important Information
													</tr>
													<tr>
														<td class = 'left'>Structure</td>
														<td><?php echo(isset($structure_no) ?  $structure_no : '' );?></td>
													</tr>
													<tr>
														<td class = 'left'>Lead Stem 符首</td>
														<td><?php echo(isset($lead_stem) ?  $lead_stem : '' );?></td>
													</tr>
													<tr>
														<td class = 'left'>Lead Star 值符星</td>
														<td><?php echo(isset($lead_star) ?  $lead_star : '' );?></td>
													</tr>
													<tr>
														<td class = 'left'>Envoy 值使门</td>
														<td><?php echo(isset($envoy) ?  $envoy : '' );?></td>
													</tr>
													<tr bgcolor="#FF3030">
														<td class = 'left'>Horse 马星</td>
														<td><?php echo(isset($horse_star) ?  $horse_star : '' );?></td>
													</tr>
													<tr bgcolor="#66FFFF" >
														<td class = 'left'>DE 空亡</td>
														<td><?php echo(isset($death_emptiness) ?  $death_emptiness : '' );?></td>
													</tr>
												</table>
												</td>
												</tr>
												<tr>
												<table class = "HDMYGraphtable">
													<tr>
														<td class = "border" width = '10px'>SE 4</td>
														<td class = "border" width = '175px' <?php echo(isset($death_emptiness) ? (preg_match('/巳/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/巳/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' );?>>Snake 巳 Si</td>
														<td class = "border" width = '175px' <?php echo(isset($death_emptiness) ? (preg_match('/午/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/午/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' );?>>Horse 午 Wu<br>South 9</td>
														<td class = "border" width = '175px' <?php echo(isset($death_emptiness) ? (preg_match('/未/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/未/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' );?>>Goat 未 Wei</td>
														<td class = "border" width = '30px'>SW 2</td>
													</tr>
													<tr>
														<td class = "border" align="center" height = '150px' <?php echo(isset($death_emptiness) ? (preg_match('/辰/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/辰/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>><span class='rotate270'>Dragon辰 Che&nacute;</span></td>
														<td class = "border" >
															<table class = 'none' <?php echo (isset($structure_yin_yang) ? ($structure_yin_yang == "Yin" ? 'bgcolor="#B8B8E6"' : '') : '');?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[3]) ?  $heaven_plate[3] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[3]) ?  $hidden_tian[3] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[3]) ?  '<font color="red">'.$good_special_structure[3].'</font>' : '')?><?php echo(isset($bad_special_structure[3]) ?  '<font color="blue">'.$bad_special_structure[3].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[3]) ?  $deity[3] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[3]) ?  $deity_eng[3] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="green">Wood</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[3]) ?  $star_plate[3] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[3]['chinese']) ?  $structure[3]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[3]) ?  $eight_door_plate[3] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" >
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yang" ? 'bgcolor="#B8B8E6"' : '') : '');?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[8]) ?  $heaven_plate[8] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[8]) ?  $hidden_tian[8] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[8]) ?  '<font color="red">'.$good_special_structure[8].'</font>' : '')?><?php echo(isset($bad_special_structure[8]) ?  '<font color="blue">'.$bad_special_structure[8].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[8]) ?  $deity[8] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[8]) ?  $deity_eng[8] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="red">Fire</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[8]) ?  $star_plate[8] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[8]['chinese']) ?  $structure[8]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[8]) ?  $eight_door_plate[8] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" >
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yang" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[1]) ?  $heaven_plate[1] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[1]) ?  $hidden_tian[1] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[1]) ?  '<font color="red">'.$good_special_structure[1].'</font>' : '')?><?php echo(isset($bad_special_structure[1]) ?  '<font color="blue">'.$bad_special_structure[1].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[1]) ?  $deity[1] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[1]) ?  $deity_eng[1] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="brown">Earth</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[1]) ?  $star_plate[1] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px">&nbsp;&nbsp;&nbsp;<?php echo(isset($structure[4]['chinese']) ?  $structure[4]['chinese'] : '')?><br><?php echo(isset($structure[1]['chinese']) ?  $structure[1]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[1]) ?  $eight_door_plate[1] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" align="center" height = '150px' <?php echo(isset($death_emptiness) ? (preg_match('/申/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/申/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' );?>><span class='rotate90'>Monkey申 Shen</span></td>
													</tr>
													<tr>
														<td class = "border" align="center" height = '150px' <?php echo(isset($death_emptiness) ? (preg_match('/卯/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/卯/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' );?>><span class='rotate270'>Rabbit<br>卯 Mao<br>East 3</span></td>
														<td class = "border" >
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yin" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[2]) ?  $heaven_plate[2] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[2]) ?  $hidden_tian[2] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[2]) ?  '<font color="red">'.$good_special_structure[2].'</font>' : '')?><?php echo(isset($bad_special_structure[2]) ?  '<font color="blue">'.$bad_special_structure[2].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[2]) ?  $deity[2] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[2]) ?  $deity_eng[2] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="green">Wood</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[2]) ?  $star_plate[2] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[2]['chinese']) ?  $structure[2]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[2]) ?  $eight_door_plate[2] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" >
															<table class = 'none'>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[4]['chinese']) ?  $structure[4]['chinese'] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px"></td>
																	<td class = 'upperright' width="58px" height="50px"></td>
																</tr>
																<tr>
																	<td class = 'none' colspan = '3' width = '175px' height = '50px'>MODing Your Zen <br>Metaphysicssecrets.com</td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[4]['chinese']) ?  $structure[4]['chinese'] : '')?></span></td>
																	<td class = 'nonebottom'></td>
																	<td class = 'bottomright'></td>
																</tr>
															</table>
														</td>
														<td class = "border" >
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yang" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[6]) ?  $heaven_plate[6] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[6]) ?  $hidden_tian[6] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[6]) ?  '<font color="red">'.$good_special_structure[6].'</font>' : '')?><?php echo(isset($bad_special_structure[6]) ?  '<font color="blue">'.$bad_special_structure[6].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[6]) ?  $deity[6] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[6]) ?  $deity_eng[6] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="orange">Metal</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[6]) ?  $star_plate[6] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[6]['chinese']) ?  $structure[6]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[6]) ?  $eight_door_plate[6] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" align="center" height = '150px' <?php echo(isset($death_emptiness) ? (preg_match('/酉/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/酉/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>><span class='rotate90'>Rooster<br>酉 You<br>West 7</span></td>
													</tr>
													<tr>
														<td class = "border" align="center" height = '150px' <?php echo(isset($death_emptiness) ? (preg_match('/寅/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/寅/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>><span class='rotate270'>Tiger<br>寅 Yin</span></td>
														<td class = "border">
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yin" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[7]) ?  $heaven_plate[7] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[7]) ?  $hidden_tian[7] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[7]) ?  '<font color="red">'.$good_special_structure[7].'</font>' : '')?><?php echo(isset($bad_special_structure[7]) ?  '<font color="blue">'.$bad_special_structure[7].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[7]) ?  $deity[7] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[7]) ?  $deity_eng[7] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="brown">Earth</font></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[7]) ?  $star_plate[7] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[7]['chinese']) ?  $structure[7]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[7]) ?  $eight_door_plate[7] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border">
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yin" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[0]) ?  $heaven_plate[0] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[0]) ?  $hidden_tian[0] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[0]) ?  '<font color="red">'.$good_special_structure[0].'</font>' : '')?><?php echo(isset($bad_special_structure[0]) ?  '<font color="blue">'.$bad_special_structure[0].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[0]) ?  $deity[0] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[0]) ?  $deity_eng[0] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="blue">Water</font></span></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[0]) ?  $star_plate[0] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[0]['chinese']) ?  $structure[0]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[0]) ?  $eight_door_plate[0] : '')?></span></td>
																</tr>
															</table>
														</td>
														<!-- Author: Dave Chen -->
														<td class = "border">
															<table class = 'none' <?php echo(isset($structure_yin_yang) ? ($structure_yin_yang == "Yang" ? 'bgcolor="#B8B8E6"' : '') : '')?>>
																<tr>
																	<td class = 'upperleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($heaven_plate[5]) ?  $heaven_plate[5] : '')?><br>&nbsp;&nbsp;&nbsp;<?php echo(isset($hidden_tian[5]) ?  $hidden_tian[5] : '')?></span></td>
																	<td class = 'nonetop' width="58px" height="50px" rowspan='3'><?php echo(isset($good_special_structure[5]) ?  '<font color="red">'.$good_special_structure[5].'</font>' : '')?><?php echo(isset($bad_special_structure[5]) ?  '<font color="blue">'.$bad_special_structure[5].'</font>' : '')?></td>
																	<td class = 'upperright' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($deity[5]) ?  $deity[5] : '')?><br/><span style="font-size: 12px"><?php echo(isset($deity_eng[5]) ?  $deity_eng[5] : '')?></span></span></td>
																</tr>
																<tr>
																	<td class = 'noneleft' width="58px" height="50px"><font color="orange">Metal</font></span></td>
																	<!-- <td class = 'none'></td> -->
																	<td class = 'noneright'><span style="font-size: 20px"><?php echo(isset($star_plate[5]) ?  $star_plate[5] : '')?></span></td>
																</tr>
																<tr>
																	<td class = 'bottomleft' width="58px" height="50px"><span style="font-size: 20px"><?php echo(isset($structure[5]['chinese']) ?  $structure[5]['chinese'] : '')?></span></td>
																	<!-- <td class = 'nonebottom'>Negative</td> -->
																	<td class = 'bottomright'><span style="font-size: 20px"><?php echo(isset($eight_door_plate[5]) ?  $eight_door_plate[5] : '')?></span></td>
																</tr>
															</table>
														</td>
														<td class = "border" align="center" height = '150px'<?php echo(isset($death_emptiness) ? (preg_match('/戌/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/戌/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>><span class='rotate90'>Dog<br>戌 Xu</span></td>
													</tr>
													<tr>
														<td class = "border">NE 8</td>
														<td class = "border" <?php echo(isset($death_emptiness) ? (preg_match('/丑/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/丑/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>>Ox 丑 Chou</td>
														<td class = "border" <?php echo(isset($death_emptiness) ? (preg_match('/子/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/子/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>>North 1<br>Rat 子 Zi</td>
														<td class = "border" <?php echo(isset($death_emptiness) ? (preg_match('/亥/', $death_emptiness) == 1 ? 'bgcolor="#66FFFF"' : '') : '' ); echo(isset($horse_star) ? (preg_match('/亥/', $horse_star) == 1 ? 'bgcolor="#FF3030"' : '') : '' ); ?>>Pig 亥 Hai</td>
														<td class = "border">NW 6</td>
													</tr>
												</table>
												</tr>
												</table>

												</form>
											</div>
										</div>
									</div>
						</div>
					 </div>
					 <div class="shadow">&nbsp;</div>
			  </div>    
	  </div>    
	
</body>
<script src="jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<script src="jquery/jquery.datetimepicker.js"></script>
  
<script>
	$('#datepicker').datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		yearStart:'1910'
	});

</script>
</html>