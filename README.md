<p align="center"><a href="https://laravel.com" target="_blank"><img width="220" height="220" alt="LCBA LOGO VECTOR" src="https://github.com/user-attachments/assets/de007c36-249f-4b5f-88e1-0956fa9b81ef" width="400" alt="Laravel Logo"></a></p>



# LCBA Administrative Dashboard

A web-based administrative dashboard built for Laguna College of Business and Arts (LCBA) to assist the Registrar and Guidance Office in reviewing and managing student checklists.

The system streamlines the process of monitoring student requirements, improving administrative efficiency and reducing manual record verification.

##
**Overview**

The LCBA Administrative Dashboard is designed to centralize student checklist management. It allows administrative personnel to easily review, verify, and track student compliance with institutional requirements.

The dashboard provides a structured interface for handling student records, helping ensure that both the Registrar and Guidance Office can monitor checklist completion efficiently.

## Features

- **Student Checklist Monitoring**
- **Student Record View**
- **Registrar Checklist Forms**
- **Role Based Access**
- **Organized and up to date student enrollment checklist**
- **Responsive and modern interface**
  
## Technology Stack

- **Backend : Laravel**
- **Frontend : Blade/HTML/CSS/JavaScript/Tailwind**
- **Database : MySQL**
- **Framework :**
## Database Migration (FOR TESTERS)
1. **Prepare the Target Machine**
>`npm install`\
>`composer install`
2. **Environment Configuration**
- Go to the .env file
- Ensure the _DB_DATABASE_ is set to _lcba_mis_
- Create the database in PHPmyAdmin
    - Go to _http://localhost/phpmyadmin/_
    - Click New
    - Name it _lcba_mis_ and click *Create*
3. Initialize Table Structure
>`php artisan migrate`
4. Import Registry Dump
- Click Import in the _lcba_mis_ sidebar
- Choose file
- Import
- Once verified run the command below:
>`php artisan serve`
       
## License

Developed and Designed by the LCBA SMIS
