# Prototype BTP - Room Rental Management System

## Overview
Prototype BTP is a comprehensive room rental management system developed for Bandung Techno Park. This web-based application streamlines the process of room booking, rental management, and administration for various types of users including administrators, staff, and tenants.

## Features

### For Administrators and Staff
- **Dashboard**: View calendar of approved bookings and room occupancy statistics
- **Room Management**: Add, edit, delete, and manage room information including details, pricing, and availability
- **Booking Management**: Review, approve, or reject booking applications 
- **Occupancy Reports**: Generate and export detailed occupancy data for analytics
- **Rental History**: View and export comprehensive rental history reports

### For Tenants/Users
- **Room Browsing**: View all available rooms with detailed information
- **Room Details**: Check room specifications, pricing, and real-time availability
- **Booking System**: Submit rental applications with time slot selection
- **Status Tracking**: Track application status (pending, approved, rejected, completed)
- **Invoice Generation**: Download rental invoices for approved bookings

## Technical Stack
- **Backend**: Laravel 10.x PHP Framework
- **Frontend**: Bootstrap 5.x, jQuery, AJAX
- **Database**: MySQL
- **Image Storage**: Cloudinary
- **Authentication**: Laravel built-in authentication
- **Calendar/Scheduling**: FullCalendar.js
- **PDF Generation**: DomPDF

## System Requirements
- PHP 8.1 or 8.2
- MySQL 5.7 or higher
- Composer
- Node.js and NPM (for frontend asset compilation)
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
   ```
   https://github.com/tutupharirabu/Project-BTP.git
   cd Project-BTP/prototype-BTP
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Copy environment file and configure database settings:
   ```
   cp .env.example .env
   ```

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Run database migrations and seed data:
   ```
   php artisan migrate --seed
   ```

6. Link storage for public file access:
   ```
   php artisan storage:link
   ```

7. Configure Cloudinary credentials in the .env file:
   ```
   CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
   CLOUDINARY_UPLOAD_PRESET=your_upload_preset
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

## User Roles
- **Admin/Staff**: Full access to room management, booking approvals, and reporting
- **Tenant/User**: Access to room browsing, booking, and status tracking

## Default Login Credentials
- **Admin**
  - Email: petugasBTP@gmail.com
  - Password: admin123!

## Documentation
The application follows Laravel's MVC architecture:
- **Models**: Located in `app/Models/`
- **Controllers**: Located in `app/Http/Controllers/`
- **Views**: Located in `resources/views/`
- **Routes**: Defined in `routes/web.php`

## Contributors
This project was developed by the BTP development team.

## License
This project is proprietary and belongs to Bandung Techno Park. Unauthorized use, distribution, or modification is prohibited.
