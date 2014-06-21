Introduction
--------------
Doptor CMS is a Laravel 4 based CMS. Find out more about Doptor by reading below. ;)

![Doptor CMS Frontend](screenshots/doptor_frontend.jpg?raw=true)
![Doptor CMS Backend](screenshots/doptor_backend.jpg?raw=true)

About Doptor CMS
-----------------
Doptor is an Integrated and well-designed Content Management System (CMS) and Enterprise Management System (EMS) provides an end user with the tools to build and maintain a sustainable web presence. For a serious company, having a maintainable website is extremely important and the effectiveness of such a site depends on the ease of use and power of the backend CMS. 

There are many available CMS out there but they are too generalized to fit the needs of many companies. Introducing the new CMS platform for businesses, which caters to their exact need without sacrificing the power and quality of a standard platform. Through this CMS, websites can be built that aims to serve as a learning and knowledge-sharing platform for the company and act as communication tool to disseminate information to the internal and external stakeholders. 

The website will be a tool for sharing public information and build rapport with the external stakeholders. It will be the main channel for the company to publish and share information on activities, lessons learned from the project interventions, good practices and relevant research. In addition to having a CMS, a business needs other tools for regular operations as well. These other suites of applications run in the different departments of the company but together they ensure the moving forward of the company. In order to assist a company with all these needs, the CMS platform will include additional business modules, for example Invoicing, Bills, Accounting, Payroll, etc.

Requirements
--------------
- PHP 5.4 and above
- MCrypt PHP Extension
- `mod_rewrite` module enabled, if serving the CMS on an Apache server
- `php_fileinfo` plugin enabled
- MySQLi extension installed and enabled
- PHP cURL extension installed and enabled
- PHP zip extension installed and enabled

Installation
--------------
###Install Composer
Doptor CMS is based on Laravel, which utilizes [Composer](http://getcomposer.org) to manage its dependencies. First, download a copy of the `composer.phar`. Once you have the PHAR archive, you can either keep it in your local project directory or move to `usr/local/bin` to use it globally on your system. On Windows, you can use the Composer [Windows installer](https://getcomposer.org/Composer-Setup.exe).

###Install Doptor CMS
1. Download or checkout the latest copy of Doptor from here (https://github.com/Doptor/Doptor)
2. Enter the newly created folder. e.g.: `cd Doptor`
3. Install the required dependencies with composer. `composer install --no-dev`
4. Copy the checkout folder to your web server
5. Access the website in browser. e.g.: www.yourdomain.com/doptor
6. Follow and complete the installation wizard.

*Note: You may need to configure the `app/storage` folder to have write access by the server. A permission of `775` on the `app/storage` folder is sufficient.*

More about Doptor CMS
--------------
Visit www.doptor.org

Note
--------------
Doptor is under heavy development and major changes will be pushed from time to time. You are most welcome to test Doptor CMS, however it is strictly not recommended for use in production environment until it reaches a stable release.

Contributing to Doptor CMS
--------------
**All issues and pull requests should be filed on the [Doptor/Doptor](https://github.com/Doptor/Doptor) repository.**
