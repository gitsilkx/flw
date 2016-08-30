
<form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantOfferValidate(); " >
			<input type="hidden" name="offer_id" id="offer_id" value="<?=$_GET['offer_id']?>"><div class="addPageCont">
					<span class="addPageRightFont">Title<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<INPUT name="subtitle" class="textbox" value="<? echo $data["subtitle"];?>" maxLength=120 style='width:300px'>
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer percentage">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
            
            <div class="addPageCont">
					<span class="addPageRightFont">Website Url<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<INPUT name=url class="textbox" value="<?=$data['link']?>" style='width:300px'
                        maxLength=120>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
            <div class="addPageCont">
					<span class="addPageRightFont">Banner Size<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<select name="size" class="lnk" style='width:300px'>
							<option value="">Select Size</option>
							<option value="790x80" <?php if($data['size']=="790x80") echo "selected='selected'"  ?> >Top</option>
							<option value="250x250" <?php if($data['size']=="250x250") echo "selected='selected'"  ?> >Side Panel</option>
							<option value="200x200" <?php if($data['size']=="200x200") echo "selected='selected'"  ?> >Bottom</option>
					</select>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
            <div class="addPageCont">
					<span class="addPageRightFont">Select Banner Image<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input type="file" name="file" />
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
</div>
<div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input type="radio" class="radiobotton" name="status" id="yes" <?php echo  $selectedy; ?> value="Y"  /><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input type="radio" class="radiobotton" name="status" <?php echo  $selectedn; ?> id="no" value="N"  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one restaurant pickup option">?</div></div>
            </div>
            <div class="buttonCont2">
				<input type="submit" class="button" name="BANNER" value="<?=($_GET['banner_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="banner_entry.php">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
            </form>
            