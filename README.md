build_my_CV()
=============

An automatic CV builder from a JSON file based on **PHP7**.

You can visit it an example at [rousseau-alexandre.fr](http://rousseau-alexandre.fr)

Instalation
-----------

clone this repository 

    git clone https://github.com/madeindjs/build_my_cv.git
    cd build_my_cv


Install dependencies with composer:

    php composer.phar install

Create a symbolic link in you Apache server

    sudo ln -s /path/to/git/clone/build_my_cv /var/www/build_my_cv

Edit your apache configuration file:

    sudo vim /etc/apache2/sites-enabled/000-default.conf

    <VirtualHost *:80>
        DocumentRoot    /var/www/build_my_cv/src/public/
    </VirtualHost>

Restart Apache server

    sudo /etc/init.d/apache2 restart

In your Apache configuration file

    DocumentRoot    /home/lorna/projects/slim/project/src/public/


Libraries
---------

**PHP**

* [Slim Framework](http://www.slimframework.com/)
* [Parsedown](https://github.com/erusev/parsedown)

**Javascript**

* [JSON Editor](https://github.com/jdorn/json-editor)

Purpose
-------

The purpose is simple:

1. you fill the *data.json* file with you information like:
  * firstname, lastname, email, etc..
  * your internet identity links (Linkedin, StackOverflow, Github, etc..)
  * competencies on how many langages or Frameworks
  * professionnals & personnals experiences
2. that's all!

**build_my_CV()** will generate a beutifull CV with timeline for you.


Future
------

* [ ] create a json file generator (Python or Ruby?)
* [ ] add link generator (link to ruby, Python, ror, etc..)
* [ ] add PHPUnits tests
* [ ] create projects pages
* [x] create Markdown support 
* [x] create a beautifull timeline 


License
-----------

[MIT](https://opensource.org/licenses/MIT)


Author
----------

[Rousseau Alexandre](https://github.com/madeindjs)
