#!/bin/bash
set -ev
# Upload models
curl --ftp-create-dirs -T lib/dojo.model.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/lib/
curl --ftp-create-dirs -T lib/data.model.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/lib/
curl --ftp-create-dirs -T lib/judoka.model.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/lib/
# Upload controllers
curl --ftp-create-dirs -T controllers/admin.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/controllers/
curl --ftp-create-dirs -T controllers/api.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/controllers/
curl --ftp-create-dirs -T controllers/main.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/controllers/
curl --ftp-create-dirs -T controllers/dojo.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/controllers/
# Upload Views
curl --ftp-create-dirs -T views/about.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/default_layout.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/emails_list.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/error_layout.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/main.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/main.html_list.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/search_results.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/view.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
curl --ftp-create-dirs -T views/websites_list.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/
# Upload Dojo views
curl --ftp-create-dirs -T views/dojo/create.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/create_add.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/delete.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/delete_end.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/delete_recaptcha.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/edit.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/edit_end.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/edit_form.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
curl --ftp-create-dirs -T views/dojo/validation_error.html.php -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/views/dojo
#
curl --ftp-create-dirs -T test.html -u $FTP_USER:$FTP_PASSWORD ftp://ftp.dojolist.org/www/

