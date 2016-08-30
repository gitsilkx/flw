
  
		<table width="262" border="0" cellspacing="0" cellpadding="0">
        	
				<?php
				if($_SESSION['user_id'])
				{
					
				?>
				<tr>
				<td >
					<table width="262" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td align="left" valign="middle" class="bx_top"><span class="bx_top_text">My Account</span></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" class="bx_repeat" style='padding-left:20px'>
                        <!--[if lte IE 7]>
                        <style type='text/css'>
                         .account{
                            font-weight:bold;
                            font-size:11px;
                            color:#666;
                            margin-left:25px;
                        }
                        </style>
                        <![endif]-->
						<table width="90%" border="0" cellspacing="0" cellpadding="4">
							<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=profile" title="My Profile" class=link><strong>My Profile</strong></a></td></tr>
							<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=select.expertise" title="Update area(s) of expertise" class=link><strong>Update area(s) of expertise </strong></a></td></tr>
							<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=my.jobs" title="My Posted Jobs" class=link><strong>My Posted Jobs</strong></a></td></tr>
														<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=my.bids" title="Jobs I bid on" class=link><strong>Jobs I bid on</strong></a></td></tr>
							<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=site-list" title="My Websites" class=link><strong>My Websites</strong></a></td></tr>
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=domain-list" title="My Domains" class=link><strong>My Domains</strong></a></td></tr>
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=watchlist-list" title="My Watch List" class=link><strong>My Watch List</strong></a></td></tr>
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=messages" title="My Messages" class=link><strong>My Messages</strong> (<?=$pqn?>)</a></td></tr>
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=advance-search" title="Advanced Search" class=link><strong>Advanced Search</strong></a></td></tr>
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=savedsearches" title="My Saved Searches" class=link><strong>My Saved Searches</strong></a></td></tr>							
								<tr><td style='border-bottom:solid 1px silver'>&raquo; <a href="index.php?mode=sell-your-site" title="Sell a Website" class=link><strong>Sell a Website</strong></a></td></tr>
								<tr><td >&raquo; <a href="index.php?mode=sell-your-domain" title="Sell a Domain" class=link><strong>Sell a Domain</strong></a></td></tr>
								
							</table>
						</td>
					  </tr>
					  <tr>
						<td align="left" valign="top"><img src="images/bx-bottom.jpg" alt="image" width="262" height="12" /></td>
					  </tr>
					</table>
				</td>
				</tr>
				<?php
				}
				else
				{
				?>
          		<tr>
            		<td align="left" valign="top"><a href="register.php" title="Register"><img src="images/right_link_image.jpg" alt="Register" width="262" height="149" vspace="5" border="0" /></a></td>
          		</tr>
          		<tr>
            		<td align="left" valign="top"><a href="valuation.php" title="Valuation Tool"><img src="images/right_link_image-2.jpg" alt="Valuation Tool" width="262" height="54" border="0" /></a></td>
          		</tr>
				<?php
				}
				?>
				<tr><td>&nbsp;</td></tr>
				<?php
				if($_SESSION['user_id']!="")
				{
				?>
				<?php /*?><tr ><td bgcolor="#D8ECEC" align="center" height="25">
				<script language="javascript" type="text/javascript">
				var PDF_surveyID = 'A1F76819F9FA38AE';
				 var PDF_openText = 'Send us your feedback';
				</script>
				<script type="text/javascript" language="javascript" src="http://www.polldaddy.com/s.js"></script>
				<noscript><a href="http://surveys.polldaddy.com/s/A1F76819F9FA38AE/">Send us your feedback</a></noscript></td></tr> 
				<tr><td>&nbsp;</td></tr> <?php */?>
				<?php
				}
				?>
				<!--Start articles -->    
          
				<!--End articles-->
				<!--start announcement-->
				<tr>
            		<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
              				<tr>
                				<td align="left" valign="top" class="latest_news_text">Announcements</td>
              				</tr>
							<?php
							$da1=mysql_query("select * from ".$prev."announcement where status='Y' order by date desc limit 0,5");
							if(@mysql_num_rows($da1))
							{
								while($da=@mysql_fetch_array($da1))
								{
								?>
								<tr>
									<td align="left" valign="top" class="news_dotted_line"><img src="images/x.gif" width="1" height="10" /></td>
								</tr>
								<tr>
									<td align="left" valign="top" class="latest_news_text2">									
									<span class="article_title">
									
									</span>
									<b><a href="index.php?mode=announcement-details&id=<?=$da['id']?>" class="lnk2"><?=$da['title']?></a></b>
									<br/><br/>
									<?=substr($da['announcement'],0,100)?>... <a href="index.php?mode=announcement-details&id=<?=$da['id']?>" class="latest_news_text2"><b>more</b></a></td>
								</tr>
								<tr>
									<td><img src="images/x.gif" width="1" height="10" alt="" /></td>
								</tr>
								<?php
								}
							}
							else
							{
							?>
							<tr>
							<td align="left" valign="top" class="news_dotted_line"><img src="images/x.gif" width="1" alt="" height="10" /></td>
							</tr>
              				<tr>
                			<td align="left" valign="top" class="latest_news_text2">Coming Soon</td>
             				 </tr>
							 <tr>
                				<td><img src="images/x.gif" width="1" height="10" alt="" /></td>
              				</tr>
							<?php
							}
							?>
            			</table>
					</td>
          		</tr>
				<!--End announcement-->
				
          		<?php /*?><tr>
            		<td align="right" valign="top"><a href="articles.php" title="More Articles"><img src="images/read_more.jpg" border="0" alt="More Articles" width="74" height="15" /></a></td>
          		</tr><?php */?>
        	</table>
	
<!--body content end here-->