<?php include$_SERVER["DOCUMENT_ROOT"]."/header.php"; ?>
<html>


<!-- Mirrored from wwwwwwwww.jodi.org/100cc/zxcvb/indexon.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Jan 2020 01:43:07 GMT -->
<BODY   BGCOLOR="#000000" TEXT="#ffff00" LINK="#ffff00" VLINK="#ffff00" ALINK="#ffffff"><font size=7><PRE><B># Date:Time - Home -                                                                        #
# Set variables
$SSI = 1;       # 0 - Used from link
                # 1 - Used as Server Side Include
                # 2 - Used from  img> tag

# Path to your log/tmp file, chmod 666
$logfile =  "_";
$tmpfile = ".tmp";

$ip = $ENV{'REMOTE_ADDR'};
$browser = $ENV{'HTTP_USER_AGENT'};
$referer = $ENV{'HTTP_REFERER'};
$here = $ENV{'DOCUMENT_URI'};
@digits = split (/\./, $ip);
$address = pack ("C4", @digits);
$host = gethostbyaddr ($address, 2);

# From Link
if ($SSI eq 0) {
&parse_query;
&clean;
$dest = $query{'dest'};
&write_file;
&redirect;
}

# From SSI
if ($SSI eq 1) {
&write_file;
}

# From img> tag
if ($SSI eq 2) {
&parse_query;
&clean;
$this = $query{'dest'};
&write_file;
&show_img;
}

sub parse_query {
    @query_strings = split("&", $ENV{"QUERY_STRING"});
    foreach $q (@query_strings) {
        ($attr, $val) = split("=", $q);
        $query{$attr} = $query{$attr}." ".$val;
    }
}

sub clean {
    if ($query{'dest'} =~ /\/$/) {
        chop($query{'dest'});
    }
    #$query{'dest'} =~ s/http\:\/\///g;
    #$query{'dest'} =~ s/\//_\|_/g;
}

sub redirect {
print "Location: $dest\n\n";
}

sub write_file {

if (! (-f "$tmpfile")) {
  open (TMP, ">$tmpfile");
  close TMP;
}

&date;
open (TMP,">>$tmpfile") || die "Can't write to $tmpfile: $!";
if ($SSI eq 0) {
  print TMP "$date - $ip - $host - $browser - $dest - $referer\n";
}
elsif ($SSI eq 1) {
  print TMP "$date:$time - $host - $browser - $referer\n";
}
else {
  print TMP "$date - $ip - $host - $browser - $this - $referer\n";
}

open(LOG, "< $logfile") || die "Can't open $logfile: $!";
while (<LOG>) {
  (print TMP $_) || die "Can't write to $tmpfile: $!";
}

close LOG;
close TMP;

rename($tmpfile, $logfile) || die "Can't rename $tmpfile to $logfile: $!";

} # end sub

sub date {
   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

   @months = ("1","2","3","4","5","6","7","8","9","10","11","12");
   $date = "@months[$mon]/$mday/$year";

   if ($hour == 0) {$hour ="00";}
     elsif ($hour < 10) {$hour = "0".$hour;};
   if ($min == 0) {$min ="00";}
     elsif ($min < 10) {$min = "0".$min;};
   if ($sec == 0) {$sec = "00";}
     elsif ($sec < 10) {$sec = "0".$sec;};
   $time = $hour.":".$min.":".$sec;
}

sub show_img {
$! = 1;
$| = 1;
print "Content-type: image/gif\n\nGIF89a\1\0\1\0\0\2\2D\1\0\n";
}

# End

</body>
<!-- Mirrored from wwwwwwwww.jodi.org/100cc/zxcvb/indexon.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Jan 2020 01:43:07 GMT -->
</html>                                                                                         