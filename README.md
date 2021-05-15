# PHP Simple CRUD API

Simple API for storing and retrieving labeled data.

- [✏️ Create](#️-create)
  - [Parameters](#parameters)
  - [Example request](#example-request)
  - [Successful response](#successful-response)
  - [Unsuccessful response](#unsuccessful-response)
- [👀 Read](#-read)
  - [Parameters](#parameters-1)
  - [Example requests](#example-requests)
  - [Successful response](#successful-response-1)
  - [Unsuccessful response](#unsuccessful-response-1)
- [📤 Update](#-update)
  - [Parameters](#parameters-2)
  - [Example request](#example-request-1)
  - [Successful response](#successful-response-2)
  - [Unsuccessful response](#unsuccessful-response-2)
- [🗑️ Delete](#️-delete)
  - [Parameters](#parameters-3)
  - [Example request](#example-request-2)
  - [Successful response](#successful-response-3)
  - [Unsuccessful response](#unsuccessful-response-3)
  - [⚙️ Config](#️-config)

## ✏️ Create

### Parameters

| Parameter          | Description                                                                                            |
| ------------------ | ------------------------------------------------------------------------------------------------------ |
| `tag` (required)   | Choose a tag name which can be used for filtering. This is like a category for a group of similar data |
| `key` (required)   | The key for labeling the data. This will be used for accessing it later                                |
| `value` (required) | The data to store at the specified key                                                                 |

### Example request

```
/insert?tag=timers&key=123&value=1610278082
```

### Successful response

| Key            | Value                   |
| -------------- | ----------------------- |
| `responseType` | "success"               |
| `data`         | The data in JSON format |

```json
{
  "responseType": "success",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

### Unsuccessful response

| Key            | Value                                                              |
| -------------- | ------------------------------------------------------------------ |
| `responseType` | "error"                                                            |
| `message`      | A description of the error                                         |
| `data`         | The data in JSON format  (only if the error involves a data value) |

```json
{
  "responseType": "error",
  "message": "key '123' already exists in tag 'timers'",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

## 👀 Read

### Parameters

| Parameter        | Description                           |
| ---------------- | ------------------------------------- |
| `tag` (optional) | The tag name to filter by             |
| `key` (optional) | A specific key you want the value for |

### Example requests

#### Get all data in all tags

```
/get
```

#### Get all data within a tag

```
/get?tag=timers
```

#### Get a single entry

```
/get?tag=timers&key=123
```

### Successful response

#### Get all data in all tags


| Key            | Value                   |
| -------------- | ----------------------- |
| `responseType` | "success"               |
| `data`         | The data in JSON format |

```json
{
  "responseType": "success",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

#### Get all data within a tag

| Key            | Value                                         |
| -------------- | --------------------------------------------- |
| `responseType` | "success"                                     |
| `data`         | The data in JSON format for the requested tag |

```json
{
  "responseType": "success",
  "data": {
    "123": "1610278082",
    "1234": "1610278082"
  }
}
```

#### Get a single entry

| Key            | Value                                         |
| -------------- | --------------------------------------------- |
| `responseType` | "success"                                     |
| `data`         | The data in JSON format for the requested key |

```json
{
  "responseType": "success",
  "data": {
    "123": "1610278082",
  }
}
```

### Unsuccessful response

| Key            | Value                                                             |
| -------------- | ----------------------------------------------------------------- |
| `responseType` | "error"                                                           |
| `message`      | A description of the error                                        |
| `data`         | The data in JSON format (only if the error involves a data value) |

```json
{
  "responseType": "error",
  "message": "key '12345' does not exist in tag 'timers'",
  "data": {
    "123": "1610278082",
    "1234": "1610278082"
  }
}
```

## 📤 Update

### Parameters

| Parameter          | Description                                         |
| ------------------ | --------------------------------------------------- |
| `tag` (required)   | Specify the tag where the data should be updated    |
| `key` (required)   | Specify which key within that tag should be updated |
| `value` (required) | The data to store at the specified key              |

### Example request

```
/update?tag=timers&key=123&value=0
```

### Successful response

| Key            | Value                   |
| -------------- | ----------------------- |
| `responseType` | "success"               |
| `data`         | The data in JSON format |

```json
{
  "responseType": "success",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

### Unsuccessful response

| Key            | Value                                                             |
| -------------- | ----------------------------------------------------------------- |
| `responseType` | "error"                                                           |
| `message`      | A description of the error                                        |
| `data`         | The data in JSON format (only if the error involves a data value) |

```json
{
  "responseType": "error",
  "message": "key '12345' does not exist in tag 'timers'",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

## 🗑️ Delete

### Parameters

| Parameter        | Description                                         |
| ---------------- | --------------------------------------------------- |
| `tag` (required) | Specify the tag where the data should be deleted    |
| `key` (required) | Specify which key within that tag should be deleted |

### Example request

```
/delete?tag=timers&key=123
```

### Successful response

| Key            | Value                   |
| -------------- | ----------------------- |
| `responseType` | "success"               |
| `data`         | The data in JSON format |

```json
{
  "responseType": "success",
  "data": {
    "timers": {
      "1234": "1610278082"
    }
  }
}
```

### Unsuccessful response

| Key            | Value                                                             |
| -------------- | ----------------------------------------------------------------- |
| `responseType` | "error"                                                           |
| `message`      | A description of the error                                        |
| `data`         | The data in JSON format (only if the error involves a data value) |

```json
{
  "responseType": "error",
  "message": "key '12345' does not exist in tag 'timers'",
  "data": {
    "timers": {
      "123": "1610278082",
      "1234": "1610278082"
    }
  }
}
```

### ⚙️ Config

#### Configuration options

| Option               | Description                                                                           |
| -------------------- | ------------------------------------------------------------------------------------- |
| `secret` (string)    | Secret key for preventing others from modifying your data (leave blank for no secret) |
| `private` (boolean)  | Whether or not the secret key is required for *reading* the data                      |
| `json_path` (string) | Path for storing the data file                                                        |

#### Using secrets

In `config.php`, you can set a **secret** which will be a required parameter passed in the URL for insertion, updates, and deletion (eg. `...&secret=example`).

To require the secret parameter to be passed even when reading data, set **private** to true.