# MyIDM
My Identity Manager (MyIDM)


Система управление учётными данными 


Есть всего несколько вещей, которые вам понадобятся, чтобы запустить Composer
$ apt install sudo php-cli git

Перходим директорию временных файлов. После установки легче очистить.
$ cd /tmp. 

После этого используйте PHP для захвата установщика.
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

Чтобы Composer был доступен для всей системы, установим в каталог /usr/local/bin.
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

Теперь очистите установщик. Вы можете дождаться, когда директория /tmp будет очищена, или выполните приведенную ниже команду.
$ php -r "unlink('composer-setup.php');"

более подробная инструкция по установке Composer
https://linuxconfig.org/how-to-install-php-composer-on-debian-linux


