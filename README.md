# PHP_Laravel12_Roch_PHP_Core
```php
- Laravel 12 based project demonstrating Clean Architecture (Roch PHP Core Pattern)
using Service & Repository layers with Blade based Browser UI.
```


# Step 1: Install Laravel 12 – Create Project
```php
- We create a fresh Laravel 12 project to implement Roch PHP Core architecture.
```
Open Terminal / CMD
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_Roch_PHP_Core
```
Move to Project Folder
```php
cd PHP_Laravel12_Roch_PHP_Core
```
Generate Application Key
```php
php artisan key:generate
```

# Explanation
```php
- Laravel uses an application key for encryption and security.
- Without APP_KEY, sessions and encrypted data will not work properly.
```

# Step 2: Setup Database (.env File)

Open .env file and configure database:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=roch_php_core_db
DB_USERNAME=root
DB_PASSWORD=
```

Create database in MySQL:
```php
CREATE DATABASE roch_php_core_db;
```


Run default migrations:
```php
php artisan migrate
```

# Explanation
```php
- This step verifies database connectivity
- Default Laravel tables are created successfully
```

# Step 3: What is Roch PHP Core Architecture?
```php
Roch PHP Core is an architecture pattern (not a package).
It separates responsibilities into layers for clean and scalable code.

Architecture Flow
Controller → Service (Core) → Repository → Model → Database
```
# Explanation
```php
- Controller: Handles request & response only
- Service: Contains business logic
- Repository: Handles database queries
- Model: Represents database table
- Blade: Handles UI rendering
```

# Step 4: Create Core Folder Structure

Create Core folders inside app directory:
```php
mkdir app/Core
mkdir app/Core/Services
mkdir app/Core/Repositories
```

# Explanation
```php
- All business logic is placed inside Core
- Controllers remain thin and clean
- Easy to maintain and extend
```

# Step 5: Create User Module (Model + Migration)

Create model with migration:
```php
php artisan make:model User -m
```

Migration file (database/migrations/...create_users_table.php):

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```


Run migration:
```php
php artisan migrate
```

# Explanation
```php
- Users table stores application user data
- Migration ensures version-controlled database structure
```

# Step 6: Create Repository (Database Layer)

Path
```php
app/Core/Repositories/UserRepository.php
```
```php
<?php

namespace App\Core\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::latest()->get();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        return User::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
```

# Explanation
```php
- Repository handles ONLY database operations
- No business logic is written here
```

# Step 7: Create Service (Business Logic Layer)

Path
```php
app/Core/Services/UserService.php
```
```php
<?php

namespace App\Core\Services;

use App\Core\Repositories\UserRepository;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listUsers()
    {
        return $this->repo->all();
    }

    public function storeUser($data)
    {
        return $this->repo->create($data);
    }

    public function getUser($id)
    {
        return $this->repo->find($id);
    }

    public function updateUser($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->repo->delete($id);
    }
}
```

# Explanation
```php
- Service contains business rules
- Same service can be reused in Web, Admin, or API
```

# Step 8: Create Controller

Create controller:
```php
php artisan make:controller UserController
```
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->listUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $this->service->storeUser($request->only('name','email'));
        return redirect()->route('users.index')->with('success','User Created');
    }

    public function edit($id)
    {
        $user = $this->service->getUser($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateUser($id, $request->only('name','email'));
        return redirect()->route('users.index')->with('success','User Updated');
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);
        return redirect()->route('users.index')->with('success','User Deleted');
    }
}
```

# Explanation
```php
- Controller coordinates between UI and Core
- No heavy logic inside controller
```

# Step 9: Define Web Routes

Open file:
```php
routes/web.php
```

Add routes:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);

Route::get('/users', [UserController::class,'index'])->name('users.index');
Route::get('/users/create', [UserController::class,'create'])->name('users.create');
Route::post('/users', [UserController::class,'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
Route::post('/users/{id}', [UserController::class,'update'])->name('users.update');
Route::get('/users/{id}/delete', [UserController::class,'destroy'])->name('users.delete');
```


# Explanation
```php
- Routes are browser based (not API)
- All CRUD operations are accessible via UI
```

# Step 10: Blade UI (Browser Output)

Blade files structure:
```php
resources/views/users/
 ├── index.blade.php
 ├── create.blade.php
 └── edit.blade.php
```


# Step 11: Run Laravel Project

Run server:
```php
php artisan serve
```

Open Browser:
```php
http://127.0.0.1:8000/users
```
<img width="800" height="397" alt="image" src="https://github.com/user-attachments/assets/36e511aa-0549-40ce-a2b1-dbc57da2b130" />

# Project Folder Structure
```php
PHP_Laravel12_Roch_PHP_Core
├── app
│   ├── Core
│   │   ├── Services
│   │   │   └── UserService.php
│   │   └── Repositories
│   │       └── UserRepository.php
│   ├── Http
│   │   └── Controllers
│   │       └── UserController.php
│   └── Models
│       └── User.php
│
├── resources
│   └── views
│       └── users
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
│
├── routes
│   └── web.php
│
├── .env
├── artisan
```

# Explanation
```php
- Clean Architecture (Service + Repository)
- Thin Controllers
- Business logic separation
- Easy debugging & maintenance
- Scalable for large applications
- Enterprise ready Laravel structure
```


