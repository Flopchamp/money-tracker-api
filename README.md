# Money Tracker API

A Laravel-based REST API for managing multiple wallets and tracking income/expense transactions.

## Features

-  User management (no authentication required)
-  Multiple wallets per user
-  Income and expense tracking
-  Automatic balance calculation
-  Complete CRUD operations
-  Input validation

## Technology Stack

- PHP 8.5
- Laravel 11
- SQLite Database
- RESTful API Architecture

## Installation

1. Clone the repository
```bash
git clone <your-repo-url>
cd money-tracker-api
```

2. Install dependencies
```bash
composer install
```

3. Run migrations
```bash
php artisan migrate
```

4. Start the server
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Users
- `POST /api/users` - Create a new user
- `GET /api/users/{id}` - Get user profile with all wallets and total balance

### Wallets
- `POST /api/wallets` - Create a new wallet
- `GET /api/wallets/{id}` - Get wallet details with transactions

### Transactions
- `POST /api/transactions` - Add a transaction (income or expense)

## API Examples

### Create User
```json
POST /api/users
{
    "name": "John Doe",
    "email": "john@example.com"
}
```

### Create Wallet
```json
POST /api/wallets
{
    "user_id": 1,
    "name": "Personal Account",
    "description": "My savings"
}
```

### Add Income Transaction
```json
POST /api/transactions
{
    "wallet_id": 1,
    "type": "income",
    "amount": 5000,
    "description": "Monthly Salary"
}
```

### Add Expense Transaction
```json
POST /api/transactions
{
    "wallet_id": 1,
    "type": "expense",
    "amount": 1500,
    "description": "Rent Payment"
}
```

## Database Schema

### Users Table
- id
- name
- email
- timestamps

### Wallets Table
- id
- user_id (foreign key)
- name
- balance
- description
- timestamps

### Transactions Table
- id
- wallet_id (foreign key)
- type (income/expense)
- amount
- description
- transaction_date
- timestamps

## Validation Rules

- **User**: name (required), email (required, valid, unique)
- **Wallet**: user_id (required, exists), name (required)
- **Transaction**: wallet_id (required, exists), type (required, income/expense), amount (required, min: 0.01), description (required)

## Balance Calculation

- Income transactions **add** to wallet balance
- Expense transactions **subtract** from wallet balance
- Total user balance = sum of all wallet balances

## Testing

Test the API using Postman, Insomnia, or any REST client.

Sample test data is available in the API examples above.

## Author

Built as a backend assessment project demonstrating Laravel API development skills.