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
        Html::component('linkButton', 'htmls.link-button', ['title', 'route', 'param' => [], 'icon', 'color' => 'success']);
        Html::component('actionButton', 'htmls.action-buttons', ['resourceRouteName', 'id', 'options' => []]);
        Html::component('backButton', 'htmls.back-button', ['route', 'param' => []]);
        Html::component('editButton', 'htmls.edit-button', ['route', 'param' => []]);
        Html::component('showButton', 'htmls.show-button', ['route', 'param' => []]);
        Html::component('deleteButton', 'htmls.delete-button', ['route', 'param' => []]);
        Html::component('restoreButton', 'htmls.restore-button', ['route', 'param' => []]);
        Html::component('toggleButton', 'htmls.toggle-button', ['route', 'param' => []]);

        //Card
        Html::component('cardHeader', 'htmls.card-header', ['title', 'icon', 'short' => null]);
        Html::component('cardSearch', 'htmls.search-form', ['field', 'route', 'attributes' => []]);

        //Dropdown
        Html::component('actionDropdown', 'htmls.action-dropdowns', ['resourceRouteName', 'id' => 0, 'options' => []]);
        Html::component('modelDropdown', 'htmls.model-dropdown', ['resourceRouteName', 'id' => 0, 'options' => [ 'color' => 'success', 'actions' => []]]);
        Html::component('bulkDropdown', 'htmls.bulk-dropdown', ['resourceRouteName', 'id' => 0, 'options' => []]);


        //Selection
        Html::component('selection', 'htmls.selection', ['target']);

        //Bootstrap4 Toggle
        Html::component('enableToggle', 'htmls.enable-button', ['model' => null, 'options' => []]);
    }
}
