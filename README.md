build_my_CV()
=============

A CV génerator without database requirement.

Purpose
-------

The purpose is simple:

1. Install & configure this project on your server *(see installation section bellow)*
2. go to */admin* url and edit your personnal informations, add skills, experiences, etc..
3. That's all. 

**build_my_CV()** will generate a beutifull responsive CV for you. You can easilly update your informations from the admin interface.

### some Screenshots

#### Admin interface

![screenshot of admin interface](https://raw.githubusercontent.com/madeindjs/build_my_cv/master/screenshot_admin.png)

#### CV in dekstop view

![screenshot of CV in dekstop view](https://raw.githubusercontent.com/madeindjs/build_my_cv/master/screenshot_cv_desktop.png)

#### CV in mobile view

![screenshot of CV in mobile view](https://raw.githubusercontent.com/madeindjs/build_my_cv/master/screenshot_cv_mobile.png)


You can visit an example at [rousseau-alexandre.fr](http://rousseau-alexandre.fr)



Instalation
-----------

#### Configuration on Apache Server

* clone this repository: `git clone https://github.com/madeindjs/build_my_cv.git`
* move into this folder: `cd build_my_cv`
* Install dependencies with composer: `php composer.phar install`
* Create a symbolic link in you Apache server: `sudo ln -s /path/to/git/clone/build_my_cv /var/www/build_my_cv`
* Edit your apache configuration file: `sudo vim /etc/apache2/sites-enabled/000-default.conf` as bellow

```
<VirtualHost *:80>
    DocumentRoot    /var/www/build_my_cv/src/public/
</VirtualHost>
```

* Restart Apache server: `sudo /etc/init.d/apache2 restart`

#### Configuration of admin interface

The only configuration required is the password to access on admin interface. By default it's "*superuser*" but you can change it in the *config.json* file:

```
{
    "admin" : {
        "password" : "superuser"
    }
}
```



Libraries
---------

**PHP**

* [Slim Framework](http://www.slimframework.com/)
* [Parsedown](https://github.com/erusev/parsedown/)

**Javascript**

* [JSON Editor](https://github.com/jdorn/json-editor/)




Future
------

* [x] create a json file generator
* [ ] add link generator (link to ruby, Python, ror, etc..)
* [ ] add PHPUnits tests
* [ ] create projects pages
* [ ] support multilangage
* [x] create Markdown support 
* [x] create a beautifull timeline 


License
-----------

[MIT](https://opensource.org/licenses/MIT)


Author
----------

[Rousseau Alexandre](https://github.com/madeindjs)
