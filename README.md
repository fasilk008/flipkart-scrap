# Flipkart Scraper

Built on Laravel 7.29

Fetch/scrap the first 100 products from Flipkart, and list the products in a simple layout. The products are paginated, and search/filter facilities are available in the UI. The Product price is shown in Cryptocurrency & INR format.
Trigger a notification in case of price change to email
address configured in the backend

## Installation

 
```bash
1. git clone https://github.com/fasilk008/flipkart-scrap

2. cd flipkart-scrap

3. composer install

4. cp .env.example .env
```

5. Update Database, Email & Notification to email datas in .env file

```bash
6. php artisan key:generate

7. php artisan migrate

8. php artisan serve
```

## Usage

You can view the home page by navigating to [http://127.0.0.1:8000/](http://127.0.0.1:8000/)
