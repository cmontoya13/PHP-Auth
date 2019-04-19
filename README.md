PHP Authentication with hash/salt password protection and forgot password email confirmation. This is only the PHP portion and would still need javascript form validation for live version. You will need to know the basics of MySQL and email server settings for this to work. Email is only used for the forgot password feature.

Customize the following:
1) Create a database named 'test_db' with a table named 'admin'
	- you can use the 'test_db.sql' file provided
2) Set 'config.php' with your database settings (currently localhost)
3) Create your own salt for password hashing and enter your email server settings on 'forgot-password.php'
	- lines 20 and 31
4) Make the $preSalt and $endSalt of 'change-password.php' and 'register.php'
5) Create your own salt for datetime hash that's sent as a url query string
	- line 20


**********************************************
FUNCTIONALITY
**********************************************

*** SIGN UP / LOGIN / LOGOUT ***
'index.php' contains login and sign up links

1) sign up link opens 'register.php'
	- includes 'config.php' for test_db database access
	- creates an MD5 hash/salt of password
	- stores new users in 'test_db.admin'
	- redirects to 'welcome.php' or returns error message
2) login link opens 'login.php'
	- includes 'config.php' for test_db database access
	- creates a user session
	- creates MD5 hash/salt of password to check against stored hash/salt password
	- checks test_db database for match and opens 'welcome.php' or returns error
3) 'welcome.php' includes 'session.php' to create a user session
	- has a signout link that ends the session
	- has a changepassword link that ends the session
	- has an unsubscribe link that removes the user from database and ends the session
4) 'logout.php' ends user session and redirects to 'index.php'


*** CHANGE / FORGOT PASSWORD ***
'welcome.php' contains change password link
'login.php' contains forgot password link

1) change password link opens 'change-password.php'
	- includes 'config.php' for test_db database access
	- checks if user session is active or url token is present
	- if neither is found, returns message that login is required
	- user enters new password
	- creates MD5 hash/salt of password and updates in database
	- redirects to 'welcome.php' or returns error message
2) forgot password link opens 'forgot-password.php'
	- includes 'config.php' for test_db database access
	- requires username entry and valid email address
	- creates MD5 hash/salt token and combines with dateTime stamp and stores in database
	- stores current dateTime in database for expiration checking
	- sends email with link to 'www......com/change-password.php?token=XXXXXXXXX
3) user clicks link in email from 'forgot-password.php'
	- opens 'change-password.php'
	- checks if user session is active or url token is present
	- if neither is found, returns message that login is required
	- if url token is found and is a match to database, user session is created
	- user enters new password
	- creates MD5 hash/salt of password and updates in database
	- redirects to 'welcome.php' or returns error message
4) 'index.php' checks the database for expired change password tokens and NULLS where appropriate

