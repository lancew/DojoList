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
  
  

function configure()
{
	option('base_uri', '/'); 	# '/' or same as the RewriteBase in your .htaccess
								# comment out the above line if you don't have the .htaccess file and rewrite setup.
	option('version', '0.1.0'); #DojoList version.
	option('GoogleKey','ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww');
	
	
	option('limonade_dir',       file_path('lib'));
  	option('limonade_views_dir', file_path('lib', 'limonade', 'views'));
  	option('limonade_public_dir',file_path('lib', 'limonade','public'));
  	option('public_dir',         file_path('public'));
  	option('views_dir',          file_path('views'));
  	option('controllers_dir',    file_path('controllers'));
  	option('lib_dir',            file_path('lib'));
	
	option('password',			 'passw0rd');
}



 

layout('default_layout.php');

// main controller
dispatch	   ('/', 'main_page');

dispatch	   ('/admin',          'admin_index');
dispatch_get   ('/admin/login',	   'admin_index');
dispatch_post  ('/admin/login',	   'admin_login');
dispatch	   ('/admin/logout',   'admin_logout');

dispatch_get   ('/html',           'html_list');

dispatch_get   ('/admin/create',   'admin_create');
dispatch_post  ('/admin/create',   'admin_create_add');

dispatch_get   ('/admin/delete',   'admin_delete');
dispatch	   ('/admin/delete/:dojo', 'admin_delete_end');


dispatch_get   ('/admin/edit',   'admin_edit');
dispatch	   ('/admin/edit/:dojo', 'admin_editform');
dispatch_post  ('/admin/edit/:dojo', 'admin_editform_end');


dispatch_get   ('/admin/createkml',   'admin_create_kml');
dispatch_get   ('/admin/createhtml',   'admin_create_html');
run();