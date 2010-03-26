<?php

// ============ 
// ! DojoList - An open source Dojo listing system created by Lance Wicks.
//    Copyright (C) 2009-2010  Lance Wicks
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




// Specify location of translation tables 
bindtextdomain ("messages", "./locale"); 

// Choose domain 
textdomain ("messages");


require_once 'lib/limonade.php';
  
  

function configure()
{
	#option('base_uri', '/'); 	# '/' or same as the RewriteBase in your .htaccess
								# comment out the above line if you don't have the .htaccess file and rewrite setup.
	option('version', '0.4.0'); #DojoList version.
	option('GoogleKey','ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww');
	/*
	<!-- ========================================================================================================================= -->
    <!-- ! dev.dojolist Google Maps key = ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww   -->
    <!-- ! dojolist.org Google Maps key = ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhSWH-7MkD69eK1mPHwn7eqLiVV0phRL_kf0iV6RCaWfRCpODMqoZH0oxg   -->
    <!-- ========================================================================================================================= -->
	*/

	
	option('limonade_dir',       file_path('lib'));
  	option('limonade_views_dir', file_path('lib', 'limonade', 'views'));
  	option('limonade_public_dir',file_path('lib', 'limonade','public'));
  	option('public_dir',         file_path('public'));
  	option('views_dir',          file_path('views'));
  	option('controllers_dir',    file_path('controllers'));
  	option('lib_dir',            file_path('lib'));
  	
	option('css_dir',			 file_path('css'));
	option('js_dir',			 file_path('js'));
	option('images_dir',		 file_path('images'));
	option('data_dir',		     file_path('data'));
	
	option('recaptcha_public_key',			 '6LcC4wsAAAAAAECY3J0fNlR7zHIAKYfyQljTlvaM');
	option('recaptcha_private_key',			 '6LcC4wsAAAAAACV_1QJcAJpB24bmXi_UpGPPmeRF');
	
	option('password',			 'passw0rd');
}



 

layout('default_layout.php');


// main controller
dispatch	   ('/', 'Main_page');

dispatch_get   ('/dojo/',           'Html_list');

dispatch_get   ('/dojo/create',   'Admin_create');
dispatch_post  ('/dojo/create',   'Admin_Create_add');

// The dojo/create paths have to be above the  view path to work.
dispatch	   ('/dojo/:dojo',          'View');

dispatch_get   ('/dojo/:dojo/delete',   'Admin_Delete');
dispatch_post   ('/dojo/:dojo/delete', 'Admin_Delete_end');

dispatch	   ('/dojo/:dojo/edit', 'Admin_editform');
dispatch_post  ('/dojo/:dojo/edit', 'Admin_Editform_end');

dispatch_get   ('/admin/createkml',   'Admin_Create_kml');
dispatch_get   ('/admin/createhtml',   'Admin_Create_html');

dispatch	   ('/dojo/:dojo/image', 'DojoLogo');

// depreciated paths

dispatch_get   ('/html',           'Html_list');

//dispatch	   ('/admin',          'Admin_index');
//dispatch_get   ('/admin/login',	   'Admin_index');
//dispatch_post  ('/admin/login',	   'Admin_login');
//dispatch	   ('/admin/logout',   'Admin_logout');

//dispatch_get   ('/admin/delete',   'Admin_delete');
//dispatch	   ('/admin/delete/:dojo', 'Admin_Delete_end');

//dispatch_get   ('/admin/edit',   'Admin_edit');
//dispatch	   ('/admin/edit/:dojo', 'Admin_editform');
//dispatch_post  ('/admin/edit/:dojo', 'Admin_Editform_end');

//dispatch	   ('/view/:dojo',          'View');












run();
