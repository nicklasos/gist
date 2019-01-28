### Remote connection

first: comment bind-address in file /etc/mysql/mysql.conf.d/mysqld.cnf
<br>
second: run provileges command 

```sql
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'password' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```
third: don't forget about firewall!



#### Distinct by two columns
```sql
select distinct
    least(campaign, country) as value1
  , greatest(campaign, country) as value2
from ads_reports;
```

#### Each latest
```sql
select * from bid_logs where id in (
	select max(id) from bid_logs group by country 
);
```
