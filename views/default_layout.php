<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Lance Wicks" />
	<meta name="designer" content="Lance Wicks" />
	<meta name="developer" content="Lance Wicks" />
	<meta name="description" content="Example output page" />
	<meta name="keywords" content="Dojo List" />
	<title>Dojo Listing</title>
	<script src="<?php echo option('base_path') ?>js/cufon/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php echo option('base_path') ?>js/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
	<link href="<?php echo option('base_path') ?>css/reset.css" media="screen" rel="stylesheet" type="text/css" />
	
	<!-- ========================================================================================================================= -->
    <!-- ! dev.dojolist Google Maps key = ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww   -->
    <!-- ========================================================================================================================= -->

	
	<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww" type="text/javascript"></script>
    <script type="text/javascript" src="js/mapstraction.js"></script>
    <style type="text/css">
      #mapstraction {
        height: 600px;
        width: 600px;
      }
    </style> 
	

	
	
	
</head>

    <?= $content; ?>
 
<p></p> 		
<hr>
<a href="<?=url_for('/')?>">[Home]</a><a href="<?=url_for('admin')?>">[Admin Interface]</a>
<h4>DojoList v.<?php echo option('version');?> - Created by Lance Wicks.<br /><a href="http://github.com/lancew/DojoList">http://github.com/lancew/DojoList</a> </h4>
	<a href="/agpl-3.0.txt"><img src="/images/agplv3-88x31.png" alt="agplv3-88x31" width="88" height="31"/></a>
	<p>Aerated with <a href="http://sofa-design.net/limonade/" title="Limonade PHP micro-framework">Limonade</a></p>
	
	</body>
</html>	
	