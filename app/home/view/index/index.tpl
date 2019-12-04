{include file="index/head.tpl"}
<body>
<div id="awd-site-wrap" class="bg bg-home">

<div id="bg">
    <div id="overlay">
        <div class="awd-site-bg bg-home"></div>
        <div class="awd-site-bg bg-services"></div>
        <div class="awd-site-bg bg-about"></div>
        <!-- <div class="awd-site-bg bg-contact"></div> -->
        <!-- <div class="awd-site-bg bg-services"></div> -->
    </div>
    <canvas id="awd-site-canvas"></canvas>
</div>

<!-- START SITE HEADER -->
{include file="index/phead.tpl"}
<!-- END SITE HEADER -->

<!-- START MAIN -->
<main id="awd-site-main">
<!-- START SECTION -->
<section id="awd-site-content">
<div class="sections-block">
<div class="slides">

<div class="slides-wrap">
<!-- HOME SECTION -->
{include file="index/section_home.tpl"}

<!-- SUBSCRIBE SECTION -->
{*include file="index/section_subscribe.tpl"*}

<!-- ABOUT SECTION -->
{include file="index/section_about.tpl"}

<!-- SERVICES SECTION -->
{*include file="index/section_service.tpl"*}

<!-- CONTACT SECTION -->
{*include file="index/section_contact.tpl"*}

</div>
</div>
</div>
</section>
<!-- END SECTION -->
</main>
<!-- END MAIN -->


{include file="index/footer.tpl"}