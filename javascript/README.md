###Knex

Timestamps
```javascript
table.timestamp('created_at').defaultTo(knex.raw('CURRENT_TIMESTAMP'));
table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
```
<br>

Random hex
```javascript
'#'+Math.floor(Math.random()*16777215).toString(16);
```