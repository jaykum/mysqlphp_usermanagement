# mysqlphp_usermangement
This is a php project that demonstrates the use of MySQL and PHP for user management on a web site.
Not many frills just the basics.  The code for creating the table managed is:

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pswd` varchar(255) NOT NULL,
  `admin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
