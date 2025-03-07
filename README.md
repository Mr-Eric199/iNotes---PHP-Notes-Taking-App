# iNotes - Notes Taking App

## 📌 About
**iNotes** is a simple **CRUD-based** note-taking web application built with **PHP & MySQLi**. It allows users to **Create, Read, Update, and Delete (CRUD)** notes efficiently. The application ensures security with **prepared statements** and **input sanitization** to prevent SQL injection and XSS attacks.

## 🚀 Features
- 📝 **Add Notes** with title and description
- ✏️ **Edit Notes** through a modal form
- 🗑️ **Delete Notes** with confirmation
- 📋 **Display Notes** in a table using **DataTables**
- 🔐 **Secure Code** with prepared statements
- 🎨 **Responsive UI** built with **Bootstrap 5**

## 🛠️ Installation

### 1️⃣ Clone the Repository
```bash
$ git clone https://github.com/your-username/iNotes.git
$ cd iNotes
```

### 2️⃣ Configure Database
1. Create a MySQL database: `notes`
2. Import the `notes.sql` file (if provided) or create the table manually:
```sql
CREATE TABLE `notes` (
    `sno` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL
);
```

### 3️⃣ Update Database Connection
Modify the database connection in `index.php`:
```php
$server = "localhost";
$user = "root";
$password = "root";
$database = "notes";
$conn = new mysqli($server, $user, $password, $database);
```

### 4️⃣ Start Local Server
Run a local server using PHP:
```bash
$ php -S localhost:8000
```
Then, visit `http://localhost:8000` in your browser.


## 💡 Technologies Used
- **PHP (MySQLi)** – Backend processing
- **MySQL** – Database for storing notes
- **Bootstrap 5** – UI styling
- **JavaScript & jQuery** – Frontend interactions
- **DataTables.js** – Enhanced tables

## 🛡️ Security Measures
✅ **Prepared statements** to prevent SQL Injection
✅ **Input sanitization** to avoid XSS attacks
✅ **Error handling** for safe database interactions

## 🎯 Future Improvements
- ✅ User authentication (Login/Signup)
- ✅ Note categories & search
- ✅ File attachments for notes
- ✅ Dark mode toggle

## 🤝 Contributing
Want to contribute? Feel free to fork the repo, create a new branch, and submit a pull request!
```bash
$ git checkout -b feature-branch
$ git commit -m "Your feature description"
$ git push origin feature-branch
```



**🔗 Connect with me:** [My LinkedIn](inkedin.com/in/eric-antwi-fc/) 

