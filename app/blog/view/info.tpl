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
	
	<!-- blog single-->
	<div class="blog-single app-pages app-section">
		<div class="container">
			<div class="entry">
				<img src="{$smarty.const.PUB_FRONT_IMG}/blog2.jpg" alt="">
				<div class="user-date">
					<ul>
						<li><a href=""><i class="fa fa-user"></i> Admin</a></li>
						<li><a href=""><i class="fa fa-clock-o"></i> 2017-06-07</a></li>
					</ul>
				</div>
				<h5>Guide to Mastering Blogging</h5>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt nemo tempore itaque voluptates. Temporibus iste, illo eius ex ducimus eligendi animi possimus aliquam excepturi omnis eaque veritatis ad. Atque, quas Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio ipsum deleniti nesciunt perferendis dolore voluptatibus soluta ipsam quibusdam velit dignissimos dolores officia maiores ex placeat, ipsa quae est asperiores iste! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel beatae iste doloremque doloribus neque quia. Quasi, ad, optio necessitatibus nesciunt officia perspiciatis non molestias odio a soluta reiciendis, eius incidunt?</p>
				<div class="share">
					<ul>
						<li><h6>Share via :</h6></li>
						<li><a href=""><i class="fa fa-facebook-square"></i></a></li>
						<li><a href=""><i class="fa fa-twitter-square"></i></a></li>
						<li><a href=""><i class="fa fa-google-plus-square"></i></a></li>
						<li><a href=""><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
				<div class="author">
					<img src="{$smarty.const.PUB_FRONT_IMG}/author.png" alt="">
					<div class="entry">
						<strong><a href="">John Doe</a></strong>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing</p>
						<ul>
							<li><a href=""><i class="fa fa-facebook-square"></i></a></li>
							<li><a href=""><i class="fa fa-twitter-square"></i></a></li>
							<li><a href=""><i class="fa fa-google-plus-square"></i></a></li>
							<li><a href=""><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="comment">
					<h6>2 Comment</h6>
					<div class="content">
						<img src="{$smarty.const.PUB_FRONT_IMG}/comment1.png" alt="">
						<div class="entry">
							<strong><a href="">John Doe</a></strong>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing</p>
						</div>
					</div>
					<div class="content">
						<img src="{$smarty.const.PUB_FRONT_IMG}/comment2.png" alt="">
						<div class="entry">
							<strong><a href="">John Doe</a></strong>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing</p>
						</div>
					</div>
				</div>
				<div class="post-comment">
					<h6>Leave a Reply</h6>
					<div class="content">
						<form action="#">
							<div class="input-field">
								<input id="name" type="text" class="validate" placeholder="Name">
							</div>
							<div class="input-field">
								<input id="email" type="email" class="validate" placeholder="Email">
							</div>
							<div class="input-field">
								<input id="website" type="text" class="validate" placeholder="Website">
							</div>
							<div class="input-field">
								<textarea cols="20" rows="10" id="comment" class="validate" placeholder="Comments"></textarea>
							</div>
							<button class="button">Post Comment</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end blog single -->
	
	<!-- footer -->
	<footer>
		<div class="container">
			<h6>Find & follow us</h6>
			<ul class="icon-social">
				<li class="facebook"><a href=""><i class="fa fa-facebook"></i></a></li>
				<li class="twitter"><a href=""><i class="fa fa-twitter"></i></a></li>
				<li class="google"><a href=""><i class="fa fa-google"></i></a></li>
				<li class="instagram"><a href=""><i class="fa fa-instagram"></i></a></li>
				<li class="rss"><a href=""><i class="fa fa-rss"></i></a></li>
			</ul>
			<div class="tel-fax-mail">
				<ul>
					<li><span>Tel:</span> 900000002</li>
					<li><span>Fax:</span> 0400000098</li>
					<li><span>Email:</span> info@youremail.com</li>
				</ul>
			</div>
		</div>
		<div class="ft-bottom">
			<span>Copyright (c) 2018 All Rights <a href="http://www.jq22.com/">Reserved</a> </span>
		</div>
	</footer>
	<!-- end footer -->
	
{include file="common/footer.tpl"}