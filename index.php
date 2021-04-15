<?php
/** Activate this only if you need to hide errors */
//error_reporting(0);
/** END OF Activate this only */

session_start();

?>
<?php 
include('Connections/onlinenotebookmanager.php'); 

/*** Check if the database is installed or not ***/
if($IsConnectionValid===false) { 
	$url = "databases/mysql_install.php?msg=database_not_installed";
	echo "<meta http-equiv='refresh' content='0;url=" . $url . "' />";	
}
/*** END OF Check if the database is installed or not ***/
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if($_GET['ProjectID']!="") {
	$_SESSION['ProjectID'] = $_GET['ProjectID'];
}



/* --------------------------- */
/* rsConfiguration */

$vProjectID_rsConfiguration = "%";
if (isset($_SESSION["ProjectID"])) {
  $vProjectID_rsConfiguration = (get_magic_quotes_gpc()) ? $_SESSION["ProjectID"] : addslashes($_SESSION["ProjectID"]);
}
mysql_select_db($database_onlinenotebookmanager, $onlinenotebookmanager);
$query_rsConfiguration = sprintf("SELECT * FROM tblConfiguration", GetSQLValueString($vProjectID_rsConfiguration, "text"));
$rsConfiguration = mysql_query($query_rsConfiguration, $onlinenotebookmanager) or die(mysql_error());
$row_rsConfiguration = mysql_fetch_assoc($rsConfiguration);
$totalRows_rsConfiguration = mysql_num_rows($rsConfiguration);



if ($totalRows_rsConfiguration > 0) {
	$General_AppItem = $row_rsConfiguration['General_AppName'];
	$General_AppLogo = $row_rsConfiguration['General_AppLogo'];
	$General_FavIcon = $row_rsConfiguration['General_FavIcon'];
	$Security_PublicAccessFlag = $row_rsConfiguration['Security_PublicAccessFlag'];
	$Display_ShowListMenu_Projects = $row_rsConfiguration['Display_ShowListMenu_Projects'];
	$Security_AdminLoginLinkFlag = $row_rsConfiguration['Security_AdminLoginLinkFlag'];
	$General_AppFooter = $row_rsConfiguration['General_AppFooter'];
	$Display_ShowButton_PostComment = $row_rsConfiguration['Display_ShowButton_PostComment'];
	$Display_ShowButton_ViewComment = $row_rsConfiguration['Display_ShowButton_ViewComment'];
	$General_LicenseKey = $row_rsConfiguration['General_LicenseKey'];
	$General_RegisteredDomain = $row_rsConfiguration['General_RegisteredDomain'];
	
	$_SESSION['General_CSSSkin'] = $row_rsConfiguration['General_CSSSkin'];
	$_SESSION['ApproveComments'] = $row_rsConfiguration['Extra_ConfigText1'];
	$_SESSION['Email_ServerComponent'] = $row_rsConfiguration['Email_ServerComponent'];
	$_SESSION['Email_SMTPAddress'] = $row_rsConfiguration['Email_SMTPAddress'];
}

/* END OF rsConfiguration */



/*** Check for Licensekey ***/
if(($General_LicenseKey!="") and ($General_RegisteredDomain!= "")) {
	$ValidLicense = "True";
}
else {
	$ValidLicense ="True";
}

/*** END OF Check for Licensekey ***/



/* --------------------------- */
/* rsItems */

$value1_rsItems = "%";
if (isset($_GET["ItemID"])) {
  $value1_rsItems = (get_magic_quotes_gpc()) ? $_GET["ItemID"] : addslashes($_GET["ItemID"]);
}
$value2_rsItems = "%";
if (isset($_POST["search"])) {
  $value2_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value3_rsItems = "%";
if (isset($_POST["search"])) {
  $value3_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value4_rsItems = "%";
if (isset($_POST["search"])) {
  $value4_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value5_rsItems = "%";
if (isset($_POST["search"])) {
  $value5_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value6_rsItems = "%";
if (isset($_SESSION["search"])) {
  $value6_rsItems = (get_magic_quotes_gpc()) ? $_SESSION["search"] : addslashes($_SESSION["search"]);
}

$value1_rsItems = "%";
if (isset($_GET["ItemID"])) {
  $value1_rsItems = (get_magic_quotes_gpc()) ? $_GET["ItemID"] : addslashes($_GET["ItemID"]);
}
$value2_rsItems = "%";
if (isset($_POST["search"])) {
  $value2_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value3_rsItems = "%";
if (isset($_POST["search"])) {
  $value3_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value4_rsItems = "%";
if (isset($_POST["search"])) {
  $value4_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value5_rsItems = "%";
if (isset($_POST["search"])) {
  $value5_rsItems = (get_magic_quotes_gpc()) ? $_POST["search"] : addslashes($_POST["search"]);
}
$value6_rsItems = "%";
if (isset($_SESSION["ProjectID"])) {
  $value6_rsItems = (get_magic_quotes_gpc()) ? $_SESSION["ProjectID"] : addslashes($_SESSION["ProjectID"]);
}
mysql_select_db($database_onlinenotebookmanager, $onlinenotebookmanager);
$query_rsItems = sprintf("SELECT tblConfiguration.*, tblCategory.*, tblItems.*, tblProjects.*, tblEntity.FirstName, tblEntity.LastName, tblEntity.EmailAddress FROM (((tblConfiguration LEFT JOIN tblProjects ON tblConfiguration.ConfigID = tblProjects.ConfigIDkey) LEFT JOIN tblItems ON tblProjects.ProjectID = tblItems.ProjectIDkey) LEFT JOIN tblCategory ON tblItems.CategoryIDkey = tblCategory.CategoryID) LEFT JOIN tblEntity ON tblItems.EntityIDkey = tblEntity.EntityID WHERE tblItems.Activated = 'True' AND tblProjects.ProjectActivated = 'True' AND tblCategory.CategoryActivated='True' AND tblItems.ItemID LIKE CONCAT('%%', %s, '%%') AND (tblCategory.CategoryName Like CONCAT('%%', %s, '%%') OR tblItems.ItemName Like CONCAT('%%', %s, '%%') OR tblItems.ItemMemo Like CONCAT('%%', %s, '%%') OR tblItems.ItemDesc Like CONCAT('%%', %s, '%%')) AND tblItems.ProjectIDkey LIKE CONCAT('%%', %s, '%%') ORDER BY tblProjects.ProjectSortOrder, tblCategory.CategorySortOrder, tblItems.SortOrder", GetSQLValueString($value1_rsItems, "text"),GetSQLValueString($value2_rsItems, "text"),GetSQLValueString($value3_rsItems, "text"),GetSQLValueString($value4_rsItems, "text"),GetSQLValueString($value5_rsItems, "text"),GetSQLValueString($value6_rsItems, "text"));
$rsItems = mysql_query($query_rsItems, $onlinenotebookmanager) or die(mysql_error());
$row_rsItems = mysql_fetch_assoc($rsItems);
$totalRows_rsItems = mysql_num_rows($rsItems);



if ($totalRows_rsItems > 0) {
	$ItemID = $row_rsItems['ItemID'];
	
	if($row_rsItems['ItemMetaTitle']!="") {
		$ItemMetaTitle = $row_rsItems['ItemMetaTitle'];
	}
	else {
		$ItemMetaTitle = $row_rsItems['ProjectName'] . " | " . $row_rsItems['CategoryName'] . " | " . $row_rsItems['ItemName'];
	}
	
	$ItemMetaKeywords = $row_rsItems['ItemMetaKeywords'];
	$ItemMetaDescription = $row_rsItems['ItemMetaDescription'];
	
	$ProjectName = $row_rsItems['ProjectName'];
	
	$_SESSION['EmailAddress'] = $row_rsItems['EmailAddress'];
	$_SESSION['ItemName'] = $row_rsItems['ItemName'];
	$_SESSION['FirstName'] = $row_rsItems['FirstName'];
	$_SESSION['LastName'] = $row_rsItems['LastName'];
	$_SESSION['ItemID'] = $row_rsItems['ItemID'];
	
	if(!isset($_SESSION['ProjectID'])){
		$_SESSION['ProjectID'] = $row_rsItems['ProjectID'];
	}
}


/* END OF rsItems */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title><?=$ItemMetaTitle?></title>
<meta http-equiv="PRAGMA" content="NO-CACHE" />
<meta name="Description" content="<?=$ItemMetaDescription?>"/>
<meta name="Keywords" content="<?=$ItemMetaKeywords?>"/>

<meta name="copyright" content="<?= $_SERVER['HTTP_HOST']?>"/>
<meta name="author" content="<?= $_SERVER['HTTP_HOST']?>"/>
<meta name="revisit-after" content="2 Weeks"/>
<meta name="Robot" content="ALL"/>
<meta name="rating" content="General"/>
<link href="onlinenotebookmanager/skins/<?=$_SESSION['General_CSSSkin']?>/css/main.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 6]><style type="text/css" media="all">@import "/skins/<?=$_SESSION['General_CSSSkin'] ?>/css/ie6.css";</style><![endif]-->
<script src="/onlinenotebookmanager/tools/javascript/inc_javascript.js" type="text/javascript"></script>
<script type="text/javascript" src="/onlinenotebookmanager/tools/javascript/switchcontent.js" ></script>
<script type="text/javascript" src="/onlinenotebookmanager/tools/javascript/switchicon.js"></script>
<script type="text/javascript" src="/onlinenotebookmanager/tools/ajax/tabber/tabber.js"></script>
<?php include("onlinenotebookmanager/tools/ajax/GreyBox_v5_53.html"); ?>
<?php
function getGeneral_FavIcon($str) {return substr($str, 1);}
$icon = getGeneral_FavIcon($General_FavIcon);	
?>
<link rel="shortcut icon" href="<?= $General_FavIcon ?>" type="image/vnd.microsoft.icon"/> 
<link rel="icon" href="<?= $General_FavIcon ?>" type="image/ico" />
</head>
<body>
<?php
	if(($Security_PublicAccessFlag == "False") and ($_SESSION['MM_UserAuthorizationEntity'] != "1")) {
		echo "<meta http-equiv='refresh' content='0;url=onlinenotebookmanager/security/login/login.php' />";
	}
	else { 
?>
<div id="top">&nbsp;</div> 
<div id="wrapper">
	<div id="container">
		<div id="sidebar">
			<div id="toc">
				<h3>Table of Contents</h3>
				<div id="toc_middle_bottom">
					<div id="toc_middle">
						<div class="inner">
						  <?php include("onlinenotebookmanager/items/navigation/inc_navigation.php"); ?>
						</div>
					</div>
				</div>
				<div id="toc_bottom"></div>            	
			</div>
		</div>
		<div id="content">
			<div class="header">
				<div class="header_right">
					<div class="header_left">
						<?php include("onlinenotebookmanager/settings/inc_header.php"); ?>
					</div>
				</div>
			</div>
			
			<div id="maincontent">
			  <div id="maincontent_top">
				<?php include("onlinenotebookmanager/items/search/inc_search.php");  ?>
				<?php if($Display_ShowListMenu_Projects=="True") {
						include("onlinenotebookmanager/projects/inc_list_menu.php");
					} 
				?>
			  </div>
			  
			  <div id="mainbox">
				<div id="mainbox_top">
					<div id="mainbox_topleft">
						<div id="mainbox_topright" class="userinterface">
							<?php include("onlinenotebookmanager/items/breadcrumbs/inc_breadcrumbs.php"); ?>
						</div>
					</div> 
				</div>
				
				<div id="mainbox_mainbox_bottom_center">
					<div id="mainbox_mainbox_bottom_right">
						<div id="mainbox_mainbox_bottom_left">
							<div id="mainbox_middleleft">
								<div id="mainbox_middleright">
										<div class="inner">
											<div id="content_rightnav">
												<?php
													if(($Security_AdminLoginLinkFlag=="True") or ($_SESSION['MM_UserAuthorizationEntity']=="1") or ($_GET["show"]=="login")) {
												?>
												<div class="useroption yellow">
													<div class="useroption_inner">
														<div class="eg-bar">
															<span id="useroption1-title" class="iconspan"></span>
														</div>
														
														<div id="useroption1" class="icongroup1">
															<?php include("onlinenotebookmanager/security/login/inc_login_container.php"); ?>
														</div>
													</div>
													
													<div id="useroption_bottom_yellow"></div>
												</div>
												<?php } ?>
									
												<?php
													if($_SESSION['MM_UserAuthorizationEntity']=="1") {
												?>
												
												<div class="useroption green">
													<div class="useroption_inner">
														<div class="eg-bar"> <span id="useroption4-title" class="iconspan"></span> </div>
														<div id="useroption4" class="icongroup4">
															<?php include("onlinenotebookmanager/items/management/inc_edit_options.php"); ?>
														</div>
													</div>
													
													<div id="useroption_bottom_green"></div>
												</div>
												<?php } ?>
									
												<div class="useroption blue">
													<div class="useroption_inner">
														<div class="eg-bar">
															<span id="useroption5-title" class="iconspan"></span>
														</div>
														<div id="useroption5" class="icongroup5">
															<?php include("onlinenotebookmanager/items/page_tools/inc_page_tools_options.php"); ?>
														</div>
													</div>
													<div id="useroption_bottom_blue"></div>
												</div>
											</div>
						
											<div id="content_left">
												<?php if($ValidLicense=="False") {
															include("onlinenotebookmanager/installation/inc_license_registration.php");
													   }
													   else {
															include("onlinenotebookmanager/items/inc_item.php");
															include("onlinenotebookmanager/settings/inc_settings_pages.php");
													   }
												?>
												<div id="btn_goback">
													<a href="javascript:history.go(-1);">
														<img src="/onlinenotebookmanager/skins/<?= $_SESSION['General_CSSSkin'] ?>/images/btn_goback.gif" alt="go back " />
													</a>
												</div>
								
												<div id="btn_top">
													<a href="#top">
														<img src="/onlinenotebookmanager/skins/<?= $_SESSION['General_CSSSkin'] ?>/images/btn_top.gif" alt="Top" />
													</a>
												</div>
										  
												<div class="clear"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="mainbox_bottom">
						<div id="mainbox_bottomleft">
							<div id="mainbox_bottomright"></div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="footer">
			<div class="inner">
				<div class="container_center">
				  <div class="container_left">
					  <?php include("onlinenotebookmanager/settings/inc_footer.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($rsItems);
mysql_free_result($rsConfiguration);
//$rsItems = NULL;
//$rsConfiguration = NULL;
?>

