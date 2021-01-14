# PHP Simple CRUD API

Simple API for storing and retrieving labeled data.

## Create

**Parameters**

`tag` (required) - Choose a tag name which can be used for filtering. This is like a category or namespace for a group of similar data.

`key` (required) - The key for labeling the data. This will be used for accessing it later.

`value` (required) - The data to store at the specified key.

**Example**

```
/insert?tag=timers&key=123&value=1610278082
```

## Read

**Parameters**

`tag` (optional) - The tag name to filter by

`key` (optional) - A specific key you want the value for.

**Example**

Get all data in all tags:

```
/get
```

Get all data within a tag:

```
/get?tag=timers
```

Get a single entry containing a key value pair:

```
/get?tag=timers&key=123
```

## Update

**Parameters**

`tag` (required) - Specify the tag where the data should be updated.

`key` (required) - Specify which key within that tag should be updated.

`value` (required) - The data to store at the specified key.

**Example**

```
/update?tag=timers&key=123&value=0
```

## Delete

**Parameters**

`tag` (required) - Specify the tag where the data should be deleted.

`key` (required) - Specify which key within that tag should be deleted.

**Example**

```
/delete?tag=timers&key=123
```
