pictwist
========

## Installation Instructions

Our application is quite simple to install, and can be up and running in minutes.

To get started, you need a standard LAMP web server running Apache, MySQL, and PHP. Additionally, you will need the version control software package git. This can be installed on most linux-based systems with the command: apt-get install git.

To install:
Clone our app into your apache public web directory with: git clone git@github.com:christiangenco/pictwist.git
cd into the directory and run the mysql script database.sql script (from mysql, this can be done by running: \. database.sql). This will also set up a mysql user named pictwist with access to the pictwist database.
Ensure the directory is owned by the same user running the apache process on your system, chmod 755 -R . the directory, and navigate to the directory through a web browser.

The application should now be up and running! If you have any difficulty with this process, submit an issue request to our public git repository at https://github.com/christiangenco/pictwist/issues.