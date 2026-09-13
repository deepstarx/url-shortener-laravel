# URL Shortener

A Laravel 12 URL shortener application with company-based user management, role-based authorization, invitations, and public short-URL redirection.

## Requirements

* PHP 8.2+
* Composer
* MySQL
* XAMPP
* Git
* Web browser

## Local Setup

### 1. Clone the project

```bash
git clone <repository-url>
cd url-shortner
```

If the project is already on your computer:

```bash
cd url-shortner
```

### 2. Install dependencies

```bash
composer install
```

### 3. Create the environment file

Windows CMD:

```bash
copy .env.example .env
```

Git Bash:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure MySQL

Start **Apache** and **MySQL** from XAMPP.

Create a MySQL database, for example:

```text
url_shortner
```

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL root account has a password, enter it in `DB_PASSWORD`.

### 5. Run migrations and seed the database

```bash
php artisan migrate --seed
```

This creates the database tables and the default SuperAdmin.

### Default SuperAdmin

```text
Email: superadmin@example.com
Password: password
```

These credentials are for local testing only.

### 6. Start the application

Run:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## User Roles

### SuperAdmin

The SuperAdmin can:

* View all companies
* View all users and URLs
* Create a new company
* Invite an Admin for a new company

The SuperAdmin **cannot create short URLs**.

### Admin

The Admin can:

* Create short URLs
* View all URLs created by users in their company
* See the creator of each URL
* Invite another Admin
* Invite Members
* Manage their company team

When an Admin invites a user, the invited user automatically belongs to the Admin's existing company.

The Admin does **not** enter a company name when inviting a user.

### Member

The Member can:

* Create short URLs
* View their own short URLs
* Use public short URLs

A Member cannot invite other users.

## Invitation Flow

### SuperAdmin → Admin

1. Log in as SuperAdmin.
2. Open the invitation page.
3. Enter:

   * Company Name
   * Admin Email
   * Role: Admin
4. Submit the invitation.
5. Open the generated invitation link.
6. The invited Admin creates their account.

### Admin → Admin/Member

1. Log in as Admin.
2. Open the invitation page.
3. Enter:

   * Email
   * Role: Admin or Member
4. Submit the invitation.
5. The invited user creates their account.
6. The user is automatically assigned to the Admin's company.

## URL Shortener

Admin and Member users can create short URLs.

A generated short code contains 8 alphanumeric characters.

Example:

```text
http://127.0.0.1:8000/aB12xY90
```

Opening the shortened URL redirects to the original URL.

The public redirect does not require authentication.

## Run Tests

Run the complete test suite:

```bash
php artisan test
```

You can also use:

```bash
php artisan test --compact
```

The tests cover:

* Admin can create URLs
* Member can create URLs
* SuperAdmin cannot create URLs
* Admin only sees URLs from their company
* Member only sees their own URLs
* Public short URLs redirect correctly
* Invitation authorization
* Role-based access

## Useful Commands

View all routes:

```bash
php artisan route:list
```

Clear Laravel caches:

```bash
php artisan optimize:clear
```

Run migrations:

```bash
php artisan migrate
```

Reset and recreate the database:

```bash
php artisan migrate:fresh --seed
```

**Warning:** `migrate:fresh` deletes all tables and data from the configured database. Use this only for local development/testing.

## Project Architecture

The application follows this general flow:

```text
Request
   ↓
Middleware
   ↓
Form Request
   ↓
Policy
   ↓
Controller
   ↓
Service
   ↓
Eloquent Model
   ↓
MySQL
```

### Form Requests

Handle:

* Input validation
* Request-level authorization

### Policies

Handle model/resource authorization.

For example:

* Can this user create a short URL?
* Can this user view this resource?

### Controllers

Controllers coordinate the HTTP request and response.

### Services

Services contain reusable business logic.

For example, `ShortUrlService` handles short-code generation and URL creation.

### Models

Eloquent models represent database records and relationships.

### Database

MySQL stores:

* Users
* Companies
* Invitations
* Short URLs

## Important Local Development Notes

### Frontend

The current project does not require an npm/Vite build for the frontend.

### MySQL connection error

If Laravel cannot connect to MySQL:

1. Make sure MySQL is running in XAMPP.
2. Check the `.env` database settings.
3. Confirm the database exists.
4. Check that MySQL is using port `3306`.
5. Run:

```bash
php artisan optimize:clear
```

Then try again.

### Route problems

Check registered routes:

```bash
php artisan route:list
```

Then clear cached routes/configuration:

```bash
php artisan optimize:clear
```

## Testing Checklist

Before submitting/testing the project, verify:

* [ ] Application loads successfully
* [ ] SuperAdmin can log in
* [ ] SuperAdmin can create a company
* [ ] SuperAdmin can invite an Admin
* [ ] Admin can create an account through invitation
* [ ] Admin can create a short URL
* [ ] Admin can invite another Admin
* [ ] Admin can invite a Member
* [ ] Member can create a short URL
* [ ] Admin sees URLs from their company
* [ ] Admin sees the URL creator
* [ ] Member sees only their own URLs
* [ ] SuperAdmin sees URLs from all companies
* [ ] SuperAdmin cannot create a short URL
* [ ] Public short URL redirects correctly
* [ ] `php artisan test` passes

## Security

The default SuperAdmin credentials are intended only for local assignment/testing.

Do not use the default password in production.

Do not commit your real `.env` file or production credentials to Git.
