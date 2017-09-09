# Connection
#### Configure new connections!
This set global Manager
```
<?php

\FiremonPHP\Connection\Configuration::set('default', [
    'url' => 'mongodb://username:password@127.0.0.1/',
    'database' => 'testdb'
])
```
#### Getting a connection

```
<?php
$manager = \FiremonPHP\Connection\Configuration::get(string $name = 'default');
```

#### Read data

```
<?php
find(string $collection, array $conditons):FindQuery
```

##### Write data
```
<?php
insert(string $collection, array $data):void

```

```
<?php
update(string $collection, array $data):UpdateQuery
```
```
<?php
delete(string $collection):DeleteQuery

```

#### Execute all queries
Return a array of results
```
<?php
execute():array

```