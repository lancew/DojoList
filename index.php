<?php
require_once 'lib/limonade.php';

layout('default_layout.php');

// main controller
dispatch('/', 'main_page');

dispatch_get   ('/admin',          'admin_index');

dispatch_get   ('/admin/create',   'admin_create');
dispatch_post  ('/admin/create',   'admin_create_add');

dispatch_get   ('/admin/delete',   'admin_delete');
dispatch('/admin/delete/:dojo', 'admin_delete_end');
run();