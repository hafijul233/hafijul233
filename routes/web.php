<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Backend\Common\AddressBookController;
use App\Http\Controllers\Backend\Common\NotificationController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Model\ModelEnabledController;
use App\Http\Controllers\Backend\Model\ModelRestoreController;
use App\Http\Controllers\Backend\Model\ModelSoftDeleteController;
use App\Http\Controllers\Backend\Organization\EnumeratorController;
use App\Http\Controllers\Backend\Organization\SurveyController;
use App\Http\Controllers\Backend\OrganizationController;
use App\Http\Controllers\Backend\Setting\CatalogController;
use App\Http\Controllers\Backend\Setting\CityController;
use App\Http\Controllers\Backend\Setting\CountryController;
use App\Http\Controllers\Backend\Setting\ExamGroupController;
use App\Http\Controllers\Backend\Setting\PermissionController;
use App\Http\Controllers\Backend\Setting\RoleController;
use App\Http\Controllers\Backend\Setting\StateController;
use App\Http\Controllers\Backend\Setting\UserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\Organization\ApplicantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to('applicant-registration');
})->name('home');


//Frontend
Route::middleware(['guest'])->name('frontend.')->group(function () {
    Route::name('organization.')->group(function () {
        Route::get('applicant-registration', [ApplicantController::class, 'create'])
            ->name('applicants.create');

        Route::post('applicant-registration', [ApplicantController::class, 'store'])
            ->name('applicants.store');
    });
});


Route::prefix('backend')->group(function () {
    /**
     * Authentication Route
     */
    Route::name('auth.')->group(function () {

        Route::view('/privacy-terms', 'auth::terms')->name('terms');

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('guest')
            ->name('login');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest');

        if (config('auth.allow_register')):
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('register');

            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');
        endif;

        if (config('auth.allow_password_reset')):
            Route::get('/forgot-password', [PasswordResetController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');
        endif;

        Route::post('/forgot-password', [PasswordResetController::class, 'store'])
            ->middleware('guest')
            ->name('password.email');

        Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])
            ->middleware('guest')
            ->name('password.reset');

        Route::post('/reset-password', [PasswordResetController::class, 'update'])
            ->middleware('guest')
            ->name('password.update');

        Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
            ->middleware('auth')
            ->name('verification.notice');

        Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['auth', 'signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['auth', 'throttle:6,1'])
            ->name('verification.send');

        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware('auth')
            ->name('password.confirm');

        Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
            ->middleware('auth');

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');
    });

    /**
     * Admin Panel/ Backend Route
     */
    Route::get('/', function () {
        return redirect(\route('backend.dashboard'));
    })->name('backend');

    Route::middleware(['auth'])->name('backend.')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        //Common Operations
        Route::prefix('common')->name('common.')->group(function () {
            Route::get('delete/{route}/{id}', ModelSoftDeleteController::class)->name('delete');
            Route::get('restore/{route}/{id}', ModelRestoreController::class)->name('restore');
            Route::get('enabled', ModelEnabledController::class)->name('enabled');
            //Notification
            Route::resource('notifications', NotificationController::class);

            //Address Book
            Route::resource('address-books', AddressBookController::class)->where(['address-book' => '([0-9]+)']);
            Route::prefix('address-books')->name('address-books.')->group(function () {
                Route::patch('{address-book}/restore', [AddressBookController::class, 'restore'])->name('restore');
                Route::get('export', [AddressBookController::class, 'export'])->name('export');
                Route::get('import', [AddressBookController::class, 'import'])->name('import');
                Route::post('import', [AddressBookController::class, 'importBulk']);
                Route::post('print', [AddressBookController::class, 'print'])->name('print');
            });
        });


        //Organization
        Route::get('organization', OrganizationController::class)->name('organization');
        Route::prefix('organization')->name('organization.')->group(function () {
            //Survey
            Route::prefix('surveys')->name('surveys.')->group(function () {
                Route::patch('{survey}/restore', [SurveyController::class, 'restore'])->name('restore');
                Route::get('export', [SurveyController::class, 'export'])->name('export');
                Route::get('import', [SurveyController::class, 'import'])->name('import');
                Route::post('import', [SurveyController::class, 'importBulk']);
                Route::post('print', [SurveyController::class, 'print'])->name('print');
            });
            Route::resource('surveys', SurveyController::class)->where(['survey' => '([0-9]+)']);


            //Enumerator
            Route::prefix('enumerators')->name('enumerators.')->group(function () {
                Route::patch('{survey}/restore', [EnumeratorController::class, 'restore'])->name('restore');
                Route::get('export', [EnumeratorController::class, 'export'])->name('export');
                Route::get('import', [EnumeratorController::class, 'import'])->name('import');
                Route::post('import', [EnumeratorController::class, 'importBulk']);
                Route::post('print', [EnumeratorController::class, 'print'])->name('print');
            });
            Route::resource('enumerators', EnumeratorController::class)->where(['enumerator' => '([0-9]+)']);

        });

        //Setting
        Route::get('settings', SettingController::class)->name('settings');
        Route::prefix('settings')->name('settings.')->group(function () {
            //User
            Route::prefix('users')->name('users.')->group(function () {
                Route::patch('{user}/restore', [UserController::class, 'restore'])->name('restore');
                Route::get('export', [UserController::class, 'export'])->name('export');
                Route::get('import', [UserController::class, 'import'])->name('import');
                Route::post('import', [UserController::class, 'importBulk']);
                Route::post('print', [UserController::class, 'print'])->name('print');
            });
            Route::resource('users', UserController::class)->where(['user' => '([0-9]+)']);

            //Permission
            Route::prefix('permissions')->name('permissions.')->group(function () {
                Route::patch('{permission}/restore', [PermissionController::class, 'restore'])->name('restore');
                Route::get('/export', [PermissionController::class, 'export'])->name('export');
                Route::get('/import', [PermissionController::class, 'import'])->name('import');
                Route::post('/import', [PermissionController::class, 'importBulk']);
                Route::post('/print', [PermissionController::class, 'print'])->name('print');
            });
            Route::resource('permissions', PermissionController::class)->where(['permission' => '([0-9]+)']);

            //Role
            Route::prefix('roles')->name('roles.')->group(function () {
                Route::patch('{role}/restore', [RoleController::class, 'restore'])->name('restore');
                Route::get('permission', [RoleController::class, 'permission'])->name('permission');
                Route::get('export', [RoleController::class, 'export'])->name('export');
                Route::get('import', [RoleController::class, 'import'])->name('import');
                Route::post('import', [RoleController::class, 'importBulk']);
                Route::post('print', [RoleController::class, 'print'])->name('print');
                Route::get('ajax', [RoleController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('roles', RoleController::class)->where(['role' => '([0-9]+)']);

            //Catalogs
            Route::prefix('catalogs')->name('catalogs.')->group(function () {
                Route::patch('{catalog}/restore', [CatalogController::class, 'restore'])->name('restore');
                Route::get('export', [CatalogController::class, 'export'])->name('export');
                Route::get('import', [CatalogController::class, 'import'])->name('import');
                Route::post('print', [CatalogController::class, 'print'])->name('print');
                Route::get('ajax', [CatalogController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('catalogs', CatalogController::class)->where(['catalog' => '([0-9]+)']);

            //Country
            Route::prefix('countries')->name('countries.')->group(function () {
                Route::patch('{country}/restore', [CountryController::class, 'restore'])->name('restore');
                Route::get('export', [CountryController::class, 'export'])->name('export');
                Route::get('import', [CountryController::class, 'import'])->name('import');
                Route::post('import', [CountryController::class, 'importBulk']);
                Route::post('print', [CountryController::class, 'print'])->name('print');
            });
            Route::resource('countries', CountryController::class)->where(['country' => '([0-9]+)']);

            //State
            Route::prefix('states')->name('states.')->group(function () {
                Route::patch('{state}/restore', [StateController::class, 'restore'])->name('restore');
                Route::get('/export', [StateController::class, 'export'])->name('export');
                Route::get('/import', [StateController::class, 'import'])->name('import');
                Route::post('/import', [StateController::class, 'importBulk']);
                Route::post('/print', [StateController::class, 'print'])->name('print');
                Route::get('ajax', [StateController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('states', StateController::class)->where(['state' => '([0-9]+)']);

            //City
            Route::prefix('cities')->name('cities.')->group(function () {
                Route::patch('{city}/restore', [CityController::class, 'restore'])->name('restore');
                Route::get('export', [CityController::class, 'export'])->name('export');
                Route::get('import', [CityController::class, 'import'])->name('import');
                Route::post('import', [CityController::class, 'importBulk']);
                Route::post('print', [CityController::class, 'print'])->name('print');
                Route::get('ajax', [CityController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('cities', CityController::class)->where(['city' => '([0-9]+)']);

            //Exam Group
            Route::prefix('exam-groups')->name('exam-groups.')->group(function () {
                /*Route::patch('{exam-group}/restore', [ExamGroupController::class, 'restore'])->name('restore');
                Route::get('/export', [ExamGroupController::class, 'export'])->name('export');
                Route::get('/import', [ExamGroupController::class, 'import'])->name('import');
                Route::post('/import', [ExamGroupController::class, 'importBulk']);
                Route::post('/print', [ExamGroupController::class, 'print'])->name('print');
                */
                Route::get('ajax', [ExamGroupController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('exam-groups', ExamGroupController::class)->where(['exam-group' => '([0-9]+)']);

        });
    });

});
