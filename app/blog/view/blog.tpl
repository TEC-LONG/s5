{include file="common/head.tpl"}
<body>

	<!-- navbar -->
	<div class="navbar">
		<div class="container">
			<div class="panel-control-left">
				<a href="#" data-activates="slide-out-left" class="sidenav-control"><i class="fa fa-bars"></i></a>
			</div>
			<div class="site-title">
				<a href="index.html" class="logo"><h1>Thabt</h1></a>
			</div>
			<div class="panel-control-right">
				<a href="contact.html"><i class="fa fa-envelope-o"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar -->

	<!-- panel control -->
	<div class="panel-control-left">
		<ul id="slide-out-left" class="side-nav collapsible"  data-collapsible="accordion">
			<li>
				<div class="photos">
					<img src="{$smarty.const.PUB_FRONT_IMG}/photos.png" alt="">
					<h3>Mario Doe</h3>
				</div>
			</li>
			<li class="first-list">
				<div class="collapsible-header"><i class="fa fa-home"></i>Home <span><i class="fa fa-chevron-right"></i></span></div>
				<div class="collapsible-body">
					<ul class="side-nav-panel">
						<li><a href="index.html">Home</a></li>
						<li><a href="home-store.html">Home Shop</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><i class="fa fa-shopping-bag"></i>Shop <span><i class="fa fa-chevron-right"></i></span></div>
				<div class="collapsible-body">
					<ul class="side-nav-panel">
						<li><a href="home-store.html">Home</a></li>
						<li><a href="product-details.html">Product Details</a></li>
						<li><a href="shopping-cart.html">Shopping Cart</a></li>
						<li><a href="checkout.html">Checkout</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><i class="fa fa-rss"></i>Blog <span><i class="fa fa-chevron-right"></i></span></div>
				<div class="collapsible-body">
					<ul class="side-nav-panel">
						<li><a href="blog.html">Blog</a></li>
						<li><a href="blog-single.html">Blog Single</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><i class="fa fa-support"></i>Components <span><i class="fa fa-chevron-right"></i></span></div>
				<div class="collapsible-body">
					<ul class="side-nav-panel">
						<li><a href="accordion.html">Accordion</a></li>
						<li><a href="calendar.html">Calendar</a></li>
						<li><a href="login.html">Login</a></li>
						<li><a href="register.html">Register</a></li>
						<li><a href="reset-password.html">Reset Password</a></li>
						<li><a href="setting.html">Settings</a></li>
						<li><a href="collapsible.html">Collapsible</a></li>
						<li><a href="modals.html">Modals</a></li>
						<li><a href="table.html">Table</a></li>
						<li><a href="tabs.html">Tabs</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><i class="fa fa-file-powerpoint-o"></i>Pages <span><i class="fa fa-chevron-right"></i></span></div>
				<div class="collapsible-body">
					<ul class="side-nav-panel">
						<li><a href="about.html">About Us</a></li>
						<li><a href="404.html">404 Page</a></li>
						<li><a href="faq.html">Faq</a></li>
						<li><a href="team.html">Team</a></li>
						<li><a href="pricing.html">Pricing</a></li>
						<li><a href="contact.html">Contact</a></li>
						<li><a href="gallery2.html">Gallery</a></li>
						<li><a href="portfolio2.html">Portfolio</a></li>
						<li><a href="testimonial.html">Testimonial</a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="contact.html"><i class="fa fa-envelope"></i>Contact Us</a>
			</li>
			<li>
				<a href="login.html"><i class="fa fa-sign-in"></i>Login</a>
			</li>
			<li>
				<a href="register.html"><i class="fa fa-user-plus"></i>Register</a>
			</li>
		</ul>
	</div>
	<!-- end panel control -->
	
	<!-- blog -->
	<div class="blog app-pages app-section">
		<div class="container">
			<div class="entry">
				<img src="{$smarty.const.PUB_FRONT_IMG}/blog2.jpg" alt="">
				<div class="user-date">
					<ul>
						<li><a href=""><i class="fa fa-user"></i> Admin</a></li>
						<li><a href=""><i class="fa fa-clock-o"></i> 2017-06-07</a></li>
					</ul>
				</div>
				<div class="content">
					<h5><a href="">Guide to Mastering Blogging</a></h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt nemo tempore itaque voluptates. Temporibus iste, illo eius ex ducimus eligendi animi possimus aliquam excepturi omnis eaque veritatis ad. Atque, quas.</p>
				</div>
			</div>
			<div class="entry">
				<img src="{$smarty.const.PUB_FRONT_IMG}/blog1.jpg" alt="">
				<div class="user-date">
					<ul>
						<li><a href=""><i class="fa fa-user"></i> Admin</a></li>
						<li><a href=""><i class="fa fa-clock-o"></i> 2017-06-07</a></li>
					</ul>
				</div>
				<div class="content">
					<h5><a href="">Guide to Mastering Blogging</a></h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt nemo tempore itaque voluptates. Temporibus iste, illo eius ex ducimus eligendi animi possimus aliquam excepturi omnis eaque veritatis ad. Atque, quas.</p>
				</div>
			</div>
			<div class="entry">
				<img src="{$smarty.const.PUB_FRONT_IMG}/blog3.jpg" alt="">
				<div class="user-date">
					<ul>
						<li><a href=""><i class="fa fa-user"></i> Admin</a></li>
						<li><a href=""><i class="fa fa-clock-o"></i> 2017-06-07</a></li>
					</ul>
				</div>
				<div class="content">
					<h5><a href="">Guide to Mastering Blogging</a></h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt nemo tempore itaque voluptates. Temporibus iste, illo eius ex ducimus eligendi animi possimus aliquam excepturi omnis eaque veritatis ad. Atque, quas.</p>
				</div>
			</div>
			<div class="pagination">
				<ul>
					<li><a href="">First</a></li>
					<li class="active"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li><a href="">Last</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end blog -->
	
{include file="common/footer.tpl"}
