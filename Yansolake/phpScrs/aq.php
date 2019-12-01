

<?php
//$query = preg_replace("/\\\'/","'",$query);
//$bs = "\\";

//print "backslash is: $bs <BR>";

//$f = "/$bs$bs$bs$bs/";
//$r = $bs;

//print "find $f replace with $r <BR>";
//print "in $query <BR>";

//$query = preg_replace($f,$r,$query);
//$query = stripslashes($query);
//print "gives $query <BR>";
?>

<FORM METHOD="post">
<INPUT TYPE="password" NAME="misc" SIZE="1" VALUE="<?=$misc?>">
<TEXTAREA NAME="query" COLS="40" ROWS="10">
<?= $query ?>
</TEXTAREA>
<INPUT TYPE="submit">
</FORM>


<?php

if($misc != "passwordYouMakeUp"){  die ("Can't use this tool.");}


	$link = mysql_connect("dbHost", "dbuser", "dbpass")
		or die ("Could not connect<BR>");
	print ("Connected successfully<BR>");
	$db = "dbname";


	mysql_select_db($db)
		or die ("Could not select database<BR>");

	$queries = preg_split("/\\\\g/",$query);
//	var_dump($queries);
	print "<BR>";
	foreach($queries as $query) {
		print "doing: " . $query . "<BR><BR>";
		$result = mysql_query ($query)
			or print ("<FONT COLOR=red>Query failed: " . mysql_error() . "</FONT><BR><BR>");
		if (preg_match("/^\\s*(select|show)/i",$query)){

			while ($line = mysql_fetch_assoc($result)) {

				foreach($line as $key => $value) {
					print "$key is $value<BR>\n";
				}
				print "<BR>";
			}

		}
	}
	mysql_close($link);
?>