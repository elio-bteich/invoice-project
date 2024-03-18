# Invoice Project (Unfinished)
This repository contains the "Invoice Project," intended for a marine services company in Lebanon. The project focuses on dynamically generating invoices, converting Lebanese Pound (LBP) amounts to United States Dollar (USD) based on the exchange rate, and providing a PDF export feature for easy printing and record-keeping. Please note that this project remains unfinished and is still in the development phase.

## Project Overview
The "Invoice Project" was designed as a comprehensive invoice management system for marine services companies in Lebanon. The system aimed to automate the process of generating dynamic invoices, converting Lebanese Pound (LBP) amounts to USD based on the prevailing exchange rate, and providing a PDF export feature for easy printing and record-keeping.

## Key feature

1- Dynamic Invoice Generation: Users can create invoices dynamically by selecting items, quantities, and customer information.

2- Customer Management: Users can create customers, but the implementation is limited to adding customers only. However, the suggested customer names are available for selection when typing the customer name during invoice creation.


## Requirement
Currently, the invoice generation process is limited, and only one item with code "ABCDE" can be included in the invoice. To specify the unit price of the item, users should type the currency followed by the price (e.g., USD 132). The conversion and all calculations are done automatically.

Please note that the application may throw errors if the specified steps are not followed due to the incomplete implementation. Nevertheless, the project serves as a demonstration of dynamic PDF rendering, which is useful for generating invoices.

## Getting Started
Follow these instructions to get a local copy of the project up and running:

Clone the repository to your local machine:
```bash
git clone https://github.com/elio-bteich/invoice-project.git
cd invoice-project
```

Install project dependencies using Composer:
```bash
composer install
```

Copy the .env.example file and create a .env file:
```bash
cp .env.example .env
```

Generate a new application key:
```bash
php artisan key:generate
```

Set up your database configuration in the .env file.

Run database migrations and seed initial data:

```bash
php artisan migrate --seed
```

Serve the application locally:
```bash
php artisan serve
```

Visit http://localhost:8000 in your web browser to access the application.

## Unfinished Work
The "Invoice Project" is still in the development phase and remains unfinished. While core concepts and some features were started, various aspects of the application are incomplete or may require further development.

## Future Enhancements
Although this project is unfinished, there are opportunities for improvement and completion. Future enhancements could include:

Completing the item and customer management features to allow for easy selection in invoices.
Testing the application thoroughly to ensure seamless user experience.
