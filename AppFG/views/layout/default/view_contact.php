<!--Banner Start-->
<div class="banner-slider"
     style="background-image: url(<?php echo base_url(); ?>public/uploads/<?php echo $setting['banner_contact']; ?>)">
    <div class="bg"></div>
    <div class="bannder-table">
        <div class="banner-text">
            <h1>Homepage / <?php echo $page_contact['contact_heading']; ?></h1>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Contact Start-->
<div class="contact-area pt_60 pb_90">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-md-6">
                <div class="contact-item flex">
                    <div class="contact-icon">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                    <div class="contact-text">
                        <h4><?php echo ADDRESS; ?></h4>
                        <p>
                            <?php echo nl2br($page_contact['contact_address']); ?>
                        </p>
                    </div>
                </div>

                <div class="contact-item flex">
                    <div class="contact-icon">
                        <i class="fas fa-mobile" aria-hidden="true"></i>
                    </div>
                    <div class="contact-text">
                        <h4><?php echo PHONE_NUMBER; ?></h4>
                        <p>
                            <?php echo nl2br($page_contact['contact_phone']); ?>
                        </p>
                    </div>
                </div>

                <div class="contact-item flex">
                    <div class="contact-icon">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="contact-text">
                        <h4><?php echo EMAIL_ADDRESS; ?></h4>
                        <p>
                            <?php echo nl2br($page_contact['contact_email']); ?>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-xl-6 col-md-6">
                <!--Map Start-->
                <div class="map-area">
                    <?php echo $page_contact['contact_map']; ?>
                </div>
                <!--Map End-->
            </div>

        </div>

    </div>
</div>
<!--Contact End-->

