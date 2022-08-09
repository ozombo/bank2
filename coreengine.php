<?php
include_once('fix_mysql.inc.php');
session_start();
if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');
/*************** OURPRAYERBOX CORE ENGINE *********************


***********************************************************/



$appname = "NATIONAL BANK OF ARIZONA";



$dbname = 'nbaonlin_online';

$link = mysql_connect("localhost","root","root") or die("Couldn't make connection.");
$db = mysql_select_db($dbname, $link) or die("Couldn't select database");

/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/
function page_protect() {

//check for cookies

if(isset($_COOKIE['cookname'])){
      $_SESSION['user_id'] = $_COOKIE['cookname'];
     
   }


if (!isset($_SESSION['user_id']))
{
header("Location: index.php");
}
/*******************END********************************/
}

//Checkpage and send user to home.php if loggedin
function change_page() {


if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['user_id'] = $_COOKIE['cookname'];
      $_SESSION['password'] = $_COOKIE['cookpass'];
   }


if (isset($_SESSION['user_id']))
{
header("Location: dashboard.php");
}
/*******************END********************************/
} 

//Confirm if userlogged in so as to define session
function examine_page() {


if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['user_id'] = $_COOKIE['cookname'];
      $_SESSION['password'] = $_COOKIE['cookpass'];
   }


/*******************END********************************/
}           
                
//During image upload, capture file extension and validate file type with it
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

//Get people a user is following
function show_users($user_id=0){

	if ($user_id > 0){
		$follow = array();
		$fsql = "select user_id from following
				where follower_id='$user_id'";
		$fresult = mysql_query($fsql);

		while($f = mysql_fetch_object($fresult)){
			array_push($follow, $f->user_id);
		}

		if (count($follow)){
			$id_string = implode(',', $follow);
			$extra =  " and id in ($id_string)";

		}else{
			return array();
		}

	}

	$users = array();
	$sql = "select id, username from userz where id !='' $extra order by username";


	$result = mysql_query($sql);

	while ($data = mysql_fetch_object($result)){
		$users[$data->id] = $data->username;
	}
	return $users;
}

//show posts from user and their followers
function show_posts($userid,$limit=0){
	$posts = array();

	$user_string = implode(',', $userid);
	$extra =  " and id in ($user_string)";

	if ($limit > 0){
		$extra = "limit $limit";
	}else{
		$extra = '';	
	}

	$sql = "select id,uid,body,date,amenz,device from prayer where uid in ($user_string) and source = '' order by date desc $extra";
	
	$result = mysql_query($sql);

	while($data = mysql_fetch_object($result)){
		$posts[] = array( 	'stamp' => $data->date, 


							'userid' => $data->uid, 
'amen' => $data->amenz, 
'device' => $data->device, 
'id' => $data->id,
							'body' => $data->body
					);
	}
	return $posts;

}




function makecomma($input)
{
    // This function is written by some anonymous person - I got it from Google
    if(strlen($input)<=2)
    { return $input; }
    $length=substr($input,0,strlen($input)-2);
    $formatted_input = makecomma($length).",".substr($input,-2);
    return $formatted_input;
}




function relativeTime($dt,$precision=2)
{
	$times=array(	365*24*60*60	=> "yr",
					30*24*60*60		=> "mth",
					7*24*60*60		=> "wk",
					24*60*60		=> "day",
					60*60			=> "hr",
					60				=> "min",
					1				=> "sec");
	
	$passed=time()-$dt;
	
	if($passed<5)
	{
		$output='5 secs ago';
	}
	else
	{
		$output=array();
		$exit=0;
		
		foreach($times as $period=>$name)
		{
			if($exit>=$precision || ($exit>0 && $period<60)) break;
			
			$result = floor($passed/$period);
			if($result>0)
			{
				$output[]=$result.' '.$name.($result==1?'':'s');
				$passed-=$result*$period;
				$exit++;
			}
			else if($exit>0) $exit++;
		}
				
		$output=implode(' & ',$output).' ago';
	}
	
	return $output;
}

function EncodeURL($url)
{
$new = strtolower(ereg_replace(' ','_',$url));
return($new);
}

function DecodeURL($url)
{
$new = ucwords(ereg_replace('_',' ',$url));
return($new);
}

function ChopStr($str, $len) 
{
    if (strlen($str) < $len)
        return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
            $str = substr($str,0,$spc_pos);

    return $str . "...";
}

function convertBodyCodes($body) {
		
		/*
			The following is the replacement array, note
			that the spaces before and after HTML versions
			is used to prevent building up long strings that
			can't be cut by the chopper function bewlow as
			it was built not to cut in the middle of a string
			that stands inside a html tag - this prevents
			cutting a long link in two parts thus making it
			unusable
		*/
		$BCRegExpArrayPattern = array(
			'/#([a-zA-Z0-9]+)/',
			'/@([\\d\\w]+)/',
			'/(&#33;|!){10,}/',
		 '/\\b((https?|ftp):\/\/([-A-Z0-9.]+)(\/[-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\\?[-A-Z0-9+&@#\/%=~_|!:,.;]*)?)/si',

		);
		
		$BCRegExpArrayReplace = array(
			'<a href="/topic/$1" class = "mention" style = "color:#5dcff3;">$0</a>',

			'<a href="/$1" class = "mention" style = "color:#5dcff3;">$0</a>',
			'!',
			'<a href="\\1" target="_blank">\\1</a>',
		);



		$body = preg_replace($BCRegExpArrayPattern, $BCRegExpArrayReplace, $body);

		foreach(explode(" ", strip_tags($body)) as $key => $line) {
			/*
				Break long strings into smaller chunks (prevents
				destroying the interface with a 500 characters
				long "word"
			*/
			if (strlen($line) > 50) $body = str_replace($line, wordwrap($line, 25, " ", 1), $body);
			
		}
		
		/* 
			Return the body to the caller
		*/
		return $body;
	}

//no unGodly words here please!
function wordfilter($data){
    $originals = array("pussy","fuck","ass","dick","oloshi","ass","twart","pennis","vagina","boobs","straff","milf","porno","porn","twerk","bitch");
    $replacements = "***";
    $data = str_ireplace($originals,$replacements,$data);
    return $data;
}	
?>