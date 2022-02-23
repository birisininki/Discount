<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserTypeRepositoryInterface;
use App\Repositories\RequestTypeRepository;
use App\Interfaces\RequestTypeRepositoryInterface;
use App\Repositories\RequestRepository;
use App\Interfaces\RequestRepositoryInterface;
use App\Repositories\UserTypeRepository;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\EmployeePermissionRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeePermissionRepository;
use App\Interfaces\LogRepositoryInterface;
use App\Repositories\LogRepository;
use App\Interfaces\MessageTemplateRepositoryInterface;
use App\Repositories\MessageTemplateRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeePermissionRepositoryInterface::class, EmployeePermissionRepository::class);
        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
        $this->app->bind(RequestRepositoryInterface::class, RequestRepository::class);
        $this->app->bind(RequestTypeRepositoryInterface::class, RequestTypeRepository::class);
        $this->app->bind(MessageTemplateRepositoryInterface::class, MessageTemplateRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
