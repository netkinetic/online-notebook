<?php
session_start();

if($_POST['action']=="install_mysql") {
	$server = $_POST['dbServer'];
	$name = $_POST['dbName'];
	$username = $_POST['dbUserName'];
	$password = $_POST['dbPassword'];
	
	if($server=="" || $name=="" || $username=="") { //password can be empty (e.g. root in localhost)
		$msg = "Database information is not complete! Please fill all fields with the database information.";
		$flag = false;
	}
	else {
		$flag = true;
	}
	
	if($flag) {
		
		$_SESSION['server'] = $server;
		$_SESSION['name'] = $name;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['install'] = "yes";

	}
}

if($_GET['msg']=="database_not_installed") $msg="Your database is not installed. Please insert your database information to the fields in this page, and click START INSTALLATION.";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database Installation Wizard</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style></head>

<body>
<?php
/*** front page ***/
if(!$flag  && $_GET['done']!="yes") {
?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td valign="top">
<h1 align="right"><a href="http://www.dmxready.com/"><img src="http://www.dmxready.com/assets/images/temp_logo.gif" alt="dmxready.com" width="230" height="74" border="0" align="left" /></a></h1>
<div align="right"><strong>Welcome to <em><strong>Online Notebook Manager v1.0 (PHP)</strong></em><br />
  One of   the powerful website applications from DMXReady</strong></div>
<h3 align="left"><br />
  Online Notebook Manager v1.0 MySQL Database Installation Wizard </h3>
<p>Welcome to the installation wizard for Online Notebook Manager MySQL Database. This wizard will install the MySQL database that is needed to run the application.</p>
<h3>Step 1</h3> 
  <p>In order to properly install the database, please obtain the following information from your web hosting:<br />
    ** You can go to Step 2 if you have this information.
</p>
  <ol>
  <li>Database Server Name</li>
  <li>Database Name</li>
  <li>Database UserName</li>
  <li>Database Password</li>
  </ol>
<h3>Step 2 </h3>
<p>Insert the information you just obtained from your web hosting in the form below:<br />
  **
  Please note that <strong>all fields are required</strong>.</p>
<form id="form1" name="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
<fieldset><legend><strong>Database Information</strong><br />
</legend>
<?php if(isset($msg) and ($msg!="")) { ?>
<span style="color:red"><?= $msg ?></span>
<?php } ?>
  <table>
		<tr>
			<td>Database Server</td>
			<td><input name="dbServer" type="text" size="40" /></td>
		</tr>
		<tr>
			<td>Database Name</td>
			<td><input name="dbName" type="text" size="40" /></td>
		</tr>
		<tr>
			<td>Database UserName</td>
			<td><input name="dbUserName" type="text" size="40" /></td>
		</tr>
		<tr>
			<td>Database Password</td>
			<td><input name="dbPassword" type="text" size="40" /></td>
		</tr>
  </table>
    </p>
</fieldset>
<h3>Step 3 </h3>
<p>Click <em>START INSTALLATION</em> button bellow. Click Cancel to cancel the process </p>
<p><br />
      <input type="submit" name="Submit" value="START INSTALLATION" />
      <input type="button" name="Cancel" value="Cancel" onclick="window.location='/readme.html'" />
      <input type="hidden" name="action" value="install_mysql" />
</p>
</form> 
<p>&nbsp;</p>
<p>If you have any problems installing the database or using this wizard, please contact <a href="http://dmxready.helpserve.com/index.php?_m=tickets&amp;_a=submit">Tech Support</a>:<br />
</p>
<hr size="1" noshade="noshade" />
<p><a href="http://www.dmxready.com/dmxready.asp?mid=26&amp;mid2=15">Contact us</a> if you have any questions regarding this application or any other DMXReady apps.</p>
<p>Be sure to checkout our Online Support Desk (<a href="http://www.dmxready.com/support">www.dmxready.com/support</a>) filled with FAQ's, articles, tutorials, latest news and more.</p></td>
  </tr>
</table>
<?php } ?>

<?php
/*** working page ***/
/*** where the script for installation runs ***/
if($flag) {
	$hostname = $_SESSION['server']; 
	$database = $_SESSION['name']; 
	$username = $_SESSION['username']; 
	$password = $_SESSION['password']; 
	
	unset($_SESSION['server']);
	unset($_SESSION['name']);
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	 
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td valign="top">
		<h1 align="right"><a href="http://www.dmxready.com/"><img src="http://www.dmxready.com/assets/images/temp_logo.gif" alt="dmxready.com" width="230" height="74" border="0" align="left" /></a></h1>
<div align="right"><strong>Welcome to <em><strong>Online Notebook Manager v1.0</strong></em><br />
  One of   the powerful website applications from DMXReady</strong></div>
		<?php
		$onlinenotebookmanager = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
		echo "<br />";
		?>
		<img src="loading.gif" /><br />
		<h3>Please wait. The script is installing the Online Notebook Manager MySQL database...</h3>
	</td>
  </tr>
</table>
<?php

	/*** Install the database ***/
	
	mysql_select_db($database, $onlinenotebookmanager);
	
	/*** tblCategory ***/
	$sql = "DROP TABLE IF EXISTS `tblCategory`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblCategory` (
  `CategoryID` INTEGER NOT NULL AUTO_INCREMENT, 
  `CategoryName` VARCHAR(255), 
  `ParentCategoryID` INTEGER DEFAULT 0, 
  `CategoryDesc` TEXT, 
  `CategoryLabel` VARCHAR(255), 
  `CategoryImageFile` VARCHAR(255), 
  `ProjectIDkey` INTEGER DEFAULT 1, 
  `CategoryActivated` VARCHAR(50) DEFAULT 'True', 
  `CategorySortOrder` INTEGER NOT NULL DEFAULT 1, 
  INDEX (`CategoryID`), 
  INDEX (`ProjectIDkey`), 
  PRIMARY KEY (`CategoryID`)
) TYPE=InnoDB";


	mysql_query($sql);
	
	$sql = "INSERT INTO `tblCategory` (`CategoryID`, `CategoryName`, `ParentCategoryID`, `CategoryDesc`, `CategoryLabel`, `CategoryImageFile`, `ProjectIDkey`, `CategoryActivated`, `CategorySortOrder`) VALUES (27, 'Overview', 0, NULL, NULL, NULL, 5, 'True', 1)";
	
	mysql_query($sql);
	
	/*** END OF tblCategory ***/
	
	
	/*** tblConfiguration ***/
	$sql = "DROP TABLE IF EXISTS `tblConfiguration`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblConfiguration` (
  `ConfigID` INTEGER NOT NULL AUTO_INCREMENT, 
  `General_AppItemID` DOUBLE NULL DEFAULT 0, 
  `General_AppName` VARCHAR(255) DEFAULT 'na', 
  `General_AppItem` VARCHAR(255) DEFAULT 'na', 
  `General_AppTitle` VARCHAR(255) DEFAULT 'na', 
  `General_AppFolder` VARCHAR(255) DEFAULT 'na', 
  `General_AppVersion` VARCHAR(255) DEFAULT 'na', 
  `General_FavIcon` VARCHAR(255), 
  `General_AppLogo` VARCHAR(255), 
  `General_CSSSkin` VARCHAR(255) DEFAULT 'default', 
  `General_AppWelcomePage` TEXT, 
  `General_AppWelcomePageFlag` VARCHAR(255) DEFAULT 'na', 
  `General_AppFooter` TEXT, 
  `General_OwnerFirstName` VARCHAR(255) DEFAULT 'na', 
  `General_OwnerLastName` VARCHAR(255) DEFAULT 'na', 
  `General_LicenseKey` VARCHAR(50), 
  `General_InstallDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(), 
  `General_RegisteredDomain` VARCHAR(255) DEFAULT 'na', 
  `General_MetaTitle` TEXT, 
  `General_MetaKeywords` TEXT, 
  `General_MetaDescription` TEXT, 
  `Security_SecurityLevel` DOUBLE NULL DEFAULT 0, 
  `Security_AdminSecurity` VARCHAR(255), 
  `Security_AdminUserName` VARCHAR(255), 
  `Security_AdminPassword` VARCHAR(255), 
  `Security_AdminEmailAddress` VARCHAR(255), 
  `Security_AdminLoginLinkFlag` VARCHAR(255) DEFAULT 'True', 
  `Security_PublicAccessFlag` VARCHAR(255) DEFAULT 'True', 
  `Display_SearchCategory` VARCHAR(255) DEFAULT 'False', 
  `Display_SearchCategoryLabel` VARCHAR(255) DEFAULT 'False', 
  `Display_SearchKeyword` VARCHAR(255) DEFAULT 'False', 
  `Display_SearchKeywordLabel` VARCHAR(255) DEFAULT 'False', 
  `Display_SearchDate` VARCHAR(255) DEFAULT 'False', 
  `Display_SearchDateLabel` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowDefaultItemID` DOUBLE NULL DEFAULT 1, 
  `Display_ShowRecords` DOUBLE NULL DEFAULT 100, 
  `Display_ShowButton_Edit` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowButton_SendToFriend` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowButton_PrinterFriendly` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowButton_Contact` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowButton_PostComment` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowListMenu_Projects` VARCHAR(255) DEFAULT 'True', 
  `Display_ShowButton_ViewComment` VARCHAR(255) DEFAULT 'False', 
  `Display_ShowAll` VARCHAR(255) DEFAULT 'False', 
  `Display_SlideShowTransitionTime` DOUBLE NULL DEFAULT 100, 
  `Rules_DaysExpiration` DOUBLE NULL DEFAULT 0, 
  `Rules_DaysNew` DOUBLE NULL DEFAULT 0, 
  `Rules_DefaultSecurityLevelID` DOUBLE NULL DEFAULT 0, 
  `Rules_DefaultActivationStatus` VARCHAR(50), 
  `Rules_DefaultEntityStatus` VARCHAR(50), 
  `Rules_DefaultEntitySource` VARCHAR(50), 
  `Rules_DefaultCategoryID` DOUBLE NULL DEFAULT 0, 
  `Email_SMTPUsername` VARCHAR(255), 
  `Email_SMTPPassword` VARCHAR(255), 
  `Email_ServerComponent` VARCHAR(255) DEFAULT 'NORMAL', 
  `Email_SMTPAddress` VARCHAR(255), 
  `Extra_ConfigText1` VARCHAR(255), 
  `Extra_ConfigText2` VARCHAR(255), 
  `Extra_ConfigText3` VARCHAR(255), 
  `Extra_ConfigText4` VARCHAR(255), 
  `Extra_ConfigText5` VARCHAR(255), 
  `CSS_Color1` VARCHAR(255), 
  `CSS_Color2` VARCHAR(255), 
  `CSS_Color3` VARCHAR(255), 
  `CSS_Color4` VARCHAR(255), 
  `CSS_Color5` VARCHAR(255), 
  `CSS_Color6` VARCHAR(255), 
  `CSS_Color7` VARCHAR(255), 
  `CSS_Color8` VARCHAR(255), 
  `CSS_Color9` VARCHAR(255), 
  `CSS_Color10` VARCHAR(255), 
  `CSS_Image1` VARCHAR(255), 
  `CSS_Image2` VARCHAR(255), 
  `CSS_Image3` VARCHAR(255), 
  `CSS_Image4` VARCHAR(255), 
  `CSS_Image5` VARCHAR(255), 
  `CSS_Image6` VARCHAR(255), 
  `CSS_Image7` VARCHAR(255), 
  `CSS_Image8` VARCHAR(255), 
  `CSS_Image9` VARCHAR(255), 
  `CSS_Image10` VARCHAR(255), 
  `Messaging_EmailSubject1` VARCHAR(255), 
  `Messaging_EmailBody1` TEXT, 
  `Messaging_EmailSubject2` VARCHAR(255), 
  `Messaging_EmailBody2` TEXT, 
  `Messaging_EmailSubject3` VARCHAR(255), 
  `Messaging_EmailBody3` TEXT, 
  `Messaging_EmailSubject4` VARCHAR(255), 
  `Messaging_EmailBody4` TEXT, 
  `Messaging_EmailSubject5` VARCHAR(255), 
  `Messaging_EmailBody5` TEXT, 
  INDEX (`General_LicenseKey`), 
  PRIMARY KEY (`ConfigID`)
) TYPE=InnoDB";

	mysql_query($sql);
	
	$sql = "INSERT INTO `tblConfiguration` (`ConfigID`, `General_AppItemID`, `General_AppName`, `General_AppItem`, `General_AppTitle`, `General_AppFolder`, `General_AppVersion`, `General_FavIcon`, `General_AppLogo`, `General_CSSSkin`, `General_AppWelcomePage`, `General_AppWelcomePageFlag`, `General_AppFooter`, `General_OwnerFirstName`, `General_OwnerLastName`, `General_LicenseKey`, `General_InstallDate`, `General_RegisteredDomain`, `General_MetaTitle`, `General_MetaKeywords`, `General_MetaDescription`, `Security_SecurityLevel`, `Security_AdminSecurity`, `Security_AdminUserName`, `Security_AdminPassword`, `Security_AdminEmailAddress`, `Security_AdminLoginLinkFlag`, `Security_PublicAccessFlag`, `Display_SearchCategory`, `Display_SearchCategoryLabel`, `Display_SearchKeyword`, `Display_SearchKeywordLabel`, `Display_SearchDate`, `Display_SearchDateLabel`, `Display_ShowDefaultItemID`, `Display_ShowRecords`, `Display_ShowButton_Edit`, `Display_ShowButton_SendToFriend`, `Display_ShowButton_PrinterFriendly`, `Display_ShowButton_Contact`, `Display_ShowButton_PostComment`, `Display_ShowListMenu_Projects`, `Display_ShowButton_ViewComment`, `Display_ShowAll`, `Display_SlideShowTransitionTime`, `Rules_DaysExpiration`, `Rules_DaysNew`, `Rules_DefaultSecurityLevelID`, `Rules_DefaultActivationStatus`, `Rules_DefaultEntityStatus`, `Rules_DefaultEntitySource`, `Rules_DefaultCategoryID`, `Email_SMTPUsername`, `Email_SMTPPassword`, `Email_ServerComponent`, `Email_SMTPAddress`, `Extra_ConfigText1`, `Extra_ConfigText2`, `Extra_ConfigText3`, `Extra_ConfigText4`, `Extra_ConfigText5`, `CSS_Color1`, `CSS_Color2`, `CSS_Color3`, `CSS_Color4`, `CSS_Color5`, `CSS_Color6`, `CSS_Color7`, `CSS_Color8`, `CSS_Color9`, `CSS_Color10`, `CSS_Image1`, `CSS_Image2`, `CSS_Image3`, `CSS_Image4`, `CSS_Image5`, `CSS_Image6`, `CSS_Image7`, `CSS_Image8`, `CSS_Image9`, `CSS_Image10`, `Messaging_EmailSubject1`, `Messaging_EmailBody1`, `Messaging_EmailSubject2`, `Messaging_EmailBody2`, `Messaging_EmailSubject3`, `Messaging_EmailBody3`, `Messaging_EmailSubject4`, `Messaging_EmailBody4`, `Messaging_EmailSubject5`, `Messaging_EmailBody5`) VALUES (1, 14, 'Shanons\' Online Notebook', 'Page', NULL, 'onlinenotebookmanager', '1.0.0', '/onlinenotebookmanager/assets/favicon.ico', '/onlinenotebookmanager/assets/company_logo.gif', 'default', '<H1><SPAN style=\"FONT-WEIGHT: bold\"><IMG style=\"MARGIN-RIGHT: 10px\" height=246 alt=\"\" src=\"/applications/app_engine/assets/bioimage.jpg\" width=230 align=right border=0>From the Desk of... The Blog Master</SPAN></H1>\r\n<P align=center>Welcome to my Blog!</P>\r\n<P>I hope to cover many topics in the coming months regarding this, that, and most definitely the other. This should be a fun and facinating ride!</P>\r\n<P>If you have any comments, feel free to post them or e-mail me! I am always welcome to suggestions -- after all, the reader should always come first with any Blog!</P>\r\n<P>Sit back, grab a cup of jo, and enjoy!</P>\r\n<P>Sincerely, </P>\r\n<P><SPAN style=\"FONT-STYLE: italic\">- The Blog Masterff</SPAN></P>\r\n<P><SPAN style=\"FONT-WEIGHT: bold; FONT-STYLE: italic\">NOTE: You can change this bio in the \"Settings\" page.</SPAN></P>\r\n<P> </P>', 'True', 'Website powered by <a href=\"http://www.dmxready.com/productdetails.asp?ItemID=175\">DMXReady Online Notebook Manager v1.0</a>. You can change the text in this footer from the preferences administration page.', 'Blog', 'Master', NULL, NULL, NULL, '', '', '', 1, 'True', 'admin', 'admin', 'test@test.com', 'True', 'True', 'True', 'False', 'True', 'False', 'False', 'False', 0, 100, 'False', 'False', 'True', 'True', 'True', 'True', 'True', 'True', 0, 60, 5, NULL, NULL, NULL, NULL, NULL, '', '', 'NORMAL', '', 'True', NULL, NULL, NULL, NULL, '#003366', '#000000', '#0c3e71', '#003366', '#ffffff', '#4682b4', '#003366', '#D4BF7D', '#F9E194', '#ccc', '/applications/app_engine/components/css/images/skyline.gif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
	
	mysql_query($sql);
	
	/*** END OF tblConfiguration ***/
	
	
	/*** tblEntity ***/
	$sql = "DROP TABLE IF EXISTS `tblEntity`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblEntity` (
  `EntityID` INTEGER NOT NULL AUTO_INCREMENT, 
  `FormTemplateIDkey` VARCHAR(50), 
  `CategoryIDkey` DOUBLE NULL DEFAULT 0, 
  `SecurityLevelIDkey` DOUBLE NULL, 
  `GroupIDkey` VARCHAR(255), 
  `ConfigIDkey` DOUBLE NULL DEFAULT 0, 
  `EnityType` VARCHAR(255), 
  `EntityStatus` VARCHAR(50), 
  `EntitySource` VARCHAR(255), 
  `Activated` VARCHAR(50), 
  `UserName` VARCHAR(255), 
  `Password1` VARCHAR(255), 
  `Salutation` VARCHAR(255), 
  `FirstName` VARCHAR(255), 
  `LastName` VARCHAR(255), 
  `ImageFileValue1` VARCHAR(255), 
  `ImageFileThumbValue1` VARCHAR(255), 
  `Title` VARCHAR(255), 
  `Address1` VARCHAR(255), 
  `Address2` VARCHAR(255), 
  `City` VARCHAR(255), 
  `State` VARCHAR(255), 
  `PostalCode` VARCHAR(255), 
  `Country` VARCHAR(255), 
  `Phone1` VARCHAR(255), 
  `Phone2` VARCHAR(255), 
  `Phone3` VARCHAR(255), 
  `Phone4` VARCHAR(255), 
  `Phone5` VARCHAR(255), 
  `Map` VARCHAR(255), 
  `EmailAddress` VARCHAR(255), 
  `WebsiteURL` VARCHAR(255), 
  `EntityMemo` TEXT, 
  `SortOrder` DOUBLE NULL, 
  `OrgName` VARCHAR(255), 
  `OrgAddress1` VARCHAR(255), 
  `OrgAddress2` VARCHAR(255), 
  `OrgCity` VARCHAR(255), 
  `OrgState` VARCHAR(255), 
  `OrgPostalCode` VARCHAR(255), 
  `OrgCountry` VARCHAR(255), 
  `OrgPhone1` VARCHAR(50), 
  `OrgPhone2` VARCHAR(50), 
  `OrgPhone3` VARCHAR(50), 
  `OrgPhone4` VARCHAR(50), 
  `OrgPhone5` VARCHAR(50), 
  `OrgMap` VARCHAR(255), 
  `OrgEmailAddress` VARCHAR(255), 
  `OrgWebsiteURL` VARCHAR(255), 
  `OrgImageFileValue1` VARCHAR(255), 
  `OrgImageFileThumbValue1` VARCHAR(255), 
  `OrgEntityMemo` TEXT, 
  `DateAdded` DATETIME, 
  `SecurityQuestion` VARCHAR(255), 
  `SecurityResponse` VARCHAR(255), 
  `LastDateAccessed` DATETIME, 
  `LoginCount` DOUBLE NULL DEFAULT 0, 
  `EntityIDKey1` DOUBLE NULL DEFAULT 0, 
  `EntityIDKey2` DOUBLE NULL DEFAULT 0, 
  `EntityIDKey3` DOUBLE NULL DEFAULT 0, 
  `EntityIDKey4` DOUBLE NULL DEFAULT 0, 
  `EntityIDKey5` DOUBLE NULL DEFAULT 0, 
  `ExtraField1` VARCHAR(255), 
  `ExtraField2` VARCHAR(255), 
  `ExtraField3` VARCHAR(255), 
  `ExtraField4` VARCHAR(255), 
  `ExtraField5` VARCHAR(255), 
  `ExtraField6` VARCHAR(255), 
  `ExtraField7` VARCHAR(255), 
  `ExtraField8` VARCHAR(255), 
  `ExtraField9` VARCHAR(255), 
  `ExtraField10` VARCHAR(255), 
  `ExtraField11` TEXT, 
  `ExtraField12` TEXT, 
  `ExtraField13` TEXT, 
  `ExtraField14` TEXT, 
  `ExtraField15` TEXT, 
  `ExtraField16` TEXT, 
  `ExtraField17` TEXT, 
  `ExtraField18` TEXT, 
  `ExtraField19` TEXT, 
  `ExtraField20` TEXT, 
  `LookupItemID1` DOUBLE NULL DEFAULT 0, 
  `LookupItemID2` DOUBLE NULL DEFAULT 0, 
  `LookupItemID3` DOUBLE NULL DEFAULT 0, 
  `LookupItemID4` DOUBLE NULL DEFAULT 0, 
  `LookupItemID5` DOUBLE NULL DEFAULT 0, 
  `LookupItemID6` DOUBLE NULL DEFAULT 0, 
  `LookupItemID7` DOUBLE NULL DEFAULT 0, 
  `LookupItemID8` DOUBLE NULL DEFAULT 0, 
  `LookupItemID9` DOUBLE NULL DEFAULT 0, 
  `LookupItemID10` DOUBLE NULL DEFAULT 0, 
  `SubscriptionStartDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(), 
  `SubscriptionEndDate` DATETIME, 
  `LastEditDate` DATETIME, 
  INDEX (`CategoryIDkey`), 
  INDEX (`ConfigIDkey`), 
  UNIQUE (`EmailAddress`), 
  INDEX (`EntityID`), 
  INDEX (`FormTemplateIDkey`), 
  INDEX (`OrgPostalCode`), 
  INDEX (`State`), 
  INDEX (`PostalCode`), 
  PRIMARY KEY (`EntityID`), 
  INDEX (`SecurityLevelIDkey`), 
  UNIQUE (`UserName`)
) TYPE=InnoDB";
	
	mysql_query($sql);
	
	$sql = "INSERT INTO `tblEntity` (`EntityID`, `FormTemplateIDkey`, `CategoryIDkey`, `SecurityLevelIDkey`, `GroupIDkey`, `ConfigIDkey`, `EnityType`, `EntityStatus`, `EntitySource`, `Activated`, `UserName`, `Password1`, `Salutation`, `FirstName`, `LastName`, `ImageFileValue1`, `ImageFileThumbValue1`, `Title`, `Address1`, `Address2`, `City`, `State`, `PostalCode`, `Country`, `Phone1`, `Phone2`, `Phone3`, `Phone4`, `Phone5`, `Map`, `EmailAddress`, `WebsiteURL`, `EntityMemo`, `SortOrder`, `OrgName`, `OrgAddress1`, `OrgAddress2`, `OrgCity`, `OrgState`, `OrgPostalCode`, `OrgCountry`, `OrgPhone1`, `OrgPhone2`, `OrgPhone3`, `OrgPhone4`, `OrgPhone5`, `OrgMap`, `OrgEmailAddress`, `OrgWebsiteURL`, `OrgImageFileValue1`, `OrgImageFileThumbValue1`, `OrgEntityMemo`, `DateAdded`, `SecurityQuestion`, `SecurityResponse`, `LastDateAccessed`, `LoginCount`, `EntityIDKey1`, `EntityIDKey2`, `EntityIDKey3`, `EntityIDKey4`, `EntityIDKey5`, `ExtraField1`, `ExtraField2`, `ExtraField3`, `ExtraField4`, `ExtraField5`, `ExtraField6`, `ExtraField7`, `ExtraField8`, `ExtraField9`, `ExtraField10`, `ExtraField11`, `ExtraField12`, `ExtraField13`, `ExtraField14`, `ExtraField15`, `ExtraField16`, `ExtraField17`, `ExtraField18`, `ExtraField19`, `ExtraField20`, `LookupItemID1`, `LookupItemID2`, `LookupItemID3`, `LookupItemID4`, `LookupItemID5`, `LookupItemID6`, `LookupItemID7`, `LookupItemID8`, `LookupItemID9`, `LookupItemID10`, `SubscriptionStartDate`, `SubscriptionEndDate`, `LastEditDate`) VALUES (1, '1', 1, 1, '4', NULL, NULL, NULL, 'Member Signup', 'True', 'admin', 'admin', 'Mr.', 'Shannon', 'Klausen', '/onlinenotebookmanager/assets/bioimage.jpg', '/applications/app_engine/assets/sally.jpg', 'Student', '451 Cepy Rd.', NULL, 'Los Angeles', 'CA', '90310', 'USA', '555-555-5555', NULL, NULL, NULL, NULL, NULL, 'test@test.com', NULL, NULL, NULL, 'DMXReady.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2003-10-30 00:00:00', NULL, NULL, '2004-05-03 20:24:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
	
	mysql_query($sql);
	
	/*** END OF tblEntity ***/
	
	
	/*** tblExtraDetail ***/
	$sql = "DROP TABLE IF EXISTS `tblExtraDetail`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblExtraDetail` (
  `ExtraDetailID` INTEGER NOT NULL AUTO_INCREMENT, 
  `ItemIDkey` INTEGER DEFAULT 0, 
  `EntityIDkey` INTEGER DEFAULT 0, 
  `ExtraDetailName` VARCHAR(255), 
  `ExtraDetailMemo` TEXT, 
  `ExtraDetailPostedBy` VARCHAR(255), 
  `ExtraDetailDateAdded` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(), 
  `ExtraDetailLastEditDate` DATETIME, 
  `ExtraDetailExpiryDate` DATETIME, 
  `ExtraDetailDaysNew` INTEGER DEFAULT 0, 
  `ExtraDetailActivated` VARCHAR(5) DEFAULT 'True', 
  `ExtraDetailSortOrder` INTEGER DEFAULT 0, 
  `ExtraDetailSendToEmailAddress` VARCHAR(50), 
  `ExtraDetailSpecialInstructions` TEXT, 
  `ExtraDetailFirstName` VARCHAR(255), 
  `ExtraDetailLastName` VARCHAR(255), 
  `ExtraDetailEmailAddress` VARCHAR(255), 
  `ExtraDetailOrgName` VARCHAR(255), 
  UNIQUE (`ExtraDetailID`), 
  INDEX (`ExtraDetailEmailAddress`), 
  INDEX (`EntityIDkey`), 
  UNIQUE (`ExtraDetailID`), 
  PRIMARY KEY (`ExtraDetailID`), 
  INDEX (`ItemIDkey`)
) TYPE=InnoDB";

	mysql_query($sql);
	
	$sql = "INSERT INTO `tblExtraDetail` (`ExtraDetailID`, `ItemIDkey`, `EntityIDkey`, `ExtraDetailName`, `ExtraDetailMemo`, `ExtraDetailPostedBy`, `ExtraDetailDateAdded`, `ExtraDetailLastEditDate`, `ExtraDetailExpiryDate`, `ExtraDetailDaysNew`, `ExtraDetailActivated`, `ExtraDetailSortOrder`, `ExtraDetailSendToEmailAddress`, `ExtraDetailSpecialInstructions`, `ExtraDetailFirstName`, `ExtraDetailLastName`, `ExtraDetailEmailAddress`, `ExtraDetailOrgName`) VALUES (1, 1, 1, 'Audiam impetus facilisi his.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. ', 'Sally Yung', '2004-10-04 00:00:00', '2006-03-24 00:00:00', '2006-06-03 00:00:00', 5, 'True', 0, 'frankc@netkinetic.com', 'Contact John Favro', NULL, NULL, NULL, NULL);";
	
	mysql_query($sql);
	
	/*** END OF tblExtraDetail ***/
	
	
	/*** tblItems ***/
	$sql = "DROP TABLE IF EXISTS `tblItems`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblItems` (
  `ItemID` INTEGER NOT NULL AUTO_INCREMENT, 
  `ProjectIDkey` DOUBLE NULL, 
  `CategoryIDkey` DOUBLE NULL DEFAULT 0, 
  `ItemName` VARCHAR(255), 
  `ItemLink` VARCHAR(255), 
  `ItemMemo` TEXT, 
  `ItemDesc` TEXT, 
  `ItemDescShort` TEXT, 
  `ItemCount` DOUBLE NULL DEFAULT 0, 
  `ItemUOM` VARCHAR(255), 
  `DateAdded` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(), 
  `TimeStamp` TIMESTAMP, 
  `LastEditDate` DATETIME, 
  `ExpiryDate` DATETIME, 
  `DaysNew` DOUBLE NULL DEFAULT 0, 
  `Activated` VARCHAR(5) DEFAULT 'True', 
  `SortOrder` DOUBLE NULL DEFAULT 1, 
  `ItemPriceValue1` DOUBLE NULL, 
  `ItemPriceValue2` DOUBLE NULL, 
  `ItemPriceValue3` DOUBLE NULL, 
  `ItemPriceValue4` DOUBLE NULL, 
  `ItemPriceValue5` DOUBLE NULL, 
  `ItemDownloadFile1` VARCHAR(255), 
  `ItemDownloadFile2` VARCHAR(255), 
  `ItemDownloadFile3` VARCHAR(255), 
  `ItemDownloadFile4` VARCHAR(255), 
  `ItemDownloadFile5` VARCHAR(255), 
  `ImageFileValue1` VARCHAR(255), 
  `ImageFileValue2` VARCHAR(255), 
  `ImageFileValue3` VARCHAR(255), 
  `ImageFileValue4` VARCHAR(255), 
  `ImageFileValue5` VARCHAR(255), 
  `ImageFileThumbValue1` VARCHAR(255), 
  `ImageFileThumbValue2` VARCHAR(255), 
  `ImageFileThumbValue3` VARCHAR(255), 
  `ImageFileThumbValue4` VARCHAR(255), 
  `ImageFileThumbValue5` VARCHAR(255), 
  `LookupItemID1` DOUBLE NULL DEFAULT 0, 
  `LookupItemID2` DOUBLE NULL DEFAULT 0, 
  `LookupItemID3` DOUBLE NULL DEFAULT 0, 
  `LookupItemID4` DOUBLE NULL DEFAULT 0, 
  `LookupItemID5` DOUBLE NULL DEFAULT 0, 
  `ExtraField1` VARCHAR(255), 
  `ExtraField2` VARCHAR(255), 
  `ExtraField3` VARCHAR(255), 
  `ExtraField4` VARCHAR(255), 
  `ExtraField5` VARCHAR(255), 
  `ExtraField6` VARCHAR(255), 
  `ExtraField7` VARCHAR(255), 
  `ExtraField8` VARCHAR(255), 
  `ExtraField9` VARCHAR(255), 
  `ExtraField10` VARCHAR(255), 
  `ExtraField11` TEXT, 
  `ExtraField12` TEXT, 
  `ExtraField13` TEXT, 
  `ExtraField14` TEXT, 
  `ExtraField15` TEXT, 
  `ExtraField16` TEXT, 
  `ExtraField17` TEXT, 
  `ExtraField18` TEXT, 
  `ExtraField19` TEXT, 
  `ExtraField20` TEXT, 
  `OwnerFirstName` VARCHAR(255), 
  `OwnerLastName` VARCHAR(255), 
  `OwnerEmailAddress` VARCHAR(255), 
  `ItemMetaTitle` TEXT, 
  `ItemMetaKeywords` TEXT, 
  `ItemMetaDescription` TEXT, 
  `PageLink` VARCHAR(255) DEFAULT 'index.asp', 
  `Variables` VARCHAR(255), 
  `Target` VARCHAR(50), 
  `ExtraIDKey1` DOUBLE NULL DEFAULT 0, 
  `ExtraIDKey2` DOUBLE NULL DEFAULT 0, 
  `ExtraFieldLabel1` VARCHAR(255), 
  `ExtraFieldLabel2` VARCHAR(255), 
  `ExtraFieldLabel3` VARCHAR(255), 
  `ExtraFieldLabel4` VARCHAR(255), 
  `ExtraFieldLabel5` VARCHAR(255), 
  `ExtraFieldLabel6` VARCHAR(255), 
  `ExtraFieldLabel7` VARCHAR(255), 
  `ExtraFieldLabel8` VARCHAR(255), 
  `ExtraFieldLabel9` VARCHAR(255), 
  `ExtraFieldLabel10` VARCHAR(255), 
  `EntityIDkey` DOUBLE NULL DEFAULT 0, 
  `SecurityLevelIDkey` DOUBLE NULL DEFAULT 0, 
  `TemplateIDkey` DOUBLE NULL DEFAULT 0, 
  `StoreIDkey` DOUBLE NULL DEFAULT 0, 
  `GroupIDkey` DOUBLE NULL DEFAULT 0, 
  `ItemTypeIDkey` DOUBLE NULL DEFAULT 0, 
  `CatalogIDkey` DOUBLE NULL DEFAULT 0, 
  `SitePlanIDkey` DOUBLE NULL, 
  `PageTemplateIDkey` DOUBLE NULL, 
  `IncludeFileIDkey` DOUBLE NULL, 
  `CSSIDkey` DOUBLE NULL, 
  INDEX (`ProjectIDkey`), 
  INDEX (`CategoryIDkey`), 
  INDEX (`IncludeFileIDkey`), 
  INDEX (`ItemID`), 
  INDEX (`ItemTypeIDkey`), 
  INDEX (`PageTemplateIDkey`), 
  INDEX (`CSSIDkey`), 
  PRIMARY KEY (`ItemID`), 
  INDEX (`SecurityLevelIDkey`), 
  INDEX (`SitePlanIDkey`), 
  INDEX (`StoreIDkey`), 
  INDEX (`CatalogIDkey`), 
  INDEX (`TemplateIDkey`)
) TYPE=InnoDB";

	mysql_query($sql);
	
	$sql = "INSERT INTO `tblItems` (`ItemID`, `ProjectIDkey`, `CategoryIDkey`, `ItemName`, `ItemLink`, `ItemMemo`, `ItemDesc`, `ItemDescShort`, `ItemCount`, `ItemUOM`, `DateAdded`, `TimeStamp`, `LastEditDate`, `ExpiryDate`, `DaysNew`, `Activated`, `SortOrder`, `ItemPriceValue1`, `ItemPriceValue2`, `ItemPriceValue3`, `ItemPriceValue4`, `ItemPriceValue5`, `ItemDownloadFile1`, `ItemDownloadFile2`, `ItemDownloadFile3`, `ItemDownloadFile4`, `ItemDownloadFile5`, `ImageFileValue1`, `ImageFileValue2`, `ImageFileValue3`, `ImageFileValue4`, `ImageFileValue5`, `ImageFileThumbValue1`, `ImageFileThumbValue2`, `ImageFileThumbValue3`, `ImageFileThumbValue4`, `ImageFileThumbValue5`, `LookupItemID1`, `LookupItemID2`, `LookupItemID3`, `LookupItemID4`, `LookupItemID5`, `ExtraField1`, `ExtraField2`, `ExtraField3`, `ExtraField4`, `ExtraField5`, `ExtraField6`, `ExtraField7`, `ExtraField8`, `ExtraField9`, `ExtraField10`, `ExtraField11`, `ExtraField12`, `ExtraField13`, `ExtraField14`, `ExtraField15`, `ExtraField16`, `ExtraField17`, `ExtraField18`, `ExtraField19`, `ExtraField20`, `OwnerFirstName`, `OwnerLastName`, `OwnerEmailAddress`, `ItemMetaTitle`, `ItemMetaKeywords`, `ItemMetaDescription`, `PageLink`, `Variables`, `Target`, `ExtraIDKey1`, `ExtraIDKey2`, `ExtraFieldLabel1`, `ExtraFieldLabel2`, `ExtraFieldLabel3`, `ExtraFieldLabel4`, `ExtraFieldLabel5`, `ExtraFieldLabel6`, `ExtraFieldLabel7`, `ExtraFieldLabel8`, `ExtraFieldLabel9`, `ExtraFieldLabel10`, `EntityIDkey`, `SecurityLevelIDkey`, `TemplateIDkey`, `StoreIDkey`, `GroupIDkey`, `ItemTypeIDkey`, `CatalogIDkey`, `SitePlanIDkey`, `PageTemplateIDkey`, `IncludeFileIDkey`, `CSSIDkey`) VALUES (1, 5, 27, 'Expect Less Knocks!', NULL, '\r\n\r\n<h3>Online Syllabus - Expect Less Knocks at Your Door </h3>\r\n\r\n<p>DMXReady Online Notebook is great for teachers, professors, and other educators who want to provide an online syllabus for their students. You don\'t have to be an Internet wiz to use it anyone with basic Web skills can quickly add, edit, or delete information using a standard web browser like Internet Explorer.</p>\r\n\r\n<p>You can use Online Notebook Manager on your current server or create a whole new separate one -- all you need is an ASP-enabled (Windows) Internet Provider. DMXReady also offers Professional Services to get you up and running faster so that everything is uploaded to your server, installed, and working for you. No coding or FTP knowledge needed -- everything will be ready for you to use just like it is in this demo!</p>\r\n\r\n<p>Online Notebook allows you to create several different pages and make them easily navigable using the Table of Contents column (left). Simply give your students the URL of your notebook, and they can refer to the syllabus anytime they need. No lost papers, no misunderstandings, and changes are made instantly. Best of all, you\'ll have less knocks at your door!</p>\r\n\r\n<p>Browse through this demo syllabus to see how DMXReady Online Notebook Manager can help streamline interactions with your students.</p>', NULL, NULL, 0, NULL, '2008-04-07 10:13:53', '2008-04-07 10:13:53', '2008-07-12 00:00:00', NULL, 0, 'True', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', 'index.asp', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL)";
	
	mysql_query($sql);
	
	/*** END OF tblItems ***/
	
	
	/*** tblProjects ***/
	$sql = "DROP TABLE IF EXISTS `tblProjects`";
	
	mysql_query($sql);
	
	$sql = "CREATE TABLE `tblProjects` (
  `ProjectID` INTEGER NOT NULL AUTO_INCREMENT, 
  `ConfigIDkey` INTEGER DEFAULT 1, 
  `ProjectName` VARCHAR(255), 
  `ParentProjectID` INTEGER DEFAULT 0, 
  `ProjectDesc` TEXT, 
  `ProjectLabel` VARCHAR(255), 
  `ProjectImageFile` VARCHAR(255), 
  `ProjectActivated` VARCHAR(50) DEFAULT 'True', 
  `ProjectSortOrder` INTEGER NOT NULL DEFAULT 1, 
  INDEX (`ProjectID`), 
  INDEX (`ConfigIDkey`), 
  PRIMARY KEY (`ProjectID`)
) TYPE=InnoDB";

	mysql_query($sql);
	
	$sql = "INSERT INTO `tblProjects` (`ProjectID`, `ConfigIDkey`, `ProjectName`, `ParentProjectID`, `ProjectDesc`, `ProjectLabel`, `ProjectImageFile`, `ProjectActivated`, `ProjectSortOrder`) VALUES (5, 1, 'For Educators: Online Syllabus', 0, '', NULL, '', 'True', 1)";
	
	mysql_query($sql);
	
	/*** END OF tblProjects ***/
	
	
	/*** Updating the Connection string ***/
	
	$connectionFile = "<?php
# FileName=\"Connection_php_mysql.htm\"
# Type=\"MYSQL\"
# HTTP=\"true\"

\$hostname_onlinenotebookmanager = \"" . $hostname . "\"; // Fill with your MySQL Server
\$database_onlinenotebookmanager = \"" . $database . "\"; // Fill with your MySQL Database name
\$username_onlinenotebookmanager = \"" . $username . "\"; // Fill with your MySQL Database username
\$password_onlinenotebookmanager = \"" . $password . "\"; // Fill with your MySQL Database password

if(\$hostname_onlinenotebookmanager!=\"\") {
\$IsConnectionValid = true;
\$onlinenotebookmanager = mysql_pconnect(\$hostname_onlinenotebookmanager, \$username_onlinenotebookmanager, \$password_onlinenotebookmanager) or trigger_error(mysql_error(),E_USER_ERROR);
}
else {\$IsConnectionValid = false;}
?>";

	$filetodelete = $_SERVER['DOCUMENT_ROOT'] . "/Connections/onlinenotebookmanager.php";
	unlink($filetodelete);
	
	$f = $_SERVER['DOCUMENT_ROOT'] . "/Connections/onlinenotebookmanager.php";

	$file = fopen($f, 'w');
	fputs($file, $connectionFile);
	
	$url = $_SERVER['PHP_SELF'] . "?done=yes";
	
	if(fopen($f, "r")) echo "<meta http-equiv='refresh' content='0;url=" . $url . "' />";
	else die("Failed to update file");
	
?>
<?php } ?>

<?php
if(isset($_GET['done']) && $_GET['done']=="yes") {
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td valign="top">
		<h1 align="right"><a href="http://www.dmxready.com/"><img src="http://www.dmxready.com/assets/images/temp_logo.gif" alt="dmxready.com" width="230" height="74" border="0" align="left" /></a></h1>
<div align="right"><strong>Welcome to <em><strong>Online Notebook Manager v1.0</strong></em><br />
  One of   the powerful website applications from DMXReady</strong></div>
<div>
  <h1 align="center"><br />
    Congratulations !</h1>
  <h3>Your MySQL Database for Online Notebook Manager has been successfully installed<br />
</h3>
<h3 align="center"><a href="/onlinenotebookmanager.php"><B>CLICK HERE to Start using Online Notebook Manager</B></a></h3>
<p align="center">&nbsp;</p>
</div>
	</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
