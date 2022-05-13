<?php

namespace App\Providers;

use Collective\Html\HtmlFacade as Html;
use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Buttons
        Html::component('linkButton', 'backend.htmls.link-button', ['title', 'route', 'param' => [], 'icon', 'color' => 'success']);
        Html::component('actionButton', 'backend.htmls.action-buttons', ['resourceRouteName', 'id' => 0, 'options' => []]);
        Html::component('backButton', 'backend.htmls.back-button', ['route', 'param' => []]);
        Html::component('editButton', 'backend.htmls.edit-button', ['route', 'param' => []]);
        Html::component('showButton', 'backend.htmls.show-button', ['route', 'param' => []]);
        Html::component('deleteButton', 'backend.htmls.delete-button', ['route', 'param' => []]);
        Html::component('restoreButton', 'backend.htmls.restore-button', ['route', 'param' => []]);
        Html::component('toggleButton', 'backend.htmls.toggle-button', ['route', 'param' => []]);

        //Card
        Html::component('cardHeader', 'backend.htmls.card-header', ['title', 'icon', 'short' => null]);
        Html::component('cardSearch', 'backend.htmls.search-form', ['field', 'route', 'attributes' => []]);

        //Dropdown
        Html::component('actionDropdown', 'backend.htmls.action-dropdowns', ['resourceRouteName', 'id' => 0, 'options' => []]);
        Html::component('modelDropdown', 'backend.htmls.model-dropdown', ['resourceRouteName', 'id' => 0, 'options' => ['color' => 'success', 'actions' => []]]);
        Html::component('bulkDropdown', 'backend.htmls.bulk-dropdown', ['resourceRouteName', 'id' => 0, 'options' => []]);


        //Selection
        Html::component('selection', 'backend.htmls.selection', ['target']);

        //Bootstrap4 Toggle
        Html::component('enableToggle', 'backend.htmls.enable-button', ['model' => null, 'options' => []]);
    }
}
