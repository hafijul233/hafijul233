<?php

use App\Models\Backend\Blog\NewsLetter;
use App\Models\Backend\Portfolio\Certificate;
use App\Models\Backend\Portfolio\Project;
use App\Models\Backend\Portfolio\Service;
use App\Models\Backend\Portfolio\Testimonial;
use App\Models\Backend\Resume\Award;
use App\Models\Backend\Blog\Post;
use App\Models\Backend\Resume\Education;
use App\Models\Backend\Resume\Experience;
use App\Models\Backend\Resume\Language;
use App\Models\Backend\Resume\Skill;
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

Breadcrumbs::for('backend', function (BreadcrumbTrail $trail) {
    $trail->push(config('backend.sidebar'), route('backend'));
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

/****************************************** Service ******************************************/

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

Breadcrumbs::for('backend.portfolio.services.edit', function (BreadcrumbTrail $trail, Service $service) {

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

    $certificate = ($certificate instanceof Certificate) ? $certificate : $certificate[0];

    $trail->push(($certificate->title ?? ''), route('backend.portfolio.certificates.show', $certificate->id));
});

Breadcrumbs::for('backend.portfolio.certificates.edit', function (BreadcrumbTrail $trail, Certificate $certificate) {

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

    $project = ($project instanceof Project) ? $project : $project[0];

    $trail->push($project->name, route('backend.portfolio.projects.show', $project->id));
});

Breadcrumbs::for('backend.portfolio.projects.edit', function (BreadcrumbTrail $trail, Project $project) {

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

    $testimonial = ($testimonial instanceof Testimonial) ? $testimonial : $testimonial[0];

    $trail->push($testimonial->client, route('backend.portfolio.testimonials.show', $testimonial->id));
});

Breadcrumbs::for('backend.portfolio.testimonials.edit', function (BreadcrumbTrail $trail, Testimonial $testimonial) {

    $trail->parent('backend.portfolio.testimonials.show', [$testimonial]);

    $trail->push(__('common.Edit'), route('backend.portfolio.testimonials.edit', $testimonial->id));
});

/****************************************** Resume ******************************************/

Breadcrumbs::for('backend.resume', function (BreadcrumbTrail $trail) {

    $trail->parent('backend');

    $trail->push(__('menu-sidebar.Resume'), route('backend.resume'));
});

/****************************************** Experience ******************************************/

Breadcrumbs::for('backend.resume.experiences.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume');

    $trail->push(__('menu-sidebar.Experiences'), route('backend.resume.experiences.index'));
});

Breadcrumbs::for('backend.resume.experiences.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume.experiences.index');

    $trail->push(__('common.Add'), route('backend.resume.experiences.create'));
});

Breadcrumbs::for('backend.resume.experiences.show', function (BreadcrumbTrail $trail, $experience) {

    $trail->parent('backend.resume.experiences.index');

    $experience = ($experience instanceof Experience) ? $experience : $experience[0];

    $trail->push($experience->title, route('backend.resume.experiences.show', $experience->id));
});

Breadcrumbs::for('backend.resume.experiences.edit', function (BreadcrumbTrail $trail, Experience $experience) {

    $trail->parent('backend.resume.experiences.show', [$experience]);

    $trail->push(__('common.Edit'), route('backend.resume.experiences.edit', $experience->id));
});

/****************************************** Education ******************************************/

Breadcrumbs::for('backend.resume.educations.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume');

    $trail->push(__('menu-sidebar.Educations'), route('backend.resume.educations.index'));
});

Breadcrumbs::for('backend.resume.educations.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume.educations.index');

    $trail->push(__('common.Add'), route('backend.resume.educations.create'));
});

Breadcrumbs::for('backend.resume.educations.show', function (BreadcrumbTrail $trail, $education) {

    $trail->parent('backend.resume.educations.index');

    $education = ($education instanceof Education) ? $education : $education[0];

    $trail->push("{$education->degree} of {$education->field}", route('backend.resume.educations.show', $education->id));
});

Breadcrumbs::for('backend.resume.educations.edit', function (BreadcrumbTrail $trail, Education $education) {

    $trail->parent('backend.resume.educations.show', [$education]);

    $trail->push(__('common.Edit'), route('backend.resume.educations.edit', $education->id));
});

/****************************************** Award ******************************************/

Breadcrumbs::for('backend.resume.awards.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume');

    $trail->push(__('menu-sidebar.Awards'), route('backend.resume.awards.index'));
});

Breadcrumbs::for('backend.resume.awards.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume.awards.index');

    $trail->push(__('common.Add'), route('backend.resume.awards.create'));
});

Breadcrumbs::for('backend.resume.awards.show', function (BreadcrumbTrail $trail, $award) {

    $trail->parent('backend.resume.awards.index');

    $award = ($award instanceof Award) ? $award : $award[0];

    $trail->push($award->name, route('backend.resume.awards.show', $award->id));
});

Breadcrumbs::for('backend.resume.awards.edit', function (BreadcrumbTrail $trail, Award $award) {

    $trail->parent('backend.resume.awards.show', [$award]);

    $trail->push(__('common.Edit'), route('backend.resume.awards.edit', $award->id));
});

/****************************************** Skill ******************************************/

Breadcrumbs::for('backend.resume.skills.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume');

    $trail->push(__('menu-sidebar.Skills'), route('backend.resume.skills.index'));
});

Breadcrumbs::for('backend.resume.skills.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume.skills.index');

    $trail->push(__('common.Add'), route('backend.resume.skills.create'));
});

Breadcrumbs::for('backend.resume.skills.show', function (BreadcrumbTrail $trail, $skill) {

    $trail->parent('backend.resume.skills.index');

    $skill = ($skill instanceof Skill) ? $skill : $skill[0];

    $trail->push($skill->name, route('backend.resume.skills.show', $skill->id));
});

Breadcrumbs::for('backend.resume.skills.edit', function (BreadcrumbTrail $trail, Skill $skill) {

    $trail->parent('backend.resume.skills.show', [$skill]);

    $trail->push(__('common.Edit'), route('backend.resume.skills.edit', $skill->id));
});

/****************************************** Language ******************************************/

Breadcrumbs::for('backend.resume.languages.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume');

    $trail->push(__('menu-sidebar.Languages'), route('backend.resume.languages.index'));
});

Breadcrumbs::for('backend.resume.languages.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.resume.languages.index');

    $trail->push(__('common.Add'), route('backend.resume.languages.create'));
});

Breadcrumbs::for('backend.resume.languages.show', function (BreadcrumbTrail $trail, $language) {

    $trail->parent('backend.resume.languages.index');

    $language = ($language instanceof Language) ? $language : $language[0];

    $trail->push($language->name, route('backend.resume.languages.show', $language->id));
});

Breadcrumbs::for('backend.resume.languages.edit', function (BreadcrumbTrail $trail, Language $language) {

    $trail->parent('backend.resume.languages.show', [$language]);

    $trail->push(__('common.Edit'), route('backend.resume.languages.edit', $language->id));
});

/****************************************** Blog ******************************************/

Breadcrumbs::for('backend.blog', function (BreadcrumbTrail $trail) {

    $trail->parent('backend');

    $trail->push(__('menu-sidebar.Blog'), route('backend.blog'));
});

/****************************************** Post ******************************************/

Breadcrumbs::for('backend.blog.posts.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog');

    $trail->push(__('menu-sidebar.Posts'), route('backend.blog.posts.index'));
});

Breadcrumbs::for('backend.blog.posts.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog.posts.index');

    $trail->push(__('common.Add'), route('backend.blog.posts.create'));
});

Breadcrumbs::for('backend.blog.posts.show', function (BreadcrumbTrail $trail, $post) {

    $trail->parent('backend.blog.posts.index');

    $post = ($post instanceof Post) ? $post : $post[0];

    $trail->push($post->name, route('backend.blog.posts.show', $post->id));
});

Breadcrumbs::for('backend.blog.posts.edit', function (BreadcrumbTrail $trail, Post $post) {

    $trail->parent('backend.blog.posts.show', [$post]);

    $trail->push(__('common.Edit'), route('backend.blog.posts.edit', $post->id));
});

/****************************************** Comment ******************************************/

Breadcrumbs::for('backend.blog.comments.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog');

    $trail->push(__('menu-sidebar.Comments'), route('backend.blog.comments.index'));
});

Breadcrumbs::for('backend.blog.comments.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog.comments.index');

    $trail->push(__('common.Add'), route('backend.blog.comments.create'));
});

Breadcrumbs::for('backend.blog.comments.show', function (BreadcrumbTrail $trail, $comment) {

    $trail->parent('backend.blog.comments.index');

    $comment = ($comment instanceof Comment) ? $comment : $comment[0];

    $trail->push($comment->name, route('backend.blog.comments.show', $comment->id));
});

Breadcrumbs::for('backend.blog.comments.edit', function (BreadcrumbTrail $trail, Comment $comment) {

    $trail->parent('backend.blog.comments.show', [$comment]);

    $trail->push(__('common.Edit'), route('backend.blog.comments.edit', $comment->id));
});

/****************************************** News Letter ******************************************/

Breadcrumbs::for('backend.blog.newsletters.index', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog');

    $trail->push(__('menu-sidebar.Newsletters'), route('backend.blog.newsletters.index'));
});

Breadcrumbs::for('backend.blog.newsletters.create', function (BreadcrumbTrail $trail) {

    $trail->parent('backend.blog.newsletters.index');

    $trail->push(__('common.Add'), route('backend.blog.newsletters.create'));
});

Breadcrumbs::for('backend.blog.newsletters.show', function (BreadcrumbTrail $trail, $newsletter) {

    $trail->parent('backend.blog.newsletters.index');

    $newsletter = ($newsletter instanceof NewsLetter) ? $newsletter : $newsletter[0];

    $trail->push($newsletter->name, route('backend.blog.newsletters.show', $newsletter->id));
});

Breadcrumbs::for('backend.blog.newsletters.edit', function (BreadcrumbTrail $trail, NewsLetter $newsletter) {

    $trail->parent('backend.blog.newsletters.show', [$newsletter]);

    $trail->push(__('common.Edit'), route('backend.blog.newsletters.edit', $newsletter->id));
});