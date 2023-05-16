
# Technical Challenge

Product Registration and Sales System for a Marketplace


## Stacks

**Front-end:** VueJs, Vuetify

**Back-end:** PHP

## Require

Make sure you have the following require installed on your machine:

- PHP 8.1.18
- Node.js v14.17.5
- Yarn 1.22.19
- @vue/cli 5.0.8

## Instalação

```bash
 git clone https://github.com/biancamota/desafio-soft-expert.git
```

#### Run backend
```bash
   cd api
   composer install
   php -S localhost:8081 -t public
```
The API will be available at: http://localhost:8081

#### Run frontend
```bash
   cd frontend-2
   yarn install
   yarn dev
```
The API will be available at: http://localhost:3000/

#### If you want to compile the project for production, run the following command
```bash
   yarn build
```
This will generate an optimized version of the project in the dist/ folder.

## API Routes
#### `GET` /products: Returns a list of all products in the database.
#### `GET` /products/:id: Returns product in the database.
#### `POST` /products: Adds a new product to the database.
| Parameter   | Type       |                            |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Required**. |
| `description` | `string` |  |
| `category_id` | `string` | **Required**. |
| `purchase_price` | `string` |  |
| `sale_price` | `string` | |
| `tax_value` | `string` |  |

#### `PUT` /products/:id: Updates an existing product in the database. Required parameters: id.
| Parameter   | Type       |                            |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Required**. |
| `description` | `string` |  |
| `category_id` | `string` | **Required**. |
| `purchase_price` | `string` |  |
| `sale_price` | `string` | |
| `tax_value` | `string` |  |

#### `DELETE` /products/:id: Deletes a product from the database. Required parameters: id.
