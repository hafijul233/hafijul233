<pre>
<?php
var_dump(exec("php -v"));
var_dump(exec("echo \$HOME"));
var_dump(ini_set('max_execution_time', "2100"));
var_dump(exec("php -r \"file_exists('.htaccess') || copy('.htaccess.example', '.htaccess');\""));
var_dump(exec("php -r \"file_exists('public/.htaccess') || copy('public/.htaccess.example', 'public/.htaccess');\""));
//running composer installation
var_dump(exec("php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\""));
var_dump(exec("php -r \"if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;\""));
var_dump(exec("php composer-setup.php"));
var_dump(exec("php -r \"unlink('composer-setup.php');\""));

if (file_exists("composer.phar")) {
    echo "installation done";
    var_dump(exec("chmod -R 777 composer.phar"));
} else {
    echo "installation failed";
}
//var_dump(exec("php composer.phar install"));
//var_dump(exec("php artisan key:generate"));


                                    <option value=""> Select</option>
                                                                                                                        <option value="1">
                                                                                            </option>
                                                                                    <option value="2">
                                                2nd Division                                            </option>
                                                                                    <option value="3">
                                                3rd Division                                            </option>
                                                                                    <option value="4">
                                                GPA(Out of 4)                                            </option>
                                                                                    <option value="5">
                                                GPA(Out of 5)                                            </option>
                                                                                    <option value="6">
                                                Other                                            </option>

