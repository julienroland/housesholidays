<?
class Common
{
	
	// nombre de location trouvé
	function listBySearchAttr($data){
		
		//trace($data);
		extract($data);
		
		$condition = '';
		
		if(!empty($type)){
			$condition .= "AND housing_type='".mysql_real_escape_string($type)."'";
		}
		
		if(!empty($country)){
			$condition.= "AND country='".mysql_real_escape_string($country)."'";	
		}
		
		if(!empty($state)){
			$condition.= "AND state='".mysql_real_escape_string($state)."'";	
		}
		
		if(!empty($destination)){
			$condition.= "AND city='".mysql_real_escape_string($destination)."'";	
		}		
		
		$s = "SELECT id FROM property_information WHERE active='1' $condition";
		//echo $s;
		$q = mysql_query($s);
		$t = mysql_num_rows($q);
		
		return $t;
	}
	
	
	//Destination function start
	//Location management
	function createLocation($data,$location_type)
	{	   
	   	$location =  $data[$location_type];	   	
		$data[$location_type.'_name_french']=$location;
		$data[$location_type.'_name_german']=$location;
		$data[$location_type.'_name_spanish']=$location;
		$data[$location_type.'_name_dutch']=$location;	
		$data[$location_type.'_name_english']=$location;	
		$data[$location_type]='_IGN';
		return insert("site_".$location_type,$data);
	}	
	
	function updateLocation($data,$location_type)
	{	
		//print_r($data);
		$data[$location_type.'_name_'.$_SESSION['language_location']] = $data[$location_type];	   	
		unset($data[$location_type]);
		
		return update("site_".$location_type,$data,"id = '".$data["id"]."'",true);		
	}
	
	function updateIP($data)
	{ 		
 		mysql_query("UPDATE site_country SET ip='".$data['ip']."' WHERE id = '".$data['id']."'");	
	}		
	function deleteLocation($location_id,$location_type)
	{
	     //mysql_query("UPDATE site_location_".$location_type." SET is_delete=1 WHERE ".$location_type."_id = '$location_id'");
		mysql_query("DELETE FROM site_".$location_type." WHERE  id = '$location_id'");
	}	
	function listLocation($location_type)
	{
		return multiResult("site_".$location_type," 1=1 "," * ");
	}
	
	function listIPS($start,$pagesize){
		$list=array('result'=>array(),'total'=>0);
		$query="SELECT * FROM site_country";
		
		$limit=" LIMIT ".$start.",".$pagesize."";
	    $list[total]=singleResult('site_country',' 1 ',' count(*) ');
		
	    $query.=$limit;
		$result=mysql_query($query);
		echo mysql_error();		

		while($row=mysql_fetch_array($result))
		{
			array_push($list[result],$row);	
		}
		return $list;
	}
	
	function listCountry()
	{
	   $details=singleMultiResult('site_country'," 1  ORDER BY country_name_".$_SESSION['lang'], " * ");
		return $details;
	}	
	
	function listCountryDispo()
	{
	/*Old-One*/
	// $s = 	"SELECT * FROM site_country 
			// INNER JOIN property_information 
			// ON property_information.country_id = site_country.id 
			// GROUP BY site_country.id
			// ORDER BY site_country.country_name_".$_SESSION['lang'];
			
	$s = 	"SELECT id, country_name_".$_SESSION['lang']." FROM site_country
				ORDER BY country_name_".$_SESSION['lang'];
		
		$q = mysql_query($s);
		$r = mysql_fetch_all($q);

		return $r;
	}	
	
/*
* listRegion
*/
	function listRegion($country_id)
	{
		$details=singleMultiResult('site_region'," country_id ='".$country_id."' ORDER BY region_name_".$_SESSION['lang']."", " * ");
		return $details;
	}

	function listRegionByCountryName($country_name)
	{
		$details=singleMultiResult('site_region'," country_id =(SELECT id FROM site_country WHERE country_name_".$_SESSION['lang']."='".$country_name."') ORDER BY region_name_".$_SESSION['lang']."", " * ");
		return $details;
	}	
		
	
/*
* listState
*/

	function listState($country_id)
	{

		// au cas ou l'id serait le nom en anglais j'ai laissé l'ancien OR country_name_english= ,.. on sait jamais tellement pourri ici
		$details=singleMultiResult('site_state'," country_id ='".$country_id."' OR country_id IN (SELECT id FROM site_country WHERE country_name_".$_SESSION[lang]." = '".$country_id."') ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}
	
	function listStateByCountry($country_id)
	{
		if($_SESSION['lang']==NULL){
			$_SESSION['lang']='english';
		}
		$details=singleMultiResult('site_state'," country_id='".$country_id."' ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}
	
	function listStateByCountryName($country_name)
	{
		$details=singleMultiResult('site_state'," country_id=(SELECT id FROM site_country WHERE country_name_".$_SESSION['lang']."='".$country_name."') ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}
		
	function listStateByRegionName($region_name)
	{
		$details=singleMultiResult('site_state'," region_id=(SELECT id FROM site_region WHERE region_name_".$_SESSION['lang']."='".$region_name."') ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}
	
	function listStateByRegionId($region_id)
	{
		$details=singleMultiResult('site_state'," region_id='".$region_id."' ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}
	
	function listStateByRegionAndCountry($country_id,$region_id)
	{
		$details=singleMultiResult('site_state'," region_id='".$region_id."' AND country_id='".$country_id."' ORDER BY state_name_".$_SESSION['lang']."", " * ");
		return $details;
	}

/*
* listCity
*/

	function listCityByStateName($state)
	{
		$details=singleMultiResult('site_city'," state_id=(SELECT id FROM site_state WHERE state_name_english='".$state."') ORDER BY city_name_".$_SESSION['lang'], " * ");
		return $details;
	}


	function listCity($state)
	{
	  	global $_REQUEST;
		
		if(is_numeric($state))
		{
			$details=singleMultiResult('site_city'," state_id ='".$state."' ORDER BY city_name_".$_SESSION['lang'], " * ");
			return $details;
		}
		else
		{
			
			$details=singleMultiResult('site_city'," state_id = '".$state_id."' ORDER BY 'city_name_".$_SESSION['lang']."'", " * ");
			return $details;
		}
	}

	function listCityItaly()
	{
	  	$s = 	"SELECT city_name_".$_SESSION['lang']." FROM site_city WHERE italy_city=1
	  			ORDER BY city_name_".$_SESSION['lang'];
		
		$q = mysql_query($s);
		$r = mysql_fetch_all($q);

		return $r;
	}


	function listCityNotInDB($ville)
	{			
		$s ="
			SELECT city_name_english 
			FROM site_city
			WHERE city_name_english='".$ville."'
				OR city_name_french='".$ville."'
				OR city_name_german='".$ville."'
				OR city_name_spanish='".$ville."'
				OR city_name_dutch='".$ville."'
			";
		$q = mysql_query($s);
		$r = mysql_fetch_all($q);

		return empty($r); // vrai si la ville n'est pas dans la DB (indépendemment de la case)
	}		



/*
*	UPDATE region_id => state dans property information
*/
	
	function updatePropertyInfState($id,$s_id)
	{
		mysql_query("UPDATE property_information SET region_id = '".$id."' WHERE state_id = '".$s_id."'");
	}
	
///////////////////////////////////////////////////////
  //
	//Destination function end
	
	
	//Suggestion function start
	function listSuggestionActive()
	{
		$details=singleMultiResult('suggestion'," active = 1 ", " * ");
		return $details;
	}
	function listSuggestionAll()
	{
		$details=singleMultiResult('suggestion'," 1 ", " * ");
		return $details;
	}
	function newSuggestion($data)
	{
		global $CONFIG;
		$query="INSERT INTO suggestion (postedby,email,suggestion,date) VALUES ('".$data[postedby]."','".$data[email]."','".$data[suggestion]."','".$CONFIG->timestamp."')";
		mysql_query($query);
	}
	function activateSuggestion($id)
	{
		$query="UPDATE suggestion SET active = 1 WHERE id= '".$id."'";
		mysql_query($query);
	}
	function deactivateSuggestion($id)
	{
		$query="UPDATE suggestion SET active = 0 WHERE id= '".$id."'";
		mysql_query($query);
	}
	function deleteSuggestion($id)
	{
		$query="DELETE FROM suggestion WHERE id= '".$id."'";
		mysql_query($query);
	}
	//Suggestion function end
	
	//Subscriber functions
	function listSubscriber($data,$start,$pagesize)
	{
		$condition="1=1";
		$condition .=!empty($data['emailsearch'])?" AND email like '%".$data['emailsearch']."%'":'';
		$list=array('result'=>array(),'total'=>0);
		$query="SELECT * FROM subscription_request WHERE ";

		
		$limit=" LIMIT ".$start.",".$pagesize."";
	    $list[total]=singleResult('subscription_request',$condition,' count(*) ');
		$query .=$condition;
	    $query.=$limit;
		//echo $query;
		$result=mysql_query($query);
		echo mysql_error();
		

		while($row=mysql_fetch_array($result))
		{
			array_push($list[result],$row);	
		}
		return $list;
	}
	function listSubscriberEmailAll()
	{
		$list=array();
		$query="SELECT email FROM subscription_request WHERE active = 1 ";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			array_push($list,$row[email]);	
		}
		return $list;
	}
	function deleteSubscription($email)
	{
		 $query="DELETE FROM subscription_request WHERE email= '".$email."'";
		mysql_query($query);
	}
    function deleteSubscriptionByid($id)
	{
		$query="DELETE FROM subscription_request WHERE id= '".$id."'";
		mysql_query($query);
	}
	function updateSubscription($id,$feild,$value)
	{
		$query="UPDATE subscription_request SET $feild = '".$value."' WHERE id= '".$id."'";
		mysql_query($query);
	}
	function newSubscription($data)
	{
		global $CONFIG;
		
		$query="INSERT INTO subscription_request (email,date,ip) VALUES ('".$data[email]."','".$CONFIG->timestamp."','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($query);
	}
	//
	
	//Banner management function
	
	//Demo banner management
	//---------------------------
	 function listDemoBanner($data,$start="",$pagesize="")
	{
		//#############
		$list=array('result'=>array(),'total'=>0);
		$condition="1=1";

                if($data['active'])
                {
                    $condition .=" AND active='".$data['active']."'";
                }

                if($data['position'])
                {
                    $condition .=" AND position='".$data['position']."'";
                }

		$query="SELECT * FROM site_demobanners WHERE ";
		$limit=" LIMIT ".$start.",".$pagesize."";
		$list[total]=singleResult('site_demobanners',$condition,' count(*) ');
		$query .=$condition;
		if($pagesize)
                    $query.=$limit;

		$result=mysql_query($query);
		echo mysql_error();

		while($row=mysql_fetch_array($result))
		{
			array_push($list[result],$row);
		}
		return $list;
	}

        function addDemoBanner($data_banner)
	{
            global $CONFIG;

                //New file name
                $filename=time();
                $extension=substr($_FILES[banner][name],strlen($_FILES[banner][name])-3,3);
                //Collecting parameter
                $data['image']=$filename.'.'.$extension;
                $data['position']=$data_banner['position'];
                $data['size_info']=$data_banner['size_info'];
                $data['rate']=$data_banner['rate'];
                //Uploading
		if(move_uploaded_file($_FILES['banner']['tmp_name'],$CONFIG->rootdir.'/lib.banners/demo_banner/'.$filename.'.'.$extension))
                {
                    mysql_query("INSERT INTO site_demobanners (image,position,rate,size_info) VALUES ('".$data['image']."','".$data['position']."','".$data['rate']."','".$data['size_info']."')");
                    return mysql_insert_id();
                }
                else
                    return false;
	}

        function updateDemoBanner($data_banner)
	{
            global $CONFIG;
                //New file name
                if($_FILES['banner']['name']!='')
                {
                        $filename=time();
                        $extension=substr($_FILES[banner][name],strlen($_FILES[banner][name])-3,3);

                        //Collecting parameter
                        $data['image']=$filename.'.'.$extension;

                        //Removing old file
                        unlink($CONFIG->rootdir.'/lib.banners/demo_banner/'.$_REQUEST[filename]);

                        //Uploading
                        move_uploaded_file($_FILES[banner][tmp_name],$CONFIG->rootdir.'/lib.banners/demo_banner/'.$filename.'.'.$extension);
                }
                else
                $data['image']=$data_banner['filename'];

                $data['position']=$data_banner['position'];
                $data['size_info']=$data_banner['size_info'];
                $data['demo_id']=$data_banner['id'];
                $data['rate']=$data_banner['rate'];
                //print "UPDATE ".DB_PR."site_demobanners SET image = '".$data['image']."',position = '".$data['position']."',rate = '".$data['rate']."' WHERE id = '".$data[demo_id]."'";
		mysql_query("UPDATE site_demobanners SET image = '".$data['image']."',size_info = '".$data['size_info']."',position = '".$data['position']."',rate = '".$data['rate']."' WHERE demo_id = '".$data[demo_id]."'");
	}

        function deleteDemoBanner($data)
	{
		@unlink('../../lib.banners/demo_banner/'.$data[filename]);
		mysql_query("DELETE FROM site_demobanners WHERE demo_id = '".$data[id]."'");
	}

        function setStatusDemoBanner($data)
        {
            mysql_query("UPDATE site_demobanners SET active=".$data['status']." where demo_id=".$data['id']);
        }
	
        
        
	//--------------------------------------------------------------------------------------------------------------------
	function listBanner($data,$start="",$pagesize="")
	{
		//#############
		$list=array('result'=>array(),'total'=>0);
		$condition="1=1";
		
		if($data['Country']){
		   $condition.=($condition)?' AND ':'';
		   $condition .="country_id IN (SELECT id FROM site_country WHERE country_name_".$_SESSION['lang']." LIKE '%".$data[Country]."%')";
		}
		
		if($data['Province']){		
		   $condition.=($condition)?' AND ':'';
		   $condition .="state_id IN (SELECT id FROM site_state WHERE state_name_".$_SESSION['lang']." LIKE '%".$data[Province]."%')";
		}
		
		if($data['Destination']){
		   $condition.=($condition)?' AND ':'';
		   $condition .="city_id IN (SELECT id FROM site_city WHERE city_name_".$_SESSION['lang']." LIKE '%".$data[Destination]."%')";
		}
		
		$query="SELECT * FROM site_banner WHERE ";

		
		$limit=" LIMIT ".$start.",".$pagesize."";
	    $list[total]=singleResult('site_banner',$condition,' count(*) ');
		$query .=$condition;
		if($pagesize)
		$query.=$limit;
		
		$result=mysql_query($query);
		echo mysql_error();

		while($row=mysql_fetch_array($result))
		{
		    $_SESSION['lang']=isset($_SESSION['lang'])?$_SESSION['lang']:'english';
			$row['country']=singleResult('site_country',' id='.$row['country_id'],'country_name_'.$_SESSION['lang']);
			$row['state']=singleResult('site_state',' id='.$row['state_id'],'state_name_'.$_SESSION['lang']);
			$row['city']=singleResult('site_city',' id='.$row['city_id'],'city_name_'.$_SESSION['lang']);
			array_push($list[result],$row);	
		}
		return $list;
	}
		
	
	function addBanner($data)
	{
		mysql_query("INSERT INTO site_banner (image,link,rate) VALUES ('".$data['image']."','".$data['link']."','".$data['rate']."')");
		return mysql_insert_id();
	}
	function updateBanner($data)
	{
		mysql_query("UPDATE site_banner SET image = '".$data['image']."',link = '".$data['link']."',rate = '".$data['rate']."' WHERE id = '".$data[id]."'");
	}
	function updateBannerArrange($detail)
	{
		//#############
		
		$data[pagename]=$detail[pagename];
		$data[position]=$detail[position];
		$data[country_id]=$detail[country_id];
		$data[state_id]=$detail[state_id];
		$data[city_id]=$detail[city_id];
		//$data[id]=$detail[id];
		update("site_banner",$data,"id='".$detail[id]."'",true);
	}
	function deleteBanner($data)
	{
		@unlink('../../lib.banners/'.$data[filename]);
		mysql_query("DELETE FROM site_banner WHERE id = '".$data[id]."'");
	}
	function getBanner_backup_12112010($position,$location)
	{
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'index.php')!==false)
			$pagename='homepage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'locations-de-vacances.php')!==false)
			$pagename='productlistpage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'detail.php')!==false)
			$pagename='productdetailpage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'aboutus.php')!==false)
			$pagename='aboutus';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'offers.php')!==false)
			$pagename='offers';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'suggestion.php')!==false)
			$pagename='suggestion';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'map.php')!==false)
			$pagename='map';

		$condition="pagename LIKE '%".$pagename."%' AND position LIKE '%".$position."%' ";
		if($location[city_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" city_id = '".$location[city_id]."' ";
		}
		if($location[state_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" state_id = '".$location[state_id]."' ";
		}
		if($location[country_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" country_id  = '".$location[country_id]."' ";
		}
		
		if($pagename)
			$details=singleMultiResult('site_banner',$condition, " * ");
		 
		return $details;
	}

	function getBanner($position,$location)
	{
		 //echo $position.' - '.$location;
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'index.php')!==false)
			$pagename='homepage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'locations-de-vacances.php')!==false)
			$pagename='productlistpage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'detail.php')!==false)
			$pagename='productdetailpage';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'quisommesnous.php')!==false)
			$pagename='aboutus';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'offres-speciales.php')!==false)
			$pagename='offers';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'suggestion.php')!==false)
			$pagename='suggestion';
		 if(strpos($_SERVER['SCRIPT_FILENAME'],'map.php')!==false)
			$pagename='map';
			
		$condition="active=1";

		$condition.=" AND pagename = '".$pagename."' AND position = '".$position."' ";
		//echo $location[country_id];
		if($location[country_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" country_id  = '".$location[country_id]."' ";
		}
		if($location[state_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" state_id = '".$location[state_id]."' ";
		}
		if($location[city_id])
		{
			$condition.=($condition)?' AND ':'';
			$condition.=" city_id = '".$location[city_id]."' ";
		}
		
		
		if($pagename){
			
			$details=singleMultiResult('advertiser_banners',$condition, " * ");
	 		if ($details)
					{
					$pepe= ($details[0]['advbanners_id']);
					//echo "UPDATE advertiser_banners SET no_views = no_views+1 WHERE advbanners_id=".$pepe;
					 mysql_query("UPDATE advertiser_banners SET no_views = no_views+1 WHERE advbanners_id=".$pepe);
					}
			}
		//trace($details);
		return $details;
	}
	
	function detailBanner($id)
	{
		return singleMultiResult('site_banner',"id='".$id."'","*");
	
	}
	
	//update number of clicks on the banner
	function updateBannerClick($id){
	    $click=singleResult('advertiser_banners'," advbanners_id='".$id."' ",'no_clicks ');
   	    mysql_query("UPDATE advertiser_banners SET no_clicks = ".($click+1)." WHERE advbanners_id=".$id."");
	}
	
//	//visited functions
//	 function updateBannerVisited($id)
//	 {	
//	 	 echo "hola";
//			  $views=0;
//		 echo "UPDATE advertiser_banners SET no_views =  WHERE advbanners_id=";
//		 $views=singleResult('advertiser_banners'," advbanners_id='".$id."' ",'no_views ');
//   		 mysql_query("UPDATE advertiser_banners SET no_views = ".($views+1)." WHERE advbanners_id=".$id."");
//	 }
	//visited functions
	 function bannerVisto($valor)
	 {	
	 	 echo "hola";
	 }
	
	 
	 //Function to add to cart and store in cart session	
	function addBannCart($data){	
	   $subtotal=$data['rate']*1;
	  if(empty($_SESSION['cart'])){	   		
	   		$_SESSION['cart'] = array($data['id']=>  						       
							   	         array(
											'image'=>$data['image'],
											'rate'=>$data['rate'],
							   				'quantity'=>1,
							   	         	'noofmonths'=>1,
											'subtotal'=>$subtotal,
											'id'=>$data['id'],
											'link'=>$data['link']
										  )
						         );
	  }else{
	     if(@in_array($data['id'],$_SESSION['cart'][$data['id']])){
		     $_SESSION['cart'][$data['id']]['quantity']=$_SESSION['cart'][$data['id']]['quantity']+1;
		     if(isset($_SESSION['cart'][$data['id']]['noofmonths']))
		     {
		     	$subtotal=$subtotal*$_SESSION['cart'][$data['id']]['noofmonths'];
		     }
			 $_SESSION['cart'][$data['id']]['subtotal']=$_SESSION['cart'][$data['id']]['subtotal']+$subtotal;
		 }else{		        
				$newArray = array($data['id']=>  						       
							   	         array(
											'image'=>$data['image'],
											'rate'=>$data['rate'],
							   				'quantity'=>1,
							   	         	'noofmonths'=>1,
											'subtotal'=>$subtotal,
											'id'=>$data['id'],
											'link'=>$data['link']
										  )
						         );
				$_SESSION['cart'] = $_SESSION['cart']+$newArray;				
												  
	      }//End - inner else	          
	   }//End - outer if/else
	}//End- function
	
	
	
	//Function to remove from cart
	function removeBannCart($id){
	    unset($_SESSION['cart'][$id]);
		unset($_SESSION['cart'][$id]['image']);
		unset($_SESSION['cart'][$id]['rate']);
		unset($_SESSION['cart'][$id]['quantity']);
		unset($_SESSION['cart'][$id]['subtotal']);
		unset($_SESSION['cart'][$id]['id']);
		unset($_SESSION['cart'][$id]['link']);
	}//End - function
	
	
	//Update cart with new quantity and subtotal
	function updateBannCartInfo($data){
	    if(@in_array($data['id'],$_SESSION['cart'][$data['id']])){
		     $_SESSION['cart'][$data['id']]['quantity']=$data['quantity'];
			 $_SESSION['cart'][$data['id']]['subtotal']=$data['subtotal'];
                         $_SESSION['cart'][$data['id']]['noofmonths']=$data['noofmonths'];
		 }
	}//End - function
	
	
	function completeBannerPayment($cart,$rate,$order,$access_code){
            global $CONFIG;
	    if(count($cart)>0){
		  foreach($cart as $key){
		    $details = $this->detailBanner($key['id']);
		    mysql_query("INSERT INTO advertiser_banners SET advertiserid = '".$_SESSION['advertiserid']."',noofmonths='".$key['noofmonths']."',order_no = '".$order."',banners_id = '".$key['id']."',created_on = '".time()."',updated_on = '".time()."',pagename = '".$details[0]['pagename']."',position = '".$details[0]['position']."',country_id = '".$details[0]['country_id']."',state_id = '".$details[0]['state_id']."',city_id = '".$details[0]['city_id']."',image = '".$details[0]['image']."',link = '".$details[0]['link']."',  	no_views = '".$details[0]['no_views']."',no_clicks = '".$details[0]['no_clicks']."'");
		  }
		  mysql_query("INSERT INTO banner_orders SET advertiserid = '".$_SESSION['advertiserid']."',order_no = '".$order."',payment = '".$rate."',created_on = '".time()."',updated_on = '".time()."'");
		  mysql_query("UPDATE advertiser SET access_code = '".$access_code."' WHERE id = '".$_SESSION['advertiserid']."'");		
		  
		  $message="";
			if($_SESSION['user_lang']=='english')
			{
				$message.="	Date:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Dear  ".$_SESSION['name']." ,<br /><br />";
				$message.="Thank you for purshasing banners with Housesholidays.com <br />";				
				$message.="Your order has been sucessfully billed.  Here are some details of this specific transaction :<br />	<br />";
				$message.="Sale Number : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Your Access Code : <strong>".$access_code."</strong><br />	<br />";
				$message.="Your Banner details are as follows: <br /><br />";	
				  foreach($_SESSION['cart'] as $key){				    
					  $message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
					  $message.="Rate: ".$key['rate']."<br />";
					  $message.="Quantity: ".$key['quantity']."<br />";
					  $message.="<br />------------------------------------------<br />";
				  }
				  $message.="<br /><br />";
				  $message.="Total Billed Today : <strong>".$_SESSION['banner_rate']."</strong> &euro;<br /><br />";
				  $message.="Best Regards <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='spanish')
			{
				$message.="	Fecha:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Estimado ".$CONFIG->name." ,<br /><br />";
				$message.="Gracias por purshasing pancartas con Housesholidays.com <br />";				
				$message.="Su pedido ha sido correctamente facturados. &Eacute;stos son algunos de los detalles de esta operaci&oacute;n espec&iacute;fica :<br />	<br />";
				$message.="N&uacute;mero de venta : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Su C&oacute;digo de Acceso : <strong>".$access_code."</strong><br />	<br />";
				$message.="Sus datos son los siguientes Banner: <br /><br />";	
				  foreach($_SESSION['cart'] as $key){				    
					  $message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
					  $message.="Ritmo: ".$key['rate']."<br />";
					  $message.="Cantidad: ".$key['quantity']."<br />";
					  $message.="<br />------------------------------------------<br />";
				  }
				  $message.="<br /><br />";
				  $message.="Hoy facturados total : <strong>".$_SESSION['banner_rate']."</strong> &euro;<br /><br />";
				  $message.="Saludos cordiales <br/>www.housesholiday.com team";
			}
			
			if($_SESSION['user_lang']=='french')
			{
			
				$message.="	Date:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Cher  ".$_SESSION['name']." ,<br /><br />";
				$message.="Nous vous remercions de ACHAT banni&egrave;res avec Housesholidays.com <br />";				
				$message.="Votre commande a &eacute;t&eacute; d&eacute;bit&eacute;e. Voici quelques d&eacute;tails de cette op&eacute;ration sp&eacute;cifique :<br />	<br />";
				$message.="Num&eacute;ro de vente : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Votre code d'acc&egrave;s : <strong>".$access_code."</strong><br />	<br />";
				$message.="Les d&eacute;tails de votre banni&egrave;re sont les suivantes: <br /><br />";	
				  foreach($_SESSION['cart'] as $key){				    
					  $message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
					  $message.="Taux: ".$key['rate']."<br />";
					  $message.="Quantit&eacute;: ".$key['quantity']."<br />";
					  $message.="<br />------------------------------------------<br />";
				  }
				  $message.="<br /><br />";
				  $message.="Total Aujourd'hui Factur&eacute; : <strong>".$_SESSION['banner_rate']."</strong> &euro;<br /><br />";
				  $message.="Cordialement <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='dutch')
			{
				$message.="	Datum:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Geachte   ".$_SESSION['name']." ,<br /><br />";
				$message.="Dank u voor purshasing spandoeken met Housesholidays.com <br />";				
				$message.="Uw bestelling is succesvol gefactureerd. Hier zijn een aantal bijzonderheden van deze specifieke transactie :<br />	<br />";
				$message.="Aantal koop : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Uw toegangscode : <strong>".$access_code."</strong><br />	<br />";
				$message.="Uw Banner details zijn als volgt: <br /><br />";	
				  foreach($_SESSION['cart'] as $key){				    
					  $message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
					  $message.="Tarief: ".$key['rate']."<br />";
					  $message.="Aantal: ".$key['quantity']."<br />";
					  $message.="<br />------------------------------------------<br />";
				  }
				  $message.="<br /><br />";
				  $message.="Totaal Billed Vandaag : <strong>".$_SESSION['banner_rate']."</strong> &euro;<br /><br />";
				  $message.="Met vriendelijke groet <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='german')
			{
				$message.="	Datum:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Sehr geehrte  ".$_SESSION['name']." ,<br /><br />";
				$message.="Vielen Dank f&uuml;r purshasing Banner mit Housesholidays.com <br />";				
				$message.="Ihre Bestellung wurde erfolgreich in Rechnung gestellt. Hier sind einige Details dieser Transaktion :<br />	<br />";
				$message.="Verkauf Anzahl : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Ihre Access-Code : <strong>".$access_code."</strong><br />	<br />";
				$message.="Ihr Banner Details sind wie folgt: <br /><br />";	
				  foreach($_SESSION['cart'] as $key){				    
					  $message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
					  $message.="Rate: ".$key['rate']."<br />";
					  $message.="Menge: ".$key['quantity']."<br />";
					  $message.="<br />------------------------------------------<br />";
				  }
				  $message.="<br /><br />";
				  $message.="Insgesamt Billed Heute : <strong>".$_SESSION['banner_rate']."</strong> &euro;<br /><br />";
				  $message.="Best Regards <br/>www.housesholiday.com team";
			}
			
						
			$message_template=file_get_contents($CONFIG->rootdir.'/lib.src/mail_template.html');
			$message=str_replace('__CONTENT__',$message,$message_template);
			sendMail($_SESSION['email'],"Support Team","support@housesholidays.com","Payment Confirmation mail",$message);
		  
		  
		   
		}		 //End - if 
	}
	
	function completeSingleBannerPayment($tmp_banner_id,$bannerid,$order,$totalrate,$access_code)
	{
		global $CONFIG;
		if($tmp_banner_id==$bannerid)
		{
			
		    mysql_query("INSERT INTO banner_orders SET advertiserid = '".$_SESSION['advertiserid']."',order_no = '".$order."',payment = '".$totalrate."',created_on = '".time()."',updated_on = '".time()."'");
		    mysql_query("UPDATE advertiser SET access_code = '".$access_code."' WHERE id = '".$_SESSION['advertiserid']."'");		
		  
		    $message="";
			if($_SESSION['user_lang']=='english')
			{
				$message.="	Date:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Dear  ".$_SESSION['name']." ,<br /><br />";
				$message.="Thank you for purshasing banners with Housesholidays.com <br />";				
				$message.="Your order has been sucessfully billed.  Here are some details of this specific transaction :<br />	<br />";
				//$message.="Sale Number : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Your Access Code : <strong>".$access_code."</strong><br />	<br />";
				//$message.="Your Banner details are as follows: <br /><br />";	
				//$message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
				
				  //$message.="<br /><br />";
				  $message.="Total Billed Today : <strong>".$_SESSION['TotalRate']."</strong> &euro;<br /><br />";
				  $message.="Best Regards <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='spanish')
			{
				$message.="	Fecha:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Estimado ".$CONFIG->name." ,<br /><br />";
				$message.="Gracias por purshasing pancartas con Housesholidays.com <br />";				
				$message.="Su pedido ha sido correctamente facturados. &Eacute;stos son algunos de los detalles de esta operaci&oacute;n espec&iacute;fica :<br />	<br />";
				//$message.="N&uacute;mero de venta : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Su C&oacute;digo de Acceso : <strong>".$access_code."</strong><br />	<br />";
				//$message.="Sus datos son los siguientes Banner: <br /><br />";	
				//$message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
				
				  //$message.="<br /><br />";
				  $message.="Hoy facturados total : <strong>".$_SESSION['TotalRate']."</strong> &euro;<br /><br />";
				  $message.="Saludos cordiales <br/>www.housesholiday.com team";
			}
			
			if($_SESSION['user_lang']=='french')
			{
			
				$message.="	Date:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Cher  ".$_SESSION['name']." ,<br /><br />";
				$message.="Nous vous remercions de ACHAT banni&egrave;res avec Housesholidays.com <br />";				
				$message.="Votre commande a &eacute;t&eacute; d&eacute;bit&eacute;e. Voici quelques d&eacute;tails de cette op&eacute;ration sp&eacute;cifique :<br />	<br />";
				//$message.="Num&eacute;ro de vente : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Votre code d'acc&egrave;s : <strong>".$access_code."</strong><br />	<br />";
				//$message.="Les d&eacute;tails de votre banni&egrave;re sont les suivantes: <br /><br />";
				//$message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
				
				  //$message.="<br /><br />";
				  $message.="Total Aujourd'hui Factur&eacute; : <strong>".$_SESSION['TotalRate']."</strong> &euro;<br /><br />";
				  $message.="Cordialement <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='dutch')
			{
				$message.="	Datum:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Geachte   ".$_SESSION['name']." ,<br /><br />";
				$message.="Dank u voor purshasing spandoeken met Housesholidays.com <br />";				
				$message.="Uw bestelling is succesvol gefactureerd. Hier zijn een aantal bijzonderheden van deze specifieke transactie :<br />	<br />";
				//$message.="Aantal koop : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Uw toegangscode : <strong>".$access_code."</strong><br />	<br />";
				//$message.="Uw Banner details zijn als volgt: <br /><br />";	
				//$message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
				
				  //$message.="<br /><br />";
				  $message.="Totaal Billed Vandaag : <strong>".$_SESSION['TotalRate']."</strong> &euro;<br /><br />";
				  $message.="Met vriendelijke groet <br/>www.housesholiday.com team";
			}
			if($_SESSION['user_lang']=='german')
			{
				$message.="	Datum:".date('F j, Y, g:i a'); 
				$message.="<br/><br/>Sehr geehrte  ".$_SESSION['name']." ,<br /><br />";
				$message.="Vielen Dank f&uuml;r purshasing Banner mit Housesholidays.com <br />";				
				$message.="Ihre Bestellung wurde erfolgreich in Rechnung gestellt. Hier sind einige Details dieser Transaktion :<br />	<br />";
				//$message.="Verkauf Anzahl : <strong>".$_SESSION['banner_order']."</strong>	<br />";				
				$message.="Ihre Access-Code : <strong>".$access_code."</strong><br />	<br />";
				//$message.="Ihr Banner Details sind wie folgt: <br /><br />";	
				//$message.="<a href='".$key['link']."'><img src='".$CONFIG->siteurl.'lib.banners/'.$key[image]."' width='120' border='0' /></a><br />";
				
				  //$message.="<br /><br />";
				  $message.="Insgesamt Billed Heute : <strong>".$_SESSION['TotalRate']."</strong> &euro;<br /><br />";
				  $message.="Best Regards <br/>www.housesholiday.com team";
			}
			
						
			$message_template=file_get_contents($CONFIG->rootdir.'/lib.src/mail_template.html');
			$message=str_replace('__CONTENT__',$message,$message_template);
			//print $_SESSION['email'].',"Support Team","support@housesholidays.com","Payment Confirmation mail",'.$message;
			sendMail($_SESSION['email'],"Support Team","support@housesholidays.com","Payment Confirmation mail",$message);
		  
			unset($_SESSION['tmp_banner_id']);
			unset($_SESSION['order_no']);
		}
	}
	//Banner management function
	//--------------------------------------------------------------------------------------------------------------------
	
	
	
	//Site option manager
	function listOption($type)
	{
		$details=singleMultiResult('site_property_options'," opt_type = '".$type."'", " opt_val ");			
		return explode("~",$details[0][0]);		
	}
	function updateOption($type,$val)
	{
		mysql_query("UPDATE site_property_options SET opt_val = '".$val."' WHERE opt_type = '".$type."'");
	}
	
	
	//Site property type options
	function listHousingType()
	{
		$list=array();
		$query="SELECT * FROM site_housing_type ORDER BY opt_val_".$_SESSION['lang'];
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			array_push($list,$row);	
		}
		return $list;
	}
	
	function updateHousingType($val)
	{		
		mysql_query("UPDATE site_housing_type SET opt_val_english = '".$val['opt_val_english']."',opt_val_spanish = '".$val['opt_val_spanish']."',opt_val_german = '".$val['opt_val_german']."',opt_val_french = '".$val['opt_val_french']."',opt_val_dutch = '".$val['opt_val_dutch']."' WHERE id = '".$val['id']."'");
	}
	
	function newHousingType($val)
	{
		
		mysql_query("INSERT INTO site_housing_type SET opt_val_english = '".$val['opt_val_english']."',opt_val_spanish = '".$val['opt_val_spanish']."',opt_val_german = '".$val['opt_val_german']."',opt_val_french = '".$val['opt_val_french']."',opt_val_dutch = '".$val['opt_val_dutch']."'");
	}
	
	function deleteHousingType($val)
	{
		mysql_query("DELETE FROM site_housing_type WHERE id='".$val."'");
	}
	
	
	//Review function start
	function listReviewActive($property_id)
	{
		$details=singleMultiResult('property_review'," active = 1 AND property_id=".$property_id, " * ");
		return $details;
	}
	
	//listing reviews of general users for particual property	
	function listReviewAll()
	{
		$details=singleMultiResult('property_review'," 1 ", " * ");
		return $details;
	}
	function newReview($data)
	{
		global $CONFIG;
		$query="INSERT INTO property_review (property_id,email,postedby,suggestion,date,advertiserid) VALUES ('".$data[property_id]."','".$data[email]."','".$data[postedby]."','".$data[suggestion]."','".$CONFIG->timestamp."','".$_SESSION['advertiserid']."')";
		mysql_query($query);
	}
	function activateReview($id)
	{
		$query="UPDATE property_review SET active = 1 WHERE id= '".$id."'";
		mysql_query($query);
	}
	function deactivateReview($id)
	{
		$query="UPDATE property_review SET active = 0 WHERE id= '".$id."'";
		mysql_query($query);
	}
	function deleteReview($id)
	{
		$query="DELETE FROM property_review WHERE id= '".$id."'";
		mysql_query($query);
	}
	
	function totalReviews($id){
	   $details=singleResult('property_review'," active = 1 AND property_id=".$id,' count(*) ');
	   return $details;
	}
	//Review function end
	
	function updateSetting($data)
	{
		update(" site_setting ",$data," 1 ",false);
	}
	function getSettingVal($feild)
	{
		return singleResult("site_setting "," 1 ",$feild);
	}
	
	//owner content
	
	function ownerContent()
	{
		$details=singleMultiResult('site_owner_content',"1=1", " * ");
		return $details;
	}
	//
	function listPostedOn()
	{	
		$query="SELECT postedon FROM property_information
    	 WHERE DATE_SUB(showdate(postedon),INTERVAL 1 month) <= date_col";
		
		$list=array('result'=>array(),'total'=>0);
		$query="SELECT postedon FROM property_information";

	    $list[total]=singleResult('property_information',' 1 ',' count(*) ');
		//print $query;
		$result=mysql_query($query);
		echo mysql_error();
		while($row=mysql_fetch_array($result))
		{
			array_push($list[result],$row);	
		}
		return $list;
		
	} 
	function settingValue($feild)
	{
		return singleResult("admin_pass"," 1 ",$feild);
	}

	function updatePass($feild,$value)
	{
		mysql_query("UPDATE admin_pass SET ".$feild." = '".$value."'");
	}
	
	
	////////////////////////////////CURRENCY MANAGEMENT////////////////////////////
	
	function setCurStatus($status,$id)
	{
		global $CONFIG;	
		mysql_query("UPDATE site_currency SET active = ".$status." WHERE currency_id='".$id."'");
	}
	
	function updateCurInfo($data)
	{
	    if(!empty($data[currency_id])){
			update('site_currency',$data," currency_id = ".$data[currency_id],false);
		}else{
		    insert('site_currency',$data);
		}
	}
	
	function deleteCur($id)
	{
		global $CONFIG;	
		mysql_query("DELETE FROM site_currency WHERE currency_id=".$id."");
	}
	
	function getCurList($data,$start,$pagesize)
	{
	
		global $CONFIG;
		$list=array('result'=>array(),'total'=>0);
		$query="SELECT * FROM site_currency WHERE  ";
		
		/*if($data[type]=='active')
			$condition=" active = 1 ";
		elseif($data[type]=='inactive')
			$condition=" active = 0 ";
		else*/
			$condition=" 1 ";        
	
			
		$query.=($condition)?$condition:'1';	
		$limit=" LIMIT ".$start.",".$pagesize."";
		
	    $list[total]=singleResult('site_currency',$condition,' count(*) ');
		
	    $query.=$limit;
		$result=mysql_query($query);
		echo mysql_error();
		$i=0;
		while($row=mysql_fetch_array($result))
		{
			array_push($list[result],$row);	
		}
	
		return $list;
	}
	
	function getCurInfo($currency_id)
	{
		$details=singleMultiResult('site_currency'," currency_id=".$currency_id, " * ");
		return $details[0];
	}
	
	function getActiveCur(){	 
		global $CONFIG;
		$list=array();
		$query="SELECT * FROM site_currency WHERE active=1";			
		$result=mysql_query($query);
		echo mysql_error();
		$i=0;
		while($row=mysql_fetch_array($result))
		{
			array_push($list,$row);	
		}	
		return $list;	
	}

   /////////////////////////////////////// END CURRENCY MANAGEMENT//////////////////////////////
   
   	////////////////////////////////HOUSE OF THE WEEK MANAGEMENT////////////////////////////
	
    function listHouse($start="",$pagesize="")
	{
		//#############
		$list=array('result'=>array(),'total'=>0);
		$query="SELECT * FROM site_houseofweek";

		
		$limit=" LIMIT ".$start.",".$pagesize."";
	    $list[total]=singleResult('site_houseofweek',' 1 ',' count(*) ');
		if($pagesize)
		$query.=$limit;
		$result=mysql_query($query);
		echo mysql_error();

		while($row=mysql_fetch_array($result))
		{
			$row['country']=singleResult('site_country',' id='.$row['country_id'],'country_name_english');
			array_push($list[result],$row);	
		}
		return $list;
	}
	function addHouse($data)
	{
		mysql_query("INSERT INTO site_houseofweek (image,link,description) VALUES ('".$data['image']."','".$data['link']."','".$data['description']."')");
		return mysql_insert_id();
	}
	function updateHouse($data)
	{
		mysql_query("UPDATE site_houseofweek SET image = '".$data['image']."',link = '".$data['link']."',description = '".$data['description']."' WHERE house_id = '".$data[house_id]."'");
	}
	function updateHouseArrange($detail)
	{
		//#############
		$condition="country_id='".$detail[country_id]."' AND house_id<>'".$detail[house_id]."'";
		$checkAlready=singleResult('site_houseofweek',$condition,' count(*) ');		
		if(!empty($checkAlready)){
		
		   return false;
		}else{
			$data[country_id]=$detail[country_id];
			update("site_houseofweek",$data,"house_id='".$detail[house_id]."'",true);
			return true;
		}
	}
	function deleteHouse($data)
	{
		@unlink('../../lib.banners/'.$data[filename]);
		mysql_query("DELETE FROM site_houseofweek WHERE house_id = '".$data[house_id]."'");
	}

	
	function detailHouse($house_id)
	{
		return singleMultiResult('site_houseofweek',"house_id='".$house_id."'","*");
	
	}
	
/*	function displayOnFront($detail){ 
		//echo $detail['Country'];
	
	   $list=array();
	   if(!empty($detail['Country'])){
	      $condition = " WHERE country_id IN (SELECT id FROM site_country WHERE country_name_english"." LIKE '".$detail[Country]."')";
	   }else{
	      $condition =" ORDER BY RAND()";
	   }
	   $query = "SELECT * FROM site_houseofweek ";
	   $query .=$condition;
	   $result=mysql_query($query);
	   if(mysql_num_rows($result)<1){
		   	      $query =" SELECT * FROM site_houseofweek ORDER BY RAND()";
				  $result=mysql_query($query);

	   }
	   while($row=mysql_fetch_array($result))
		{
			$row['country']=singleResult('site_country',' id='.$row['country_id'],"country_name_".$_SESSION['lang']);
			array_push($list,$row);	
		}
		return $list;
	   
	}*/
	
	
	function displayOnFront($detail){

		$list=array();
		
		if(!empty($detail['Country'])){
			$condition = " WHERE property_information.country IN (SELECT id FROM site_country WHERE country_name_english"." LIKE '".$detail[Country]."')";
		}else{
			$condition =" ORDER BY RAND()";
		}
		 
		 
		$query = "SELECT site_houseofweek.image, site_houseofweek.description, property_information.id AS pro_id, property_information.housing_type, property_information.country, property_information.state, property_information.city 
								FROM site_houseofweek 
								LEFT JOIN property_information ON site_houseofweek.link LIKE CONCAT('addetail.php?propertyid=', property_information.id)";
		$query .=$condition;
		 
		 
		 //echo $query;
		 
		$result=mysql_query($query);
		 
		 if(mysql_num_rows($result)<1){
				  $query ="SELECT site_houseofweek.image, site_houseofweek.description, property_information.id AS pro_id, property_information.housing_type, property_information.country, property_information.state, property_information.city 
								FROM site_houseofweek 
								LEFT JOIN property_information ON site_houseofweek.link LIKE CONCAT('addetail.php?propertyid=', property_information.id)  
								ORDER BY RAND()";
				  $result=mysql_query($query);

		}
		 
		 while($row=mysql_fetch_array($result))
		{
			array_push($list,$row);	
		}

		//trace($list);
		return $list;	   
	}	
	
		
	/*
	* GET URLREWRITING (Nom pays dans la langue utilisateur => id pays)
	*/
	
	function getCId($country,$lang)
	{
		return $country_id=singleResult('site_country'," country_name_".$lang."='".addslashes($country)."' ","id");
	}
	
	function getRId($region,$lang)
	{
		return $region_id=singleResult('site_region'," region_name_".$lang."='".addslashes($region)."'","id");
	}
	
	function getPId($state,$lang)
	{
		return $state_id=singleResult('site_state'," state_name_".$lang."='".addslashes($state)."'","id");
	}	
	
	function getDId($city,$lang)
	{
		return $city_id=singleResult('site_city'," city_name_".$lang."='".addslashes($city)."'","id");
	}
	
	/*
	* GET COUNTRY
	*/
	
	function getCountryById($id,$lang){
		return $country=singleResult('site_country', " id='".$id."'", 'country_name_'.$lang);
	}
	
	function getCountry($country_en,$lang){
		return $country=singleResult('site_country', " country_name_english='".addslashes($country_en)."'", 'country_name_'.$lang);
	}
	
	function getCountryId($country)
	{
		return $country_id=singleResult('site_country'," country_name_english='".addslashes($country)."'","id");
	}	
	
	/*
	* GET REGION
	*/
	
	function getRegion($region_en,$lang){
		return $region=singleResult('site_region', " region_name_english='".addslashes($region_en)."'", 'region_name_'.$lang);
	}	
	
	function getRegionById($id,$lang)
	{
		return $name_region=singleResult('site_region'," id='".$id."'","region_name_".$lang);
	}
	
	function getRegionId($region)
	{
		return $name_region=singleResult('site_region'," site_region.region_name_english='".addslashes($region)."'","id");
	}
	
	/*
	* GET PROVINCE
	*/
	
	function getProvince($province,$lang){
		return $getPro=singleResult('site_state'," state_name_english='".addslashes($province)."'",'state_name_'.$lang);
	}
	
	function getProvinceId($province)
	{
		return $pro_id=singleResult('site_state'," state_name_english='".addslashes($province)."'","id");
	}
	
	function getProvinceById($province_id,$lang){
		return $getPro=singleResult('site_state'," id ='".$province_id."'",'state_name_'.$lang);
	}
	
	function getProvinceByName($province,$lang){
		return $getPro=singleResult('site_state'," state_name_english='".addslashes($province)."'",'state_name_'.$lang);
	}
	
	/*
	* GET DESTINATION
	*/
	
	function getDestination($destination,$lang)
	{
		return singleResult('site_city'," city_name_english='".addslashes($destination)."'",'city_name_'.$lang);
	}

	function getDestinationId($destination)
	{
		return singleResult('site_city'," city_name_english"."='".addslashes($destination)."'","id");
	}
	
	function getDestinationById($id,$lang)
	{
		return singleResult('site_city'," id"."='".$id."'",'city_name_'.$lang);
	}

	function getDestinationByName($destination,$lang)
	{
		return $city_id=singleResult('site_city'," city_name_english='".addslashes($destination)."'",'city_name_'.$lang);
	}	
	

   /////////////////////////////////////// END HOUSE OF THE WEEK MANAGEMENT//////////////////////////////
   
   // Update text of multilingual below map page
   function updateMultiLing($text){
      return mysql_query("UPDATE site_setting SET multilingual='".$text."'");
   }
   
   function displayMultiLing(){
     $details=singleResult('site_setting'," 1=1", "multilingual");
	 return $details;
   }
   

   // Show rating according to property id
   function fnReviewRating($id)
   {
        /*$sql = mysql_query("SELECT COUNT(R.id) as cn, SUM(R.rating_num) AS rating FROM alqui_reviews_rating R INNER JOIN alqui_property_review P ON (P.id = R.review_id) WHERE P.property_id='$id'");
        $getresult = mysql_fetch_array($sql, MYSQL_ASSOC);
        try
        {
                if($getresult['cn'] < 1)
                        throw new Exception('<img src="lib.src/images/0star.gif" alt="" width="70" height="15" />');
                else
                {
                        $finalrating = ceil(($getresult['rating'])/($getresult['cn']));
                        return $finalrating;
                }
        }
        catch(Exception $e)
        {
                echo $e->getMessage();
        }*/
        //$my_query="SELECT COUNT(R.id) as cn, SUM(R.rating_num) AS rating FROM reviews_rating R INNER JOIN property_review P ON (P.id = R.review_id) WHERE P.property_id='$id' AND P.active=1";
        $my_query="SELECT COUNT(id) as cn, SUM(rating_num) AS rating FROM reviews_rating WHERE property_id='".$id."'";
        //echo $my_query="select sum(r.rating_num) AS rating from garagu_reviews_rating r,garagu_property_review p where P.id = R.review_id AND P.property_id='$id'";
	//die;
   	  	$sql = mysql_query($my_query);

        $getresult = mysql_fetch_array($sql, MYSQL_ASSOC);
        try
        {
                if($getresult['cn'] < 1)
                        throw new Exception('<img src="lib.src/images/0star.gif" alt="" width="70" height="15" />');
                else
                {
                        $finalrating = round(($getresult['rating'])/($getresult['cn']));
                        return $finalrating;
                }
        }
        catch(Exception $e)
        {
                echo $e->getMessage();
        }
		
   }
   
	function getCurrency($currency_id)
   {
        return $currency=singleResult("site_currency"," currency_id='".$currency_id."'","currency");
   }
   
   	function getTextArticle($lang)
   {
        return $t=singleResult("article_text"," id=1 ","text_".$lang."");
   }

   function updateSite_state($id,$ar){
      $s="UPDATE site_state SET region_id ='".$id."' WHERE";
      foreach($ar['state_id'] as $k){
      	$s.=" id='".$k."' OR";
      }
      $s=preg_replace('#OR$#','',$s);
      return mysql_query($s);
   }

   function updateProp_info($id,$ar){
      $s="UPDATE property_information SET region_id='".$id."' WHERE";
      foreach($ar['state_id'] as $k){
      	$s.=" state_id='".$k."' OR";
      }
      $s=preg_replace('#OR$#','',$s);
      return mysql_query($s);
   }
}
?>
