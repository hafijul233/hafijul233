<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Backend\Blog\CommentController;
use App\Http\Controllers\Backend\Blog\NewsLetterController;
use App\Http\Controllers\Backend\Blog\PostController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Model\ModelEnabledController;
use App\Http\Controllers\Backend\Model\ModelRestoreController;
use App\Http\Controllers\Backend\Model\ModelSoftDeleteController;
use App\Http\Controllers\Backend\Portfolio\CertificateController;
use App\Http\Controllers\Backend\Portfolio\ProjectController;
use App\Http\Controllers\Backend\Portfolio\ServiceController;
use App\Http\Controllers\Backend\Portfolio\TestimonialController;
use App\Http\Controllers\Backend\PortfolioController;
use App\Http\Controllers\Backend\Resume\AwardController;
use App\Http\Controllers\Backend\Resume\EducationController;
use App\Http\Controllers\Backend\Resume\ExperienceController;
use App\Http\Controllers\Backend\Resume\LanguageController;
use App\Http\Controllers\Backend\Resume\SkillController;
use App\Http\Controllers\Backend\ResumeController;
use App\Http\Controllers\Backend\Setting\CatalogController;
use App\Http\Controllers\Backend\Setting\ExamGroupController;
use App\Http\Controllers\Backend\Setting\PermissionController;
use App\Http\Controllers\Backend\Setting\RoleController;
use App\Http\Controllers\Backend\Setting\StateController;
use App\Http\Controllers\Backend\Setting\UserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\TranslateController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/**
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

Route::get('/', function () {
    return redirect()->to('backend/login');
})->name('home');

Route::post('translate-locale', TranslateController::class)->name('translate-locale');

Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
});

//Frontend
/*Route::name('frontend.')->group(function () {
    Route::name('portfolio.')->group(function () {
        Route::get('applicant-registration', [ApplicantController::class, 'create'])
            ->name('applicants.create')->middleware('guest');

        Route::post('applicant-registration', [ApplicantController::class, 'store'])
            ->name('applicants.store');
    });
});*/


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
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        //Common Operations
        Route::prefix('common')->name('common.')->group(function () {
            Route::get('delete/{route}/{id}', ModelSoftDeleteController::class)->name('delete');
            Route::get('restore/{route}/{id}', ModelRestoreController::class)->name('restore');
            Route::get('enabled', ModelEnabledController::class)->name('enabled');
        });

        //Portfolio
        Route::get('portfolio', PortfolioController::class)->name('portfolio');
        Route::prefix('portfolio')->name('portfolio.')->group(function () {
            //Service
            Route::prefix('services')->name('services.')->group(function () {
                Route::patch('{service}/restore', [ServiceController::class, 'restore'])->name('restore');
                Route::get('export', [ServiceController::class, 'export'])->name('export');
            });
            Route::resource('services', ServiceController::class)->where(['service' => '([0-9]+)']);

            //Certificate
            Route::prefix('certificates')->name('certificates.')->group(function () {
                Route::patch('{certificate}/restore', [CertificateController::class, 'restore'])->name('restore');
                Route::get('export', [CertificateController::class, 'export'])->name('export');
            });
            Route::resource('certificates', CertificateController::class)->where(['certificate' => '([0-9]+)']);

            //Project
            Route::prefix('projects')->name('projects.')->group(function () {
                Route::patch('{project}/restore', [ProjectController::class, 'restore'])->name('restore');
                Route::get('export', [ProjectController::class, 'export'])->name('export');
            });
            Route::resource('projects', ProjectController::class)->where(['project' => '([0-9]+)']);

            //Testimonial
            Route::prefix('testimonials')->name('testimonials.')->group(function () {
                Route::patch('{testimonial}/restore', [TestimonialController::class, 'restore'])->name('restore');
                Route::get('export', [TestimonialController::class, 'export'])->name('export');
            });
            Route::resource('testimonials', TestimonialController::class)->where(['testimonial' => '([0-9]+)']);
        });

        //Resume
        Route::get('resume', ResumeController::class)->name('resume');
        Route::prefix('resume')->name('resume.')->group(function () {
            //experience
            Route::prefix('experiences')->name('experiences.')->group(function () {
                Route::patch('{experience}/restore', [ExperienceController::class, 'restore'])->name('restore');
                Route::get('export', [ExperienceController::class, 'export'])->name('export');
            });
            Route::resource('experiences', ExperienceController::class)->where(['experience' => '([0-9]+)']);

            //education
            Route::prefix('educations')->name('educations.')->group(function () {
                Route::patch('{education}/restore', [EducationController::class, 'restore'])->name('restore');
                Route::get('export', [EducationController::class, 'export'])->name('export');
            });
            Route::resource('educations', EducationController::class)->where(['education' => '([0-9]+)']);

            //award
            Route::prefix('awards')->name('awards.')->group(function () {
                Route::patch('{award}/restore', [AwardController::class, 'restore'])->name('restore');
                Route::get('export', [AwardController::class, 'export'])->name('export');
            });
            Route::resource('awards', AwardController::class)->where(['award' => '([0-9]+)']);

            //skill
            Route::prefix('skills')->name('skills.')->group(function () {
                Route::patch('{skill}/restore', [SkillController::class, 'restore'])->name('restore');
                Route::get('export', [SkillController::class, 'export'])->name('export');
            });
            Route::resource('skills', SkillController::class)->where(['skill' => '([0-9]+)']);

            //language
            Route::prefix('languages')->name('languages.')->group(function () {
                Route::patch('{language}/restore', [LanguageController::class, 'restore'])->name('restore');
                Route::get('export', [LanguageController::class, 'export'])->name('export');
            });
            Route::resource('languages', LanguageController::class)->where(['language' => '([0-9]+)']);
        });

        //Blog
        Route::get('blog', BlogController::class)->name('blog');
        Route::prefix('blog')->name('blog.')->group(function () {
            //Post
            Route::prefix('posts')->name('posts.')->group(function () {
                Route::patch('{post}/restore', [PostController::class, 'restore'])->name('restore');
                Route::get('export', [PostController::class, 'export'])->name('export');
            });
            Route::resource('posts', PostController::class)->where(['post' => '([0-9]+)']);

            //Comment
            Route::prefix('comments')->name('comments.')->group(function () {
                Route::patch('{comment}/restore', [CommentController::class, 'restore'])->name('restore');
                Route::get('export', [CommentController::class, 'export'])->name('export');
            });
            Route::resource('comments', CommentController::class)->where(['comment' => '([0-9]+)']);

            //Newsletter
            Route::prefix('newsletters')->name('newsletters.')->group(function () {
                Route::patch('{newsletter}/restore', [NewsLetterController::class, 'restore'])->name('restore');
                Route::get('export', [NewsLetterController::class, 'export'])->name('export');
            });
            Route::resource('newsletters', NewsLetterController::class)->where(['newsletter' => '([0-9]+)']);
        });

        //Setting
        Route::get('settings', SettingController::class)->name('settings');
        Route::prefix('settings')->name('settings.')->group(function () {
            //User
            Route::prefix('users')->name('users.')->group(function () {
                Route::patch('{user}/restore', [UserController::class, 'restore'])->name('restore');
                Route::get('export', [UserController::class, 'export'])->name('export');
            });
            Route::resource('users', UserController::class)->where(['user' => '([0-9]+)']);

            //Permission
            Route::prefix('permissions')->name('permissions.')->group(function () {
                Route::patch('{permission}/restore', [PermissionController::class, 'restore'])->name('restore');
                Route::get('/export', [PermissionController::class, 'export'])->name('export');
            });
            Route::resource('permissions', PermissionController::class)->where(['permission' => '([0-9]+)']);

            //Role
            Route::prefix('roles')->name('roles.')->group(function () {
                Route::patch('{role}/restore', [RoleController::class, 'restore'])->name('restore');
                Route::put('{role}/permission', [RoleController::class, 'permission'])
                    ->name('permission')->where(['role' => '([0-9]+)']);
                Route::get('export', [RoleController::class, 'export'])->name('export');
                Route::get('ajax', [RoleController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('roles', RoleController::class)->where(['role' => '([0-9]+)']);

            //Catalogs
            Route::prefix('catalogs')->name('catalogs.')->group(function () {
                Route::patch('{catalog}/restore', [CatalogController::class, 'restore'])->name('restore');
                Route::get('export', [CatalogController::class, 'export'])->name('export');
                Route::get('ajax', [CatalogController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('catalogs', CatalogController::class)->where(['catalog' => '([0-9]+)']);

            //State
            Route::prefix('states')->name('states.')->group(function () {
                Route::patch('{state}/restore', [StateController::class, 'restore'])->name('restore');
                Route::get('/export', [StateController::class, 'export'])->name('export');
                Route::get('ajax', [StateController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('states', StateController::class)->where(['state' => '([0-9]+)']);

            //Exam Group
            Route::prefix('exam-groups')->name('exam-groups.')->group(function () {
                Route::get('ajax', [ExamGroupController::class, 'ajax'])->name('ajax')->middleware('ajax')->withoutMiddleware('auth');
            });
            Route::resource('exam-groups', ExamGroupController::class)->where(['exam-group' => '([0-9]+)']);
        });
    });
});
