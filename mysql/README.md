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


#### ROW NUMBER
```sql
insert into leader_board (giveaway_instance_id, user_id, tokens, position)

select leaders.*, (@row_number:=@row_number + 1) AS position from (

	select
		giveaway_instance_id, user_id, sum(tokens) as tokens
	from
		action_finish_events
	where
		giveaway_instance_id = 3125 and tokens > 0
	group by user_id
	order by `tokens` desc

) as leaders, (SELECT @row_number:=0) AS t;
```


#### Leader board
```sql
select * from leader_board where instance_id = 3125 and position = 4  
union all  
(select * from leader_board where instance_id = 3125 and position < 4  order by position desc limit 1)
union all  
(select * from leader_board where instance_id = 3125 and position > 4 order by position asc limit 1)
order by position;
```


#### Dates
```sql
#date format
update table set date = date_format(created_at, '%Y-%m-%d %H:%i:00');
```
