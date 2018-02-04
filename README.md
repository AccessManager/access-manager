 # Access Manager - Subscriber Manager for ISPs
 

Access Manager is a centralised radius based subscriber management system for 
WiFI Hotspot operators and Small/Medium ISPs. It supports Mikrotik as a NAC. It includes most of the features
related to subscriber management. Including subscriber account, free/paid subscriptions,
prepaid voucher generation and limiting subscription services based on
data/time limit among others.

### Supported NAC/Router Vendors:
- Mikrotik

## Installation
Access Manager is written in PHP (Laravel Framework) and uses MySQL for database storage. Thus requires one time setup
process to be followed. And this is going to be a lengthy one. And with that in mind, lets get started. 

### Prerequisite
- Basic Knowledge of Linux Operating System

Though Access Manager can be installed on any linux flavor, 
however in this example we'll be using Ubuntu Server 16.04 LTS. And I assume you have configured network interface 
with IP address of 192.168.1.10/24.

This is considered good practice to update your system packages time to time, so run following command to 
check & install available updates.

```
$ sudo apt update
$ sudo apt upgrade 
```

Next install the required packages:

```
$ sudo apt install apache2 libapache2-mod-php php7.0 php-zip php7.0-mbstring php7.0-bcmath php7.0-mysql mysql-server freeradius freeradius-mysql freeradius-utils
```
**NOTE:** 
During the installation you'll be asked to set root password for MySQL server, choose a strong password
and make a note of it, you'll need it later.

Access Manager manages its dependencies & updates using composer. 
So, before we can download Access Manager, we need to download  composer by 
following instructions from official composer website: 
https://getcomposer.org/download/

After downloading composer you'll end up with `composer.phar` in current directory.
After that, issue following commands:
  
```
$ chmod +x composer.phar
$ sudo mv composer.phar /usr/bin/composer
```

The above mentioned commands will add executable bit to the composer file and move it to /usr/bin 
to make it globally accessible.

After having composer in place, we're ready to download Access Manager. In this example we'll download the project in
current user's home directory. In case you're already not in the home directory type `cd` to change to home directory
and `pwd` will output the path to current working directory, if you want to verify.

Now, to download Access Manager project issue following command:

```
$ composer create-project access-manager/access-manager -s beta
```

Above mentioned command will download Access Manager 3.0-BETA & its dependencies. We'll also need to create a database
we want to use for Access Manager. Use following commands to create a new databased called `acmanager`, 
you can choose whatever you want to name it:

when prompted enter the password for MySQL root user, you set during MySQL installation.

```
$ mysql -u root -p
mysql> create database acmanager;
``` 

Press `ctrl+d` to get out of MySQL prompt.

Still being in the home directory issue following commands to get into project directory 
& make the storage directory writeable:

```
$ cd access-manager
$ chmod 777 -R storage
```

Since this is a fresh install, run following command for configuration setup.

_This command will ask for a few inputs including MySQL username/password. For testing you can provide 
root username & password, but **it is strongly recommended to create a new user with less privileges for 
production server.**_

```
$ php artisan setup:fresh
```

Access Manager setup is complete but we need to configure apache web server to serve our project. If you want to host 
other projects/websites on this server multiple virtual servers can be created. But for this example I'll
edit the default virtual server. Use following command to open virtualserver config file using vim text editor: 

```
$ sudo vim /etc/apache2/sites-enabled/000-default.conf
```

In this file we need to make two modifications:
1. change document root to `/home/{Your_User_Name}/access-manager/html`
2. add following code block somewhere within <Virtualhost>....</Virtualhost> block.
```
<Directory /home/am/access-manager/html>
    Options Indexes FollowSymLinks
    AllowOverride all
    Require all granted
</Directory>
```

Next step is to enable rewrite mode for apache.

```
$ sudo a2enmod rewrite
```
 
 Now, for the changes to take effect, restart apache server with following command:
 
 ```
 $ sudo service apache2 restart 
 ```
 
At this point, you should be able to access the project by pointing your browser to IP address of the server, which
in this case is 192.168.1.10. Login using admin credentials & create new accouts, subscriptions, routers and all other
features of Access Manager. But one more thing left to be configured is freeradius. Installing & configuring Freeradius
is same as earlier versions of Access Manager ie. 2.*. 

**MIND YOUR CREDENTIALS WHEN FOLLOWING OLDER EXAMPLES**  

To install & configure Freeradius server, refer to: 
http://accessmanager.in/userguide/install_and_configure_freeradius .


And to integrate Access Manager & Freeradius to complete the setup, follow:

http://accessmanager.in/userguide/integrate_access_manager_with_freeradius

**Use following code for exec modules:**

```
exec am-authorize { 
input_pairs = request 
shell_escape = yes 
wait = yes 
output_pairs = reply 
program = "/usr/bin/php /home/am/access-manager/artisan am:authorize %u" 
} 

exec am-accounting { 
input_pairs = request 
shell_escape = yes 
wait = yes
output = none 
program = "/usr/bin/php /home/am/access-manager/artisan am:account %Z" 
}
```


**Hope you enjoy the project. :\)**