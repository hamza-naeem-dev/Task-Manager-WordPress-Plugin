# 📝 WordPress Task Manager Plugin

A custom **WordPress Task Manager Plugin** that allows users to create, manage, and display tasks using frontend forms and Custom Post Types.

---

# 🚀 Features

- Create tasks using frontend form (shortcode-based)  
- Display tasks dynamically using WP_Query  
- Store task data using Custom Post Types  
- Update task status using post meta  
- Secure form handling with validation and sanitization  
- Prevent duplicate submissions using Post-Redirect-Get pattern  

---

# 🛠 Technologies Used

### Backend
- PHP  
- WordPress Plugin API  
- Custom Post Types (CPT)  
- Post Meta API  
- WP_Query  

### Frontend
- HTML  
- CSS  
- JavaScript (basic DOM handling)  

---

# 📸 Screenshots

![Task Form](https://github.com/hamza-naeem-dev/Task-Manager-WordPress-Plugin/blob/main/assets/Task%20Manager%20Form.png)
![Task List](https://github.com/hamza-naeem-dev/Task-Manager-WordPress-Plugin/blob/main/assets/Task%20Manager%20List.png)
![Task List Edit](https://github.com/hamza-naeem-dev/Task-Manager-WordPress-Plugin/blob/main/assets/Task%20List%20Edit%20Functionality.png)

---

# 📦 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/hamza-naeem-dev/Task-Manager-WordPress-Plugin.git

Move it to:

wp-content/plugins/
Activate plugin from WordPress dashboard
🧩 Usage
Add Task Form
[task_manager_form]
Display Task List
[task_manager_list]
⚙️ How It Works
User submits a task using the form
Data is validated and sanitized
Task is stored as a Custom Post Type
Task status is managed using post meta
Tasks are displayed dynamically using WP_Query
🧠 Learning Highlights
Building a full CRUD-like system using WordPress
Managing data using Custom Post Types and post meta
Implementing secure form handling
Using WP_Query for dynamic frontend rendering
⚠️ Future Improvements
Add task editing and deletion
Add AJAX functionality
Add user-based task filtering
Improve UI with Bootstrap
📌 Author

Hamza Naeem

📄 License

GPL2
