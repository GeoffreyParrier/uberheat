<!-- markdownlint-disable MD012 -->

# API documentation

- [API documentation](#api-documentation)
    - [Unclassified](#unclassified)
        - [Import data](#import-data)
    - [Product](#product)
        - [Create product Old](#create-product-old)
        - [Create product (with API Plateform)](#create-product-(with-api-plateform))
        - [Get product (with API Plateform)](#get-product-(with-api-plateform))
        - [Update product (with API Plateform)](#update-product-(with-api-plateform))
        - [Delete product (with API Plateform)](#delete-product-(with-api-plateform))
    - [Search](#search)
        - [Search](#search)
    - [Project](#project)
        - [Save Search in Project](#save-search-in-project)
        - [Read Project](#read-project)
        - [Add searchIntent](#add-searchintent)
        - [Remove searchIntent](#remove-searchintent)
        - [Delete Project](#delete-project)


&nbsp; <!-- break line -->

## Unclassified

### Import data

> This route allow you to import product configurations data in csv format.

**URI** : `http://localhost:8500/products/configurations/import`

**Authentication required** : `false`

**Method** : `POST`


#### Headers
| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | multipart/form-data | Unspecified |  |



#### Body
**Type**: Multipart Form

| Key  | Required | Default | Type   | Description                 |
| ---- | -------- | ------- | ------ | --------------------------- |
| file | yes      | none    | string | The csv file path to upload |



---



&nbsp; <!-- break line -->

## Product

### Create product [Depricated]

> This route was allow you to create a product in database. This route is replaced by the API Plateform’s route.

**URI** : `http://localhost:8500/products`

**Authentication required** : `false`

**Method** : `POST`

#### Headers

| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | multipart/form-data | Unspecified |  |



#### Body

**Type**: Multipart Form

| Key                            | Required | Default | Type     | Description                                                  |
| ------------------------------ | -------- | ------- | -------- | ------------------------------------------------------------ |
| name                           | yes      | none    | string   | The product name                                             |
| basePrice                      | yes      | none    | object[] | The product basePrice                                        |
| rect_product_configuration_ids | yes      | none    | string[] | The ids of rectangle product configurations if there is one.<br /> (One of rect of circ is only required) |
| circ_product_configuration_ids | yes      | none    | string[] | The ids of circular product configurations if there is one.<br /> (One of rect of circ is only required) |
| picture                        | yes      | none    | string   | The product image file path                                  |



---

### Create product (with API Plateform)

> This route allow you to create a full Product in database.

**URI** : `http://localhost:8500/api/products`

**Authentication required** : `false`

**Method** : `POST`


#### Headers
| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | multipart/form-data | Unspecified |  |



#### Body
**Type**: Multipart Form

| Key                            | Required | Default | Type     | Description                                                  |
| ------------------------------ | -------- | ------- | -------- | ------------------------------------------------------------ |
| name                           | yes      | none    | string   | The product name                                             |
| basePrice                      | yes      | none    | object[] | The product basePrice                                        |
| rect_product_configuration_ids | yes      | none    | string[] | The ids of rectangle product configurations if there is one.<br /> (One of rect of circ is only required) |
| circ_product_configuration_ids | yes      | none    | string[] | The ids of circular product configurations if there is one.<br /> (One of rect of circ is only required) |
| picture                        | yes      | none    | string   | The product image file path                                  |



---

### Get product (with API Plateform)

> This route allow you to get product information by id

**URI** : `http://localhost:8500/api/products/{id}`

**Authentication required** : `false`

**Method** : `GET`


#### Headers
No headers specified.



#### Body
No body required for this request.

---

### Update product (with API Plateform)

> This route allow you to update product informations

**URI** : `http://localhost:8500/api/products/{id}`

**Authentication required** : `false`

**Method** : `PATCH`


#### Headers
No headers specified.



#### Body
**Type**: Multipart Form

| Key                            | Required | Default | Type     | Description                                                  |
| ------------------------------ | -------- | ------- | -------- | ------------------------------------------------------------ |
| name                           | yes      | none    | string   | The product name                                             |
| basePrice                      | yes      | none    | object[] | The product basePrice                                        |
| rect_product_configuration_ids | yes      | none    | string[] | The ids of rectangle product configurations if there is one.<br /> (One of rect of circ is only required) |
| circ_product_configuration_ids | yes      | none    | string[] | The ids of circular product configurations if there is one.<br /> (One of rect of circ is only required) |
| picture                        | yes      | none    | string   | The product image file path                                  |



---

### Delete product (with API Plateform)

> This route allow you to delete a product

**URI** : `http://localhost:8500/api/products/{id}`

**Authentication required** : `false`

**Method** : `DELETE`


#### Headers
No headers specified.



#### Body
No body required for this request.

---



&nbsp; <!-- break line -->

## Search

### Search

> This route allow you to get search result according to entity and conditions

**URI** : `http://localhost:8500/search`

**Authentication required** : `false`

**Method** : `POST`


#### Headers
| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | application/json | Unspecified |  |



#### Body

| Key | Required | Default | Type | Description |
| --- | --- | --- | --- | --- |
| type | yes | none | string | The entity or search type allowed by the api |
| conditions | yes | none | object[] | This is an array contained allow condition objects |



##### SearchIntent object example

```json
{
	"type": "ProductConfiguration",
	"conditions": [
		{
			"property": "d_b1",
			"rule": "=",
			"value": "21"
		},
		{
			"property": "area",
			"rule": ">",
			"value": "5000"
		}
	]
}
```



---



&nbsp; <!-- break line -->

## Project

### Create

> This route allow you to create a project with search intents.

**URI** : `http://localhost:8500/projects`

**Authentication required** : `false`

**Method** : `POST`


#### Headers
| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | application/json | Unspecified |  |



#### Body
| Key | Required | Default | Type | Description |
| --- | --- | --- | --- | --- |
| name | true | none | string | The name of the project |
| searchIntents | true | none | object[] | An array of searchIntent object. It can be empty |



##### SearchIntent object example

```json
{
	"type": "ProductConfiguration",
	"conditions": [
		{
			"property": "d_b1",
			"rule": "=",
			"value": "21"
		},
		{
			"property": "area",
			"rule": ">",
			"value": "5000"
		}
	]
}
```



---

### Read Project

> Get project informations by id

**URI** : `http://localhost:8500/api/projects/{id}`

**Authentication required** : `false`

**Method** : `GET`


#### Headers
No headers specified.



#### Body
No body required for this request.

---

### Add searchIntent

> Add search intent to project

**URI** : `http://localhost:8500/projects/{id}/addSearchIntent`

**Authentication required** : `false`

**Method** : `PATCH`


#### Headers
| Key | Expected value | Required | Description |
| --- | --- | --- | --- |
| Content-Type | application/json | Unspecified |  |



#### Body
| Key | Required | Default | Type | Description |
| --- | --- | --- | --- | --- |
| type | unspecified | unspecified | string | unspecified |
| conditions | unspecified | unspecified | object | unspecified |

---

### Remove searchIntent

> Remove search intent to project

**URI** : `http://localhost:8500/projects/{id}/removeSearchIntent/{id}`

**Authentication required** : `false`

**Method** : `PATCH`


#### Headers
No headers specified.



#### Body
No body required for this request.

---

### Delete Project

> Delete project with all search intents attach to it

**URI** : `http://localhost:8500/api/projects/{id}`

**Authentication required** : `false`

**Method** : `DELETE`


#### Headers
No headers specified.



#### Body
No body required for this request.

---



&nbsp; <!-- break line -->

