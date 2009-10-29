<?php

// ============ 
// ! DojoList - An open source Dojo listing system created by Lance Wicks.
//    Copyright (C) 2009  Lance Wicks
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
// ============ 



require_once 'lib/limonade.php';
 ini_set('display_errors', 1);

function before() 
   { 
     restore_error_handler(); 
   } 
   
   

function configure()
{
	option('base_uri', '/'); 	# '/' or same as the RewriteBase in your .htaccess
								# comment out the above line if you don't have the .htaccess file and rewrite setup.
	option('version', '0.0.1'); #DojoList version.
	option('GoogleKey','ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww');
	$app_path = 'http://' . $_SERVER['HTTP_HOST'] . option('base_uri');
	option('app_path', $app_path);
	
	
	
	option('env', ENV_DEVELOPMENT);
}



 

layout('default_layout.php');

// main controller
dispatch	   ('/', 'main_page');

dispatch_get   ('/admin',          'admin_index');
dispatch_get   ('/html',           'html_list');

dispatch_get   ('/admin/create',   'admin_create');
dispatch_post  ('/admin/create',   'admin_create_add');

dispatch_get   ('/admin/delete',   'admin_delete');
dispatch	   ('/admin/delete/:dojo', 'admin_delete_end');

dispatch_get   ('/admin/createkml',   'admin_create_kml');
dispatch_get   ('/admin/createhtml',   'admin_create_html');
run();