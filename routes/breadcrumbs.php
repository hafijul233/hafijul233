<?php

use App\Models\Backend\Portfolio\Service;
use App\Models\Backend\Setting\Catalog;
use App\Models\Backend\Setting\City;
use App\Models\Backend\Setting\Country;
use App\Models\Backend\Setting\Permission;
use App\Models\Backend\Setting\Role;
use App\Models\Backend\Setting\State;
use App\Models\Backend\Setting\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('menu-sidebar.Home'), route('home'));
});

/****************************************** Http Error ******************************************/

Breadcrumbs::for('frontend.portfolio.applicants.create', function ($trail) {
   $trail->parent('home');
    $trail->push(__('certificate.Applicant Registration'), route('frontend.portfolio.applicants.create'));
});

Breadcrumbs::for('backend', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('menu-sidebar.Backend'), route('backend'));
});

Breadcrumbs::for('backend.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('menu-sidebar.Dashboard'), route('backend.dashboard'));
});

/****************************************** Http Error ******************************************/

Breadcrumbs::for('errors.401', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Unauthorized'));
});

Breadcrumbs::for('errors.403', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Forbidden'));
});

Breadcrumbs::for('errors.404', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Page Not Found'));
});

Breadcrumbs::for('errors.419', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push('Page Expired');
});

Breadcrumbs::for('errors.429', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Too Many Requests'));
});

Breadcrumbs::for('errors.500', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Server Error'));
});

Breadcrumbs::for('errors.503', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Service Unavailable'));
});

/****************************************** Setting ******************************************/

Breadcrumbs::for('backend.settings', function (BreadcrumbTrail $trail) {

    $trail->parent('home');

    $trail->push(__('menu-sidebar.Settings'), route('backend.settings'));
});

/****************************************** User ******************************************/

Breadcrumbs::for('backend.settings.users.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Users'), route('backend.settings.users.index'));
});

Breadcrumbs::for('backend.settings.users.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.users.index');

    $trail->push('Add', route('backend.settings.users.create'));
});

Breadcrumbs::for('backend.settings.users.show', function (BreadcrumbTrail $trail, $user) {

    $trail->parent('backend.settings.users.index');

    $user = ($user instanceof User) ? $user : $user[0];

    $trail->push($user->name, route('backend.settings.users.show', $user->id));
});

Breadcrumbs::for('backend.settings.users.edit', function (BreadcrumbTrail $trail, User $user) {

    $trail->parent('backend.settings.users.show', [$user]);

    $trail->push(__('common.Edit'), route('backend.settings.users.edit', $user->id));
});

/****************************************** Permission ******************************************/

Breadcrumbs::for('backend.settings.permissions.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Permissions'), route('backend.settings.permissions.index'));
});

Breadcrumbs::for('backend.settings.permissions.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.permissions.index');

    $trail->push(__('common.Add'), route('backend.settings.permissions.create'));
});

Breadcrumbs::for('backend.settings.permissions.show', function (BreadcrumbTrail $trail, $permission) {

    $trail->parent('backend.settings.permissions.index');

    $permission = ($permission instanceof Permission) ? $permission : $permission[0];

    $trail->push($permission->display_name, route('backend.settings.permissions.show', $permission->id));
});

Breadcrumbs::for('backend.settings.permissions.edit', function (BreadcrumbTrail $trail, Permission $permission) {

    $trail->parent('backend.settings.permissions.show', [$permission]);

    $trail->push(__('common.Edit'), route('backend.settings.permissions.edit', $permission->id));
});

/****************************************** Role ******************************************/

Breadcrumbs::for('backend.settings.roles.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Roles'), route('backend.settings.roles.index'));
});

Breadcrumbs::for('backend.settings.roles.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.roles.index');

    $trail->push(__('common.Add'), route('backend.settings.roles.create'));
});

Breadcrumbs::for('backend.settings.roles.show', function (BreadcrumbTrail $trail, $role) {

    $trail->parent('backend.settings.roles.index');

    $role = ($role instanceof Role) ? $role : $role[0];

    $trail->push($role->name, route('backend.settings.roles.show', $role->id));
});

Breadcrumbs::for('backend.settings.roles.edit', function (BreadcrumbTrail $trail, Role $role) {

    $trail->parent('backend.settings.roles.show', [$role]);

    $trail->push(__('common.Edit'), route('backend.settings.roles.edit', $role->id));
});


/****************************************** Catalog ******************************************/

Breadcrumbs::for('backend.settings.catalogs.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Catalogs'), route('backend.settings.catalogs.index'));
});

Breadcrumbs::for('backend.settings.catalogs.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.catalogs.index');

    $trail->push(__('common.Add'), route('backend.settings.catalogs.create'));
});

Breadcrumbs::for('backend.settings.catalogs.show', function (BreadcrumbTrail $trail, $catalog) {

    $trail->parent('backend.settings.catalogs.index');

    $catalog = ($catalog instanceof Catalog) ? $catalog : $catalog[0];

    $trail->push($catalog->name, route('backend.settings.catalogs.show', $catalog->id));
});

Breadcrumbs::for('backend.settings.catalogs.edit', function (BreadcrumbTrail $trail, Catalog $catalog) {

    $trail->parent('backend.settings.catalogs.show', [$catalog]);

    $trail->push(__('common.Edit'), route('backend.settings.catalogs.edit', $catalog->id));
});

/****************************************** Country ******************************************/

Breadcrumbs::for('backend.settings.countries.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Countries'), route('backend.settings.countries.index'));
});

Breadcrumbs::for('backend.settings.countries.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.countries.index');

    $trail->push(__('common.Add'), route('backend.settings.countries.create'));
});

Breadcrumbs::for('backend.settings.countries.show', function (BreadcrumbTrail $trail, $country) {

    $trail->parent('backend.settings.countries.index');

    $country = ($country instanceof Country) ? $country : $country[0];

    $trail->push($country->name, route('backend.settings.countries.show', $country->id));
});

Breadcrumbs::for('backend.settings.countries.edit', function (BreadcrumbTrail $trail, Country $country) {

    $trail->parent('backend.settings.countries.show', [$country]);

    $trail->push(__('common.Edit'), route('backend.settings.countries.edit', $country->id));
});

/****************************************** State ******************************************/

Breadcrumbs::for('backend.settings.states.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.States'), route('backend.settings.states.index'));
});

Breadcrumbs::for('backend.settings.states.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.states.index');

    $trail->push(__('common.Add'), route('backend.settings.states.create'));
});

Breadcrumbs::for('backend.settings.states.show', function (BreadcrumbTrail $trail, $state) {

    $trail->parent('backend.settings.states.index');

    $state = ($state instanceof State) ? $state : $state[0];

    $trail->push($state->name ?? '', route('backend.settings.states.show', $state->id));
});

Breadcrumbs::for('backend.settings.states.edit', function (BreadcrumbTrail $trail, State $state) {

    $trail->parent('backend.settings.states.show', [$state]);

    $trail->push(__('common.Edit'), route('backend.settings.states.edit', $state->id));
});

/****************************************** City ******************************************/

Breadcrumbs::for('backend.settings.cities.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Cities'), route('backend.settings.cities.index'));
});

Breadcrumbs::for('backend.settings.cities.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.settings.cities.index');

    $trail->push(__('common.Add'), route('backend.settings.cities.create'));
});

Breadcrumbs::for('backend.settings.cities.show', function (BreadcrumbTrail $trail, $city) {

    $trail->parent('backend.settings.cities.index');

    $city = ($city instanceof City) ? $city : $city[0];

    $trail->push($city->name, route('backend.settings.cities.show', $city->id));
});

Breadcrumbs::for('backend.settings.cities.edit', function (BreadcrumbTrail $trail, City $city) {

    $trail->parent('backend.settings.cities.show', [$city]);

    $trail->push(__('common.Edit'), route('backend.settings.cities.edit', $city->id));
});

/****************************************** Portfolio ******************************************/

Breadcrumbs::for('backend.portfolio', function (BreadcrumbTrail $trail) {

    $trail->parent('backend');

    $trail->push(__('menu-sidebar.Portfolio'), route('backend.portfolio'));
});

/****************************************** Services ******************************************/

Breadcrumbs::for('backend.portfolio.services.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio');

    $trail->push(__('menu-sidebar.Services'), route('backend.portfolio.services.index'));
});

Breadcrumbs::for('backend.portfolio.services.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio.services.index');

    $trail->push(__('common.Add'), route('backend.portfolio.services.create'));
});

Breadcrumbs::for('backend.portfolio.services.show', function (BreadcrumbTrail $trail, $service) {

    $trail->parent('backend.portfolio.services.index');

    $service = ($service instanceof Service) ? $service : $service[0];

    $trail->push($service->name, route('backend.portfolio.services.show', $service->id));
});

Breadcrumbs::for('backend.portfolio.services.edit', function (BreadcrumbTrail $trail, Comment $service) {

    $trail->parent('backend.portfolio.services.show', [$service]);

    $trail->push(__('common.Edit'), route('backend.portfolio.services.edit', $service->id));
});

/****************************************** Certificate ******************************************/

Breadcrumbs::for('backend.portfolio.certificates.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio');

    $trail->push(__('menu-sidebar.Certificates'), route('backend.portfolio.certificates.index'));
});

Breadcrumbs::for('backend.portfolio.certificates.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio.certificates.index');

    $trail->push(__('common.Add'), route('backend.portfolio.certificates.create'));
});

Breadcrumbs::for('backend.portfolio.certificates.show', function (BreadcrumbTrail $trail, $certificate) {

    $trail->parent('backend.portfolio.certificates.index');

    $certificate = ($certificate instanceof Post) ? $certificate : $certificate[0];

    $trail->push($certificate->name, route('backend.portfolio.certificates.show', $certificate->id));
});

Breadcrumbs::for('backend.portfolio.certificates.edit', function (BreadcrumbTrail $trail, Post $certificate) {

    $trail->parent('backend.portfolio.certificates.show', [$certificate]);

    $trail->push(__('common.Edit'), route('backend.portfolio.certificates.edit', $certificate->id));
});

/****************************************** Project ******************************************/

Breadcrumbs::for('backend.portfolio.projects.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio');

    $trail->push(__('menu-sidebar.Projects'), route('backend.portfolio.projects.index'));
});

Breadcrumbs::for('backend.portfolio.projects.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio.projects.index');

    $trail->push(__('common.Add'), route('backend.portfolio.projects.create'));
});

Breadcrumbs::for('backend.portfolio.projects.show', function (BreadcrumbTrail $trail, $project) {

    $trail->parent('backend.portfolio.projects.index');

    $project = ($project instanceof Post) ? $project : $project[0];

    $trail->push($project->name, route('backend.portfolio.projects.show', $project->id));
});

Breadcrumbs::for('backend.portfolio.projects.edit', function (BreadcrumbTrail $trail, Post $project) {

    $trail->parent('backend.portfolio.projects.show', [$project]);

    $trail->push(__('common.Edit'), route('backend.portfolio.projects.edit', $project->id));
});

/****************************************** Testimonial ******************************************/

Breadcrumbs::for('backend.portfolio.testimonials.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio');

    $trail->push(__('menu-sidebar.Testimonials'), route('backend.portfolio.testimonials.index'));
});

Breadcrumbs::for('backend.portfolio.testimonials.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.portfolio.testimonials.index');

    $trail->push(__('common.Add'), route('backend.portfolio.testimonials.create'));
});

Breadcrumbs::for('backend.portfolio.testimonials.show', function (BreadcrumbTrail $trail, $testimonial) {

    $trail->parent('backend.portfolio.testimonials.index');

    $testimonial = ($testimonial instanceof Post) ? $testimonial : $testimonial[0];

    $trail->push($testimonial->name, route('backend.portfolio.testimonials.show', $testimonial->id));
});

Breadcrumbs::for('backend.portfolio.testimonials.edit', function (BreadcrumbTrail $trail, Post $testimonial) {

    $trail->parent('backend.portfolio.testimonials.show', [$testimonial]);

    $trail->push(__('common.Edit'), route('backend.portfolio.testimonials.edit', $testimonial->id));
});

