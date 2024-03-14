# TTR Dev Assessment

## Introduction
This application is a simple API to compare CSV files, and return the differences between them. The application is built using the brand new Laravel 11.

## Installation
1. Clone the repository
2. Run:
```bash
make build
```
3. Use a tool like Postman to test the API
4. create a new POST request pointing to http://localhost:8000/api/v1/compare-csv
5. Select the radio button `form-data` in the body tab
6. Add two files with the key `csv1` and `csv2`
7. Select the files paths from your machine and click send.
