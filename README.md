# Asset Tracking Project

## Overview
This project is designed for tracking assets using a MySQL database. It allows users to add new assets and retrieve a list of existing assets.

## Project Structure
```
asset-tracking
├── config.php
├── add_asset.php
├── get_assets.php
├── index.php
└── README.md
```

## Files Description

### config.php
This file establishes a connection to the MySQL database. It defines the connection parameters such as host, database name, user, and password. It creates a new mysqli instance and checks for connection errors.

### add_asset.php
This file handles the addition of a new asset to the database. It includes the config.php file, checks if the request method is POST, retrieves the asset details from the form, prepares an SQL statement to insert the asset into the database, and executes the statement. It returns a JSON response indicating success or failure.

### get_assets.php
This file retrieves all assets from the database. It includes the config.php file, executes a SELECT query to fetch assets ordered by timestamp, and returns the results as a JSON array.

### index.php
This file displays the list of assets in an HTML table. It includes the config.php file, executes a SELECT query to fetch assets, and generates an HTML page that presents the assets with their ID, name, latitude, longitude, and timestamp.

## Setup Instructions
1. Ensure you have XAMPP installed and running.
2. Create a new database in MySQL for the asset tracking project.
3. Update the `config.php` file with your database connection details.
4. Place all files in the `htdocs` directory of your XAMPP installation.
5. Access the project through your web browser at `http://localhost/asset-tracking/index.php`.

## Usage Guidelines
- To add a new asset, send a POST request to `add_asset.php` with the asset details.
- To view all assets, navigate to `index.php` in your web browser.