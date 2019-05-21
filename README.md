Installation instructions:
1. clone the app's repository in the appropriate folder
2. setup and configure the virtual host to point to the {folder}/public subfolder
3. run : `composer install` to install dependencies 
4. configure the env file with the following settings:
- `COMPANIESHOUSE_API_KEY="api_key_from_companieshouse_account"`
- `COMPANIESHOUSE_API="https://api.companieshouse.gov.uk/"` 


Running tests:
1. just run `phpunit` in the project folder
