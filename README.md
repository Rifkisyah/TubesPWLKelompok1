# AdminPanelTeam1

A web-based admin panel and landing page built using Laravel and Blade templating. This project provides a simple dashboard structure with reusable components and a public landing page without authentication.

---

## Features

* Reusable sidebar component using Blade
* Admin panel layout with modular structure
* Public landing page (no authentication required)
* Clean separation between layout, content, and components
* Simple routing using Laravel named routes

---

## Installation

1. Clone the repository

```
git clone https://github.com/Rifkisyah/TubesPWLKelompok1.git
```

2. Navigate to project directory

```
cd TubesPWLKelompok1
```

3. Install dependencies if not installed

```
composer install
npm install
```

4. Run your Localhost for database access 

5. Run Migration and Seeder
```
php artisan migrate
php artisan db:seed
```
or
```
php artisan migrate:fresh --seed
```

6. Run development server (all required)

```
npm run dev 
php artisan serve (need for display UI/UX from tailwind)
```

---

## Tech Stack

* Laravel
* Tailwind CSS

---

## License

This project is open-source and available under the MIT License.
