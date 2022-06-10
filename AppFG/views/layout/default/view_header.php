<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$error_message = '';
$success_message = '';
?>
<!DOCTYPE html>
<html class="no-js" lang="de">
<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="1 days">

    <?php

    $CI =& get_instance();
    $CI->load->model('Model_common');

    $language = $CI->Model_common->get_language_data();

    foreach ($language as $lang) {
        define($lang['name'], $lang['value']);
    }

    $class_name = '';
    $segment_2 = 0;
    $segment_3 = 0;
    $class_name = $this->router->fetch_class();
    $segment_2 = $this->uri->segment('2');
    $segment_3 = $this->uri->segment('3');

    if($class_name == 'home')
    {
        echo '<meta name="description" content="'.$page_home['meta_description'].'">';
        echo '<meta name="keywords" content="'.$page_home['meta_keyword'].'">';
        echo '<title>'.$page_home['title'].'</title>';
    }
    if($class_name == 'about')
    {
        echo '<meta name="description" content="'.$page_about['md_about'].'">';
        echo '<meta name="keywords" content="'.$page_about['mk_about'].'">';
        echo '<title>'.$page_about['mt_about'].'</title>';
    }
    if($class_name == 'impressum')
    {
        echo '<meta name="description" content="'.$page_impressum['md_impressum'].'">';
        echo '<meta name="keywords" content="'.$page_impressum['mk_impressum'].'">';
        echo '<title>'.$page_impressum['mt_impressum'].'</title>';
    }
    if($class_name == 'datenschutz')
    {
        echo '<meta name="description" content="'.$page_datenschutz['md_datenschutz'].'">';
        echo '<meta name="keywords" content="'.$page_datenschutz['mk_datenschutz'].'">';
        echo '<title>'.$page_datenschutz['mt_datenschutz'].'</title>';
    }
    if($class_name == 'faq')
    {
        echo '<meta name="description" content="'.$page_faq['md_faq'].'">';
        echo '<meta name="keywords" content="'.$page_faq['mk_faq'].'">';
        echo '<title>'.$page_faq['mt_faq'].'</title>';
    }
    if($class_name == 'team')
    {
        echo '<meta name="description" content="'.$page_team['md_team'].'">';
        echo '<meta name="keywords" content="'.$page_team['mk_team'].'">';
        echo '<title>'.$page_team['mt_team'].'</title>';
    }
    if($class_name == 'team_member')
    {
        $single_team_member = $this->Model_team_member->team_member_detail($segment_2);
        echo '<meta name="description" content="'.$single_team_member['meta_description'].'">';
        echo '<meta name="keywords" content="'.$single_team_member['meta_keyword'].'">';
        echo '<title>'.$single_team_member['meta_title'].'</title>';
    }
    if($class_name == 'testimonial')
    {
        echo '<meta name="description" content="'.$page_testimonial['md_testimonial'].'">';
        echo '<meta name="keywords" content="'.$page_testimonial['mk_testimonial'].'">';
        echo '<title>'.$page_testimonial['mt_testimonial'].'</title>';
    }
    if($class_name == 'contact')
    {
        echo '<meta name="description" content="'.$page_contact['md_contact'].'">';
        echo '<meta name="keywords" content="'.$page_contact['mk_contact'].'">';
        echo '<title>'.$page_contact['mt_contact'].'</title>';
    }
    if($class_name == 'search')
    {
        echo '<meta name="description" content="'.$page_search['md_search'].'">';
        echo '<meta name="keywords" content="'.$page_search['mk_search'].'">';
        echo '<title>'.$page_search['mt_search'].'</title>';
    }
    if($class_name == 'terms-and-conditions')
    {
        echo '<meta name="description" content="'.$page_term['md_term'].'">';
        echo '<meta name="keywords" content="'.$page_term['mk_term'].'">';
        echo '<title>'.$page_term['mt_term'].'</title>';
    }
    if($class_name == 'privacy-policy')
    {
        echo '<meta name="description" content="'.$page_privacy['md_privacy'].'">';
        echo '<meta name="keywords" content="'.$page_privacy['mk_privacy'].'">';
        echo '<title>'.$page_privacy['mt_privacy'].'</title>';
    }
    if($class_name == 'pricing')
    {
        echo '<meta name="description" content="'.$page_pricing['md_pricing'].'">';
        echo '<meta name="keywords" content="'.$page_pricing['mk_pricing'].'">';
        echo '<title>'.$page_pricing['mt_pricing'].'</title>';
    }
    if($class_name == 'photo_gallery')
    {
        echo '<meta name="description" content="'.$page_photo_gallery['md_photo_gallery'].'">';
        echo '<meta name="keywords" content="'.$page_photo_gallery['mk_photo_gallery'].'">';
        echo '<title>'.$page_photo_gallery['mt_photo_gallery'].'</title>';
    }
    if($class_name == 'service')
    {
        if($segment_3 == 0) {
            echo '<meta name="description" content="'.$page_service['md_service'].'">';
            echo '<meta name="keywords" content="'.$page_service['mk_service'].'">';
            echo '<title>'.$page_service['mt_service'].'</title>';  
        } else {
            $single_service = $this->Model_service->service_detail($segment_3);
            echo '<meta name="description" content="'.$single_service['meta_description'].'">';
            echo '<meta name="keywords" content="'.$single_service['meta_keyword'].'">';
            echo '<title>'.$single_service['meta_title'].'</title>';
        }       
    }
    if($class_name == 'category')
    {
        $single_category = $this->Model_category->category_by_id($segment_2);
        echo '<meta name="description" content="'.$single_category['meta_description'].'">';
        echo '<meta name="keywords" content="'.$single_category['meta_keyword'].'">';
        echo '<title>'.$single_category['meta_title'].'</title>';     
    }
    if($class_name == 'news')
    {
        if($segment_3 == 0) {
            echo '<meta name="description" content="'.$page_news['md_news'].'">';
            echo '<meta name="keywords" content="'.$page_news['mk_news'].'">';
            echo '<title>'.$page_news['mt_news'].'</title>';
        } else {
            $news_single_item = $this->Model_news->news_detail($segment_3);
            echo '<meta name="description" content="'.$news_single_item['meta_description'].'">';
            echo '<meta name="keywords" content="'.$news_single_item['meta_keyword'].'">';
            echo '<title>'.$news_single_item['meta_title'].'</title>';
            $og_id = $news_single_item['news_id'];
            $og_photo = $news_single_item['photo'];
            $og_title = $news_single_item['news_title'];
            $og_description = $news_single_item['news_content_short'];
            echo '<meta property="og:title" content="'.$og_title.'">';
            echo '<meta property="og:type" content="website">';
            echo '<meta property="og:url" content="'.base_url().'news/view/'.$og_id.'">';
            echo '<meta property="og:description" content="'.$og_description.'">';
            echo '<meta property="og:image" content="'.base_url().'public/uploads/'.$og_photo.'">';
        }
    }
    if($class_name == 'event')
    {
        if($segment_3 == 0) {
            echo '<meta name="description" content="'.$page_event['md_event'].'">';
            echo '<meta name="keywords" content="'.$page_event['mk_event'].'">';
            echo '<title>'.$page_event['mt_event'].'</title>';
        } else {
            $event_single_item = $this->Model_event->event_detail($segment_3);
            echo '<meta name="description" content="'.$event_single_item['meta_description'].'">';
            echo '<meta name="keywords" content="'.$event_single_item['meta_keyword'].'">';
            echo '<title>'.$event_single_item['meta_title'].'</title>';
            $og_id = $event_single_item['event_id'];
            $og_photo = $event_single_item['photo'];
            $og_title = $event_single_item['event_title'];
            $og_description = $event_single_item['event_content_short'];
            echo '<meta property="og:title" content="'.$og_title.'">';
            echo '<meta property="og:type" content="website">';
            echo '<meta property="og:url" content="'.base_url().'event/view/'.$og_id.'">';
            echo '<meta property="og:description" content="'.$og_description.'">';
            echo '<meta property="og:image" content="'.base_url().'public/uploads/'.$og_photo.'">';
        }
    }
    ?>

<!-- Favicon -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700%7CPoppins:200,300,400,500,600,700,800%7CPlayfair+Display:400,700,900&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/theme.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/theme-elements.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/theme-blog.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/theme-shop.css">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/demos/demo-barber.css">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/skins/skin-barber.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/css/custom.css">

		<!-- Head Libs -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/modernizr/modernizr.min.js"></script>
</head>

<body data-plugin-scroll-spy data-plugin-options="{'target': '#header'}">

        <div class="body">
            <header id="header" class="header-transparent header-transparent-dark-bottom-border header-transparent-dark-bottom-border-1 header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
                <div class="header-body border-top-0 bg-dark box-shadow-none">
                    <div class="header-container container">
                        <div class="header-row">
                            <div class="header-column">
                                <div class="header-row">
                                    <h1 class="font-weight-semibold text-7 mb-0">
                                        <a href="" class="text-decoration-none custom-primary-font" style="color:#e5bd68">
                                        SCHAHHAIRDESIGN
                                        </a>
                                    </h1>
                                </div>
                            </div>
                            <div class="header-column">
                                <div class="header-row justify-content-end">
                                    <div class="header-nav header-nav-links header-nav-dropdowns-dark header-nav-light-text justify-content-center">
                                        <div class="header-nav-main header-nav-main-mobile-dark header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                            <nav class="collapse">
                                                <ul class="nav nav-pills" id="mainNav">
                                                    <li>
                                                        <a data-hash class="dropdown-item active" href="#home">Startseite</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-hash data-hash-offset="0" data-hash-offset-lg="68" href="#aboutus">Über Uns</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-hash data-hash-offset="0" data-hash-offset-lg="68" href="#ourservices">Leistungen</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-hash data-hash-offset="0" data-hash-offset-lg="68" href="#hours">Öffnungszeiten</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-hash data-hash-offset="0" data-hash-offset-lg="68" href="#prices">Preise</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-hash data-hash-offset="0" data-hash-offset-lg="68" href="#footer">Kontakt</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                        	<i class="fas fa-bars"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>