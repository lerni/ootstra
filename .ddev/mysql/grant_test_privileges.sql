-- Grant all privileges to db user for PHPUnit testing
-- This allows PHPUnit to create and manipulate temporary test databases
GRANT ALL PRIVILEGES ON *.* TO 'db'@'%';
FLUSH PRIVILEGES;
