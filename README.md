# MyIDM
My Identity Manager (MyIDM)


Система управление учётными данными 





Установка Yii <span id="installing-from-composer"></span>
==============

Вы можете установить Yii двумя способами: используя [Composer](https://getcomposer.org/) или скачав архив.
Первый способ предпочтительнее так как позволяет установить новые [расширения](structure-extensions.md)
или обновить Yii одной командой.

> Note: В отличие от Yii 1, после стандартной установки Yii 2 мы получаем как фреймворк, так и шаблон приложения.


Установка при помощи Composer <span id="installing-via-composer"></span>
-----------------------

### Установка Composer

Если Composer еще не установлен это можно сделать по инструкции на
[getcomposer.org](https://getcomposer.org/download/), или одним из нижеперечисленных способов. На Linux или Mac 
используйте следующую команду:
https://github.com/yiisoft/yii2/blob/master/docs/guide-ru/start-installation.md

Есть всего несколько вещей, которые вам понадобятся, чтобы запустить Composer
```bash
$ apt install sudo php-cli git
```

Перходим директорию временных файлов. После установки легче очистить.
```bash
$ cd /tmp. 
```

После этого используйте PHP для захвата установщика.
```bash
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```
Чтобы Composer был доступен для всей системы, установим в каталог /usr/local/bin.
```bash
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

Теперь очистите установщик. Вы можете дождаться, когда директория /tmp будет очищена, или выполните приведенную ниже команду.
```bash
$ php -r "unlink('composer-setup.php');"
```

более подробная инструкция по установке Composer
https://linuxconfig.org/how-to-install-php-composer-on-debian-linux

### Установка Yii

```bash
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
```

Эта команда устанавливает последнюю стабильную версию Yii в директорию `basic`. Если хотите, можете выбрать другое
имя директории.

Info: Если команда `composer create-project` не выполняется нормально, попробуйте обратиться к
[разделу "Troubleshooting" документации Composer](https://getcomposer.org/doc/articles/troubleshooting.md).
Там описаны другие типичные ошибки. После того, как вы исправили ошибку, запустите `composer update` в директории `basic`.

Tip: Если вы хотите установить последнюю нестабильную ревизию Yii, можете использовать следующую команду,
в которой присутствует [опция stability](https://getcomposer.org/doc/04-schema.md#minimum-stability):

```bash
 composer create-project --prefer-dist --stability=dev yiisoft/yii2-app-basic basic
```

Старайтесь не использовать нестабильную версию Yii на рабочих серверах потому как она может внезапно поломать код.

более подробная инструкция по установке Yii
https://github.com/yiisoft/yii2/edit/master/docs/guide-ru/start-installation.md



