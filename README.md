# **Welcome to the Laravel Backend for TransitTrack** 👋

## **About the Application**

This backend application is built using Laravel and serves as the core for managing data and operations for the TransitTrack system. It supports various functionalities required by the web and mobile applications.

## **Getting Started**

Follow these steps to set up and run the Laravel backend:

### **Prerequisites**

- Ensure you have PHP, Composer, and a web server like XAMPP installed on your machine.
- Install an IDE like Visual Studio Code.

### **Setup Instructions**

1. **Open Command Prompt or Terminal**

   - Navigate to the project directory:
     ```sh
     cd CATRANCO-FMS-Backend
     ```

2. **Open the Project in Your IDE**

   - Use the following command to open the project in Visual Studio Code:
     ```sh
     code .
     ```

3. **Install Composer Dependencies**

   - Run the following command to install all necessary dependencies:
     ```sh
     composer install
     ```

4. **Decrypt the Environment File**

   - Decrypt the `.env` file using the following command:
     ```sh
     php artisan env:decrypt --force --key=base64:0rPEg5jGaTu42J4qqE3vTy1MpMsFDy2CxvtDI8eaHrQ=
     ```

5. **Start XAMPP Control Panel**

   - Start the Apache and MySQL services.

6. **Migrate and Seed the Database**

   - Migrate the database:
     ```sh
     php artisan migrate
     ```
   - Seed the database:
     ```sh
     php artisan db:seed
     ```

7. **Run the Backend Server**

   - Use the following command to run the backend server:
     ```sh
     php artisan serve
     ```
   - For specific host and port, use:
     ```sh
     php artisan serve --host=192.168.1.102 --port=8000
     ```

## **Additional Resources**

- [Pusher](https://pusher.com/)
- [Flespi](https://flespi.io/)
- [Google API](https://console.developers.google.com/)
- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [XAMPP](https://www.apachefriends.org/download.html)