<?
include("includes/access.php");
include("includes/header.php");
if($_REQUEST[del]):
   $r=mysql_query("select * from " . $prev . "adminmenu where  parent_id=" . $_REQUEST[id]);
   if(@mysql_num_rows($r)):
      $msg="<font face=verdana size=1 color=#ffffff><b>You Can't delete.adminmenus exists in this category.</b></font>";	  
   else:
      $r=mysql_query("delete from " . $prev . "adminmenu where id=\"" . $_REQUEST[id] . "\"");
      echo"<script>window.location.href='adminmenu.list.php';</script>";
   endif;
endif;
?>
<form method=post action="<?=$_SERVER[PHP_SELF]?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor=silver cellpadding="4" style='border:solid 1px <?=$dark?>'>
<tr bgcolor=<?=$light?> ><td  class=header>Admin Menu List</td><td align=right ><input type=button   class=lnk  value="Add Admin Menu" onClick="javascritp:window.location.href='adminmenu.entryform.php?parent_id=0';" ></td></tr></table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
<thead>
<tr><td valign=top><b>Admin Menu Name</b></td><td valign=top><b>Sub Admin menu</b></td><td valign=top align="center"><b>Order</b></td><td valign=top align=center><b>Action</b></td></tr>
</thead>
<tbody><?
$j=0;$tids=array();
if($_REQUEST[tid]):
  $tids=explode("|",$_REQUEST[tid]);
endif;
$r=mysql_query("select * from " . $prev . "adminmenu where  parent_id=0 order by ord");
while($d=@mysql_fetch_array($r)):
    if(!($j%2)){$class="even";}else{$class="odd";}
	echo"<tr bgcolor=#ffffff class=even>
			<td >";
				if(in_array($d[id],$tids)):
					echo"<input type=image img src='images/minus-icon.png' height=15 align=absmiddle class=lnk onclick=\"javascript:window.location.href='" . $_SERVER[PHP_SELF] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\" value='-'>";
				else:
					$q=mysql_query("select count(*) as total from " . $prev . "adminmenu where  parent_id=" . $d[id]);
					$n=@mysql_result($q,0,"total");
					
					if($n>0)
					{
						echo"<img src='images/plus-icon.png' height=15 align=absmiddle class=lnk onclick=\"javascript:window.location.href='" . $_SERVER[PHP_SELF] . "?tid=". $tid . "|" . $d[id] . "|'\" >"; 
					}
					else
					{
						echo"<img src='images/plus-icon.png' height=15 align=absmiddle class=lnk onclick=\"javascript:window.location.href='" . $_SERVER[PHP_SELF] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\" >";						
					}
				endif;
				echo" <a class=lnk";
						echo" href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $d[id] . "'";
						//echo"href='#'";
						echo"><b>" . $d[name] . "</b>
					</a>
			</td>
			<td align=center>&nbsp;</td>
			<td align=center>" . $d[ord] . "</td>
			<td align=center>
				<a class=lnk ";
					//echo"href='#'"; 
					echo"href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $d[id] . "'"; 
					echo"><u>Edit</u>
				</a> |  
				<a class=lnk "; 
					//echo"href='#'"; 
					echo"href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&parent_id=" . $d[id] . "'";
					echo"><u>Add Sub</u>
				</a> | 
				<a class=lnk"; 
					echo" href=\"javascript:if(confirm('You are deleting `" . $d[name] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?tid=" . $_REQUEST[tid] . "&id=" . $d[id] . "&del=1';}\""; 
					//echo" href='#'";
					echo"><u>Delete</u>
				</a>
			</td>
		</tr>";
    	if(in_array($d[id],$tids)):
			$rr=mysql_query("select * from " . $prev . "adminmenu where parent_id=" . $d[id] . " order by ord");
			$k=0;
			while($dd=mysql_fetch_array($rr)):
				if(!($k%2)){$class="odd";}else{$class="even";} 
				echo"<tr bgcolor=#ffffff class=odd>
						<td>&nbsp;|______________</td>
						<td >
							<a class=lnk"; 
								echo" href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $dd[id] . "&parent_id=" . $dd[parent_id] . "'"; 
								//echo "href='#'";
								echo">" . $dd[name] . "
							</a>
						</td>
						<td align=center>" . $dd[ord] . "</td>
						<td align=center> 
							<a class=lnk"; 
								echo" href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $dd[id]. "&parent_id=" . $dd[parent_id] . "'"; 
								//echo"href='#'";
								echo"><u>Edit</u>
							</a> | 
							
							<a class=lnk"; 
								echo" href=\"javascript:if(confirm('You are deleting `" . $dd[name] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?tid=" . $_REQUEST[tid] . "&id=" . $dd[id] . "&del=1';}\"";
								//echo"href='#'";
								echo"><u>Delete</u>
							</a>
						</td>
					</tr>";
				$r3=mysql_query("select * from " . $prev . "adminmenu where parent_id=" . $dd[id] . " order by ord");
				$k=0;
				while($d3=mysql_fetch_array($r3)):
					echo"<tr bgcolor=#ffffff class=odd>
							<td >&nbsp;</td>
							<td>&nbsp;|______________<td >
								<a class=lnk"; 
									echo" href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $d3[id] . "&parent_id=" . $dd[id] . "'"; 
									//echo" href='#'";
									echo">" . $d3[name] . "
								</a>
							</td>
							<td align=center> 
								<a class=lnk "; 
									echo "href='adminmenu.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $d3[id] . "'"; 
									//echo"href='#'";
									echo"><u>Edit</u>
								</a> | 
								<a class=lnk"; 
									echo "href='add.entryform.php?tid=" . $_REQUEST[tid] . "&id=" . $d3[id] . "'"; 
									//echo" href='#'";
									echo"><u>Add Ads</u>
								</a> | 
								<a class=lnk"; 
									echo" href=\"javascript:if(confirm('You are deleting `" . $d3[name] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?tid=" . $_REQUEST[tid] . "&id=" . $d3[id] . "&del=1';}\"";
									//echo"href='#'";
									echo"><u>Delete</u>
								</a>
							</td>
						</tr>";
				endwhile;		
				$k++;
			endwhile;
		endif;	
		$j++;
	endwhile;   
	?>
	</tbody>
</table>

<?
include("includes/footer.php");
?>