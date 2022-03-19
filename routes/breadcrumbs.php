<?php

use App\Models\Backend\Organization\Enumerator;
use App\Models\Backend\Organization\Survey;
use App\Models\Backend\Setting\Catalog;
use App\Models\Backend\Setting\City;
use App\Models\Backend\Setting\Country;
use App\Models\Backend\Setting\Permission;
use App\Models\Backend\Setting\Role;
use App\Models\Backend\Setting\SmsTemplate;
use App\Models\Backend\Setting\State;
use App\Models\Backend\Setting\User;
use App\Models\Backend\Shipment\Invoice;
use App\Models\Backend\Shipment\Item;
use App\Models\Backend\Shipment\Transaction;
use App\Models\Backend\Transport\CheckPoint;
use App\Models\Backend\Transport\TruckLoad;
use App\Models\Backend\Transport\Vehicle;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('menu-sidebar.Home'), route('home'));
});

/****************************************** Http Error ******************************************/

Breadcrumbs::for('frontend.organization.applicants.create', function ($trail) {
   $trail->parent('home');
    $trail->push(__('enumerator.Applicant Registration'), route('frontend.organization.applicants.create'));
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

    $trail->push($state->name, route('backend.settings.states.show', $state->id));
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

/****************************************** Organization ******************************************/

Breadcrumbs::for('backend.organization', function (BreadcrumbTrail $trail) {

    $trail->parent('backend');

    $trail->push(__('menu-sidebar.Organization'), route('backend.organization'));
});

/****************************************** Survey ******************************************/

Breadcrumbs::for('backend.organization.surveys.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.organization');

    $trail->push(__('menu-sidebar.Surveys'), route('backend.organization.surveys.index'));
});

Breadcrumbs::for('backend.organization.surveys.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.organization.surveys.index');

    $trail->push(__('common.Add'), route('backend.organization.surveys.create'));
});

Breadcrumbs::for('backend.organization.surveys.show', function (BreadcrumbTrail $trail, $survey) {

    $trail->parent('backend.organization.surveys.index');

    $survey = ($survey instanceof Survey) ? $survey : $survey[0];

    $trail->push($survey->name, route('backend.organization.surveys.show', $survey->id));
});

Breadcrumbs::for('backend.organization.surveys.edit', function (BreadcrumbTrail $trail, Survey $survey) {

    $trail->parent('backend.organization.surveys.show', [$survey]);

    $trail->push(__('common.Edit'), route('backend.organization.surveys.edit', $survey->id));
});

/****************************************** Enumerator ******************************************/

Breadcrumbs::for('backend.organization.enumerators.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.organization');

    $trail->push(__('menu-sidebar.Enumerators'), route('backend.organization.enumerators.index'));
});

Breadcrumbs::for('backend.organization.enumerators.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.organization.enumerators.index');

    $trail->push(__('common.Add'), route('backend.organization.enumerators.create'));
});

Breadcrumbs::for('backend.organization.enumerators.show', function (BreadcrumbTrail $trail, $enumerator) {

    $trail->parent('backend.organization.enumerators.index');

    $enumerator = ($enumerator instanceof Enumerator) ? $enumerator : $enumerator[0];

    $trail->push($enumerator->name, route('backend.organization.enumerators.show', $enumerator->id));
});

Breadcrumbs::for('backend.organization.enumerators.edit', function (BreadcrumbTrail $trail, Enumerator $enumerator) {

    $trail->parent('backend.organization.enumerators.show', [$enumerator]);

    $trail->push(__('common.Edit'), route('backend.organization.enumerators.edit', $enumerator->id));
});
