<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Splendid
Description: A two-column, fixed-width design for 1024x768 screen resolutions.
Version    : 1.0
Released   : 20090622

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<!-- ======================================================================= -->
<!-- This is a simple Dojo listing app for Judo and other arts.
    Copyright (C) 2009  Lance Wicks

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.   -->
<!-- ============================================================================= -->



	<meta name="author" content="Lance Wicks" />
	<meta name="designer" content="Lance Wicks" />
	<meta name="developer" content="Lance Wicks" />
	<meta name="description" content="Example output page" />
	<meta name="keywords" content="Dojo List" />
	<title>Dojo Listing</title>
	<script src="<?php echo option('app_path') ?>/js/cufon/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php echo option('app_path') ?>/js/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
	<link href="<?php echo option('app_path') ?>/css/reset.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo option('app_path') ?>/css/style.css" media="screen" rel="stylesheet" type="text/css" />
	
		
</head>
<body>
<div id="wrapper">
<div id="logo">
		<h1><a href="#">DojoList</a></h1>
		<p><em> A free Open Source Dojo Listing system for Judo (and other martial art) clubs.</em></p>
	</div>
	<hr />
	<!-- end #logo -->
	<div id="header">
		<div id="menu">
			<ul>
				<li><a href="<?=url_for('/')?>">Home</a></li>
				<li><a href="<?=url_for('html')?>">List of Dojo</a></li>
				<li><a href="<?php echo option('app_path') ?>/data/dojo.kml">KML</a></li>
				<li><a href="<?php echo option('app_path') ?>/data/dojo.xml">XML</a></li>
				


			</ul>
		</div>
		<!-- end #menu -->
		<div id="search">
			<form method="get" action="">
				<fieldset>
				<input type="text" name="s" id="search-text" size="15" value="Search not yet working" />
				<input type="submit" id="search-submit" value="GO" />
				</fieldset>
			</form>
		</div>
		<!-- end #search -->
	</div>
	<!-- end #header -->
	<!-- end #header-wrapper -->
	<div id="page">
	<div id="page-bgtop">
	<div id="content">
		



    <?= $content; ?>
    
    
    
    
    
    
    

</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				<li><img src="<?php echo option('app_path') ?>/images/beta.jpg" alt="beta" width="98" height="100"/></li>
				<li>
					<h2>Menu</h2>
					<ul>
						<li><a href="<?=url_for('/')?>">Home</a></li>
						<li><a href="<?=url_for('html')?>">List of Dojo</a></li>
						<li><a href="<?php echo option('app_path') ?>/data/dojo.kml">KML</a></li>
						<li><a href="<?=url_for('admin')?>">Admin Interface</a></li>
						<?php
							if(isset($_COOKIE["user"])) {
								print('<li><a href="'.url_for('admin','logout').'">[LOGOUT]</a></li>');
							}
						?>
						
					</ul>
				</li>

				<li>
					<h2>DojoList</h2>
					
					<p>DojoList is an open source project by Lance Wicks. The project aims to provide a system to make it easy for a association to maintain a list of Judo clubs.</p>
					<p>The project is hosted at <a href="http://github.com/lancew/DojoList">http://github.com/lancew/DojoList</a> where you can access all the source code, record bugs, etc.</p>
					<p>This project has been built on the <a href="http://sofa-design.net/limonade/" title="Limonade PHP micro-framework">Limonade PHP micro-framework</a> and the <a href="http://jquery.com/">jquery</a> and <a href="http://www.mapstraction.com/">mapstraction</a> javascript libraries.</p>
					<p>The DojoList project is licensed under a <a href="<?php echo option('app_path') ?>agpl-3.0.txt">AGPL license.<br /><img src="<?php echo option('app_path') ?>/images/agplv3-88x31.png" alt="agplv3-88x31" width="88" height="31"/></a></p>	
					<p><script type="text/javascript" src="http://www.ohloh.net/p/459913/widgets/project_thin_badge.js"></script></p>
					
				</li>
				<li>
				<h2>Copyright</h2>
				<p>&copy;2009, Lance Wicks. Web layout from <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.
				</li>
			</ul>
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer">
	<p>DojoList v.<?php echo option('version');?></p>
		
		
	
	
	
	</div>
	<!-- end #footer -->
</div>

	
	</body>
</html>	
	