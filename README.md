# 🚀 Bitlab/Gitlab Projects Dashboard 🖥️

BitlabProjects is a web application that provides an easy-to-use interface for managing and tracking your projects on Bitlab. The dashboard offers a comprehensive view of your repositories, including recent activity, commits, issues, and merge requests. It also features a notification system 🛎️ to keep you informed of important updates.

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F24e13158-4784-45f1-b123-6dcd7ef6847d%3Fdate%3D1&style=for-the-badge)](https://forge.laravel.com/servers/687741/sites/2003781)

## 🌟 Features

- List all projects with pagination and sorting options 📑
- View project details, including description, last updated, and star count 🌠
- View project activity and recent commits 📊
- Access individual repositories on Bitlab with a single click 👆
- Copy the clone URL of a repository with a single button 📋
- Able to search for projects by name 🔍
- Dark mode support 🌙

## 🚧 Features in Development

- [ ] Mobile UI Project Search

## 🐛 Bugs

- [ ] Copy to clipboard
- [ ] Repository Stats(Commits & Branch count)

## 🛠️ Installation

To get started with BitlabProjects, follow these steps:

1. Clone the repository:

```git clone https://github.com/Ssionn/BitlabProjects.git```

2. Navigate to the project folder:

```cd BitlabProjects```

3. Install the required dependencies:

```composer install```

```npm install```

4. Copy the `.env.example` file to a new `.env` file:

```cp .env.example .env```

5. Generate an application key:

```php artisan key:generate```

6. Configure your `.env` file with the appropriate settings, such as database connection and API credentials. 🔧

7. Run the database migrations and seeders:

```php artisan migrate --seed```

8. Start the local development server. If you are a Mac user, it is recommended to use [Laravel Valet](https://laravel.com/docs/valet). The built-in PHP server also works:

```php artisan serve```

9. This project uses TailwindCSS, run this npm command:

```npm run dev```

10. Visit the dashboard in your web browser at `http://localhost:8000` or the appropriate Laravel Valet URL. 🌐

## 📄 License

This project is licensed under the Apache License 2.0. See the [LICENSE](LICENSE) file for more information.

Credit: Created by [Ssionn](https://github.com/Ssionn) 👏
