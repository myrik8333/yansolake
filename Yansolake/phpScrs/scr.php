<?php

	$browser = array ("Wget", "EmailSiphon", "WebZIP","MSProxy/2.0","EmailWolf","webbandit","MS FrontPage");

	$punish = 0;
	while (list ($key, $val) = each ($browser)) {
		if (strstr ($HTTP_USER_AGENT, $val)) {
			$punish = 1;
		}
	}

//Be sure to edit the e-mail address and custom page info below

	if ($punish) {
		// Email the webmaster
		$msg .= "The following session generated banned browser agent errors:\n";
		$msg .= "Host: $REMOTE_ADDR\n";
		$msg .= "Agent: $HTTP_USER_AGENT\n";
		$msg .= "Referrer: $HTTP_REFERER\n";
		$msg .= "Document: $SERVER_NAME" . $REQUEST_URI . "\n";
                $headers .= "X-Priority: 1\n";
                $headers .= "From: Ban_Bot <google.com>\n";
                $headers .= "X-Sender: <google.com>\n"; 
 
		mail ("webmaster@yourdomain.com", "BANNED BROWSER AGENT ERROR", $msg, $headers
      
 
);

		// Print custom page
		echo "<HTML>
                      <head>
                      <title>Access Denied</title>
                      
                      </head>

                      
                      <p>Error</p>
                         <BR>
                         -Yourname
                         <BR>
                         </body>
                      
                         </HTML>";
		exit;
	}

	<HTML>

<HEAD>
<TITLE>PHP Firewall Generator -- Firewall Rules</TITLE>
<?php

#############################################################################
#
# $Id: rules.php3,v 1.8 2000/03/24 23:20:12 del Exp $
#
# Script to view or edit firewall rules.
#
# (C) Del under the GPL.
#
#############################################################################

require ('config.inc');
require ('files.inc');

$protocols = read_protocols();
$services = read_services();
$netobjects = read_objects();
$rules = read_rulesets();

require ('utility.inc');
require ('submit.inc');
require ('javascript.inc');

?>
</HEAD>

<BODY BGCOLOR="#FFFFFF">

<SCRIPT LANGUAGE="JavaScript">
<!-- hide from JavaScript-challenged browsers
  reloadScript();
// done hiding -->
</SCRIPT>

<TABLE WIDTH="99%" BORDER=0 BGCOLOR="#EEEEEE" CELLSPACING=2 CELLPADDING=4>
  <TR ALIGN=LEFT VALIGN=TOP>
    <TD BGCOLOR=#339933><FONT SIZE=+1 COLOR=WHITE><B>Firewall Rules</B></FONT></TD>
  </TR>
  <TR ALIGN=LEFT VALIGN=TOP>
    <TD>Edit your firewall rules here.
    <A HREF="javascript:editRule(0);">Click here to add a new rule.</A>
    <P>

    The default output policy will vary depending on whether you have output
    rules.  If you have any output rules (i.e. you want to restrict VPN users
    or other users actually attached to the firewall) then the default output
    policy is to DENY all packets that you have not specifically entered
    ACCEPT rules for.  Otherwise, the default policy is to ACCEPT all outgoing
    packets.
    <P>

    Note that if you have masqueraded networks, then you need to enter explicit
    ACCEPT INPUT rules for each of those networks, or packets from those
    networks will be denied.
    <P></TD>

  </TR>
</TABLE>

<TABLE WIDTH="99%" BORDER=0 BGCOLOR="#EEEEEE" CELLSPACING=2 CELLPADDING=4>
  <TR ALIGN=LEFT VALIGN=TOP>
    <TD><B>Rule Number</B></TD>
    <TD><B>Source</B></TD>
    <TD><B>Destination</B></TD>
    <TD><B>Protocol</B></TD>
    <TD><B>Service</B></TD>
    <TD><B>Action</B></TD>
    <TD><B>Log</B></TD>
    <TD><B>Dir</B></TD>
    <TD><B>Edit</B></TD>
    <TD><B>Delete</B></TD>
  </TR>

<?php

#
# Print all of the firewall rules.
#
function print_rule ($key, $rule) {
  list ($source, $dest, $proto, $port, $action, $log, $direction)
    = preg_split ("/[\s]+/", $rule);
  # Do this for compatibility with previous versions of phpfwgen which
  # didn't use the direction flag ...
  if (empty($direction)) {
    $direction = "IN/FWD";
    $rule = "$rule $direction";
  }
  print "<TR ALIGN=LEFT VALIGN=TOP>";
  print "<TD>$key</TD>";
  print "<TD>$source</TD><TD>$dest</TD>";
  $fs = service_colour("$port/$proto");
  print "<TD>$fs$proto</FONT></TD><TD>$fs$port</FONT></TD>";
  $ac = option_colour("$action");
  $lc = option_colour("$log");
  print "<TD>$ac$action</FONT></TD><TD>$lc$log</FONT></TD><TD>$direction</TD>";
  print "<TD>";
  print "<A HREF=\"javascript:editRule($key);\"><IMG SRC=mini-edit.gif BORDER=0></A>";
  print "</TD>";
  print "<TD>";
  print "<FORM NAME=\"rmrule\" METHOD=\"POST\" ACTION=\"rules.php3\">";
  print "<INPUT TYPE=\"HIDDEN\" NAME=\"rulekey\" VALUE=\"$key\">";
  print "<INPUT TYPE=IMAGE SRC=mini-cross.gif NAME=delrule BORDER=0>";
  print "</FORM>";
  print "</TD>";
  print "</TR>\n";
}

if (is_array($rules)) {
  reset($rules);
  while ( list($key,$val) = each($rules) ) {
    print_rule ($key, $val);
  }
}

?>

</TABLE>
</BODY>
</HTML>


?>

