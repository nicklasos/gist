### Remote connection

first: comment bind-address in file /etc/mysql/mysql.conf.d/mysqld.cnf
<br>
second: run provileges command 

```sql
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'password' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```
third: don't forget about firewall!