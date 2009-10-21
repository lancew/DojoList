<?php
require_once 'lib/limonade.php';

function configure()
{
	option('base_uri', '/'); # '/' or same as the RewriteBase in your .htaccess


}


layout('default_layout.php');

// main controller
dispatch('/', 'main_page');

dispatch_get   ('/admin',          'admin_index');
dispatch_get   ('/html',           'html_list');

dispatch_get   ('/admin/create',   'admin_create');
dispatch_post  ('/admin/create',   'admin_create_add');

dispatch_get   ('/admin/delete',   'admin_delete');
dispatch('/admin/delete/:dojo', 'admin_delete_end');

dispatch_get   ('/admin/createkml',   'admin_create_kml');
dispatch_get   ('/admin/createhtml',   'admin_create_html');
run();