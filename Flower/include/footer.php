<div class="cboth"></div>
<div id="footer">
    <div class="innerWrap">
        <div class="f_newsletter_inner row-fluid">
            <div class="Block NewsletterSubscription Moveable Panel" id="SideNewsletterBox">
                <h6>Sign up for newsletter</h6>
                <form action="<?= $vpath ?>subscribe.php" method="post" id="subscribe_form" name="subscribe_form">
                    <input name="action" value="subscribe" type="hidden"/>
                    <input id="nl_first_name" name="nl_first_name" value="your first name" onfocus="if (this.value == 'enter your full name')
                                this.value = ''" onblur="if (this.value == '')
                                this.value = 'enter your full name'" type="text" />
                    <input id="nl_email" name="nl_email" value="your email address" onfocus="if (this.value == 'your email address')
                                this.value = ''" onblur="if (this.value == '')
                                this.value = 'your email address'" type="text" />
                    <input type="submit" value="Subscribe" name="signup" />
                </form>
            </div>

            <script type="text/javascript">

                        // <!--

                        $('#subscribe_form').submit(function() {

                            if ($('#nl_first_name').val() == '') {

                                alert('You forgot to type in your first name.');

                                $('#nl_first_name').focus();

                                return false;

                            }



                            if ($('#nl_email').val() == '') {

                                alert('You forgot to type in your email address.');

                                $('#nl_email').focus();

                                return false;

                            }



                            if ($('#nl_email').val().indexOf('@') == -1 || $('#nl_email').val().indexOf('.') == -1) {

                                alert('Email address is not valid.');

                                $('#nl_email').focus();

                                $('#nl_email').select();

                                return false;

                            }



                            // Set the action of the form to stop spammers

                            $('#subscribe_form').append("<input type=\"hidden\" name=\"check\" value=\"1\" \/>");

                            return true;



                        });

                        // -->

            </script>



        </div>

        <div class="f_downarea row-fluid">

            <div class="f-navigation">

                <!--<a href="<?= $vpath ?>sitemap/"><span>Sitemap</span></a> |--><ul><li class="f-compArea"><h5>Flowers Delivered In</h5><ul>

                            <li><a href="<?= $vpath ?>local-flowers/atlanta-florists-atlanta-flower-shops-atlanta-flower-delivery-online.htm">Atlanta</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/baltimore-florists-baltimore-flower-shops-baltimore-flower-delivery-online.htm">Baltimore</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/boston-florists-boston-flower-shops-boston-flower-delivery-online.htm">Boston</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/chicago-florists-chicago-flower-shops-chicago-flower-delivery-online.htm">Chicago</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/dallas-florists-dallas-flower-shops-dallas-flower-delivery-online.htm">Dallas</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/denver-florists-denver-flower-shops-denver-flower-delivery-online.htm">Denver</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/houston-florists-houston-flower-shops-houston-flower-delivery-online.htm">Houston</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/la-florists-la-flower-shops-los-angeles-flower-delivery-online.htm">Los Angeles</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/minneapolis-florists-minneapolis-flower-shops-minneapolis-flower-delivery-online.htm">Minneapolis</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/nyc-florists-nyc-flower-shops-nyc-flower-delivery-online-newyork.htm">New York</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/pittsburgh-florists-pittsburgh-flower-shops-pittsburgh-flower-delivery-online.htm">Pittsburgh</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/san-diego-florists-san-diego-flower-shops-san-diego-flower-delivery-online.htm">San Diego</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/san-francisco-florists-san-francisco-flower-shops-san-francisco-flower-delivery-online.htm">San Francisco</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/seattle-florists-seattle-flower-shops-seattle-flower-delivery-online.htm">Seattle</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/st-louis-florists-st-louis-flower-shops-st-louis-flower-delivery-online.htm">St louis</a></li>
                            <li><a href="<?= $vpath ?>local-flowers/tulsa-florists-tulsa-flower-shops-tulsa-flower-delivery-online.htm">Tulsa</a></li>
                            <li><a href="<?= $vpath ?>local-flowers.htm">ANYWHERE IN USA</a></li>
                            <li><a href="<?= $vpath ?>international-flowers/send-flowers-to-canada-from-usa.htm">ANYWHERE IN CANADA</a></li>

                        </ul></li><li class="f-OccasionArea"><h5>Flower Delivery Services</h5><ul>

                            <li><a href="<?= $vpath ?>floral-arrangements-floral-delivery-from-local-florists-and-online-florists.htm">Floral Arrangements</a></li>
                            <li><a href="<?= $vpath ?>send-plants-send-a-plant-delivery-orchid-delivery.htm">Plant Delivery</a></li>
                            <li><a href="<?= $vpath ?>bouquet-of-flowers-flower-bouquets-balloon-bouquets-bouquet-of-roses.htm">Flower Bouquets</a></li>
                            <li><a href="<?= $vpath ?>discount-flowers-flower-deals-flower-coupons-cheap-flowers-free-delivery.htm">Discount Flowers</a></li>
                            <li><a href="<?= $vpath ?>wholesale-flowers-wholesale-roses-bulk-flowers-online.htm">Wholesale Flowers</a></li>
                            <li><a href="<?= $vpath ?>exotic-flowers-and-exotic-plants-for-sale.htm">Exotic Flowers</a></li>
                            <li><a href="<?= $vpath ?>flower-shops-online-flower-stores.htm">Flower Shops</a></li>
                            <li><a href="<?= $vpath ?>order-flowers-online-for-delivery-where-to-buy-flowers-online.htm">Order Flowers</a></li>
                            
                            </ul>
			    <h5>Sympathy Flowers</h5><ul>

                            <li><a href="<?= $vpath ?>sympathy-flowers-delivery-sympathy-gift-baskets.htm">Sympathy</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers-for-funeral-flower-arrangements.htm">Funerals</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers/funeral-casket-sprays-funeral-casket-flowers.htm">Casket Flowers</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers/funeral-baskets-funeral-gift-baskets-bereavement-gift-baskets.htm">Gift Baskets</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers/popular-funeral-plants-for-funerals.htm">Plants</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers/cheap-funeral-sprays-flower-sprays-funeral-standing-sprays.htm">Sprays</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers/cheap-funeral-wreaths-for-funerals.htm">Wreaths</a></li>

                        </ul></li>

                    <li class="f-FlowerTypeArea"><h5>Flowers by Occassion</h5><ul>

                            <li><a href="<?= $vpath ?>wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm">Anniversaries</a></li>
                            <li><a href="<?= $vpath ?>birthday-flowers-birthday-gifts-for-mom-birthday-delivery-ideas.htm">Birthdays</a></li>
                            <li><a href="<?= $vpath ?>get-well-gift-baskets-get-well-flowers-online.htm">Get Well</a></li>
                            <li><a href="<?= $vpath ?>funeral-flowers-for-funeral-flower-arrangements.htm">Funerals</a></li>
                            <li><a href="<?= $vpath ?>flower-of-love-flowers-romantic-flowers-for-you.htm">Love &amp; Romance</a></li>
                            <li><a href="<?= $vpath ?>new-baby-flowers-new-baby-gifts-ideas.htm">New Baby</a></li>
                            <li><a href="<?= $vpath ?>thank-you-flowers-delivery-thank-you-flower-arrangements.htm">Thank You</a></li>
                            <li><a href="<?= $vpath ?>wedding-bouquets-bridal-bouquets-flowers-for-wedding-flowers-online.htm">Weddings</a></li>
                            
                            </ul>
                            <h5>Special Flowers</h5><ul>

                            <li><a href="<?= $vpath ?>christmas-centerpieces-christmas-plants-christmas-flower-arrangements.htm">Christmas</a></li>
                            <li><a href="<?= $vpath ?>easter-flowers-easter-flower-arrangements.htm">Easter</a></li>
                            <li><a href="<?= $vpath ?>mothers-day-gifts-mothers-day-flowers-for-mothers-day.htm">Mothers Day</a></li>
                            <li><a href="<?= $vpath ?>valentines-day-flowers-valentines-flowers-delivery.htm">Valentines Day</a></li>
                            <li><a href="<?= $vpath ?>fresh-flowers.htm">Everyday Fresh</a></li>
                            <li><a href="<?= $vpath ?>fresh-flowers/cheap-roses-a-dozen-roses-buy-roses-delivery-online.htm">All Occassion Roses</a></li>
                            <li><a href="<?= $vpath ?>cheap-centerpiece-ideas-flower-centerpieces-dining-table-centerpieces-floating-candle-centerpieces.htm">Garden Fresh Centerpieces</a></li>




                        </ul></li><li class="f-ExpressYourselfArea"><h5>More Information</h5><ul>

                            <li><a href="<?= $vpath ?>" >Home</a></li>
                            <li><a href="<?= $vpath ?>about.htm" rel="nofollow">About Us</a></li>
                            <li><a href="<?= $vpath; ?>contact.htm">Contact Us</a></li>
                            <li><a href="<?= $vpath ?>same-day-flower-delivery-same-day-flowers-today.htm" rel="nofollow">About Same Day</a></li>
                            <li><a href="<?= $vpath ?>next-day-flower-delivery-next-day-flowers-tomorrow.htm" rel="nofollow">About Next Day</a></li>
                            <li><a href="<?= $vpath ?>tandc.htm" rel="nofollow">Terms and Conditions</a></li>
                            <li><a href="<?= $vpath ?>privacy.htm" rel="nofollow">Privacy Policy</a></li>
                            <li><a href="<?= $vpath ?>sitemap.xml">Sitemap</a></li>
                        </ul></li>
                        <li class="f-ExpressYourselfArea">
            <div class="logo_area_footer">

                        <div class="f_logo">
                            <span class="f_logo_name">Flower WyZ</span>
                        </div>
                        <div class="f_social_icon">
                            <ul>
                                <li style="width:19%"><a href="#" class="fb" ></a></li>
                                <li style="width:19%"><a href="#" class="gplus" ></a></li>
                                <li style="width:19%"><a href="#"  class="insti" ></a></li>
                                <li style="width:19%"><a href="#"  class="pintit" ></a></li>
                                <li style="width:19%"><a href="#"  class="twitter" ></a></li>
                            </ul>
                            <img src="<?php echo $vpath; ?>images/flower-delivery2.png" alt="Send Flower Online" />
                            <img src="<?php echo $vpath; ?>images/buy-online-flower-delivery.png" alt="Online Flower Delivery" style="margin:10px 0px" />
                        </div>
                    </div>
        </li>
                </ul>

                  



            </div>

        </div>

        <div class="f_bottomarea">

            <div class="f-Txt"> <h3><?php echo $footer_content;?></h3>

            </div>

        </div>

    </div>

</div>


</div><!--Wrapper-->

</div><!--Container-->
</body>
</html>