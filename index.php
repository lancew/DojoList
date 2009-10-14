<?php
require_once 'lib/limonade.php';

layout('default_layout.php');

// main controller
dispatch('/', 'main_page');

dispatch_get   ('/admin',          'admin_index');
dispatch_get   ('/admin/create',   'admin_create');
dispatch_post  ('/admin/create',   'admin_create_add');

run();