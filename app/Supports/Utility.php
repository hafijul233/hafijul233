<?php


namespace App\Supports;

use App\Models\Backend\Common\Address;
use App\Models\Backend\Setting\ExamLevel;
use App\Models\Backend\Setting\ExamTitle;
use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/***
 * Class Utility
 * @package App\Supports
 */
class Utility
{
    /**
     * Hash any text with laravel default has algo.
     * Currently, only support bcrypt() with cost 10
     *
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Create a unique random username with given having input
     * As prefix text and a random number
     *
     * @param string $name
     * @param UserRepository|null $userRepository
     * @return string
     * @throws \Exception
     */
    public static function generateUsername(string $name, UserRepository $userRepository = null): string
    {
        if (is_null($userRepository)) {
            $userRepository = new UserRepository;
        }

        //removed white space from name
        $firstPart = preg_replace("([\s]+)", '-', Str::lower($name));

        //add a random number to end
        $username = trim($firstPart) . random_int(100, 1000);

        //verify generated username is unique
        return ($userRepository->verifyUniqueUsername($username)) ? $username : self::generateUsername($name, $userRepository);

    }

    /**
     * Admin LTE 3 Supported Random Badge Colors
     *
     * @param bool $rounded
     * @return string
     */
    public static function randomBadgeBackground(bool $rounded = false): string
    {
        $class = "";

        $badges = [
            "bg-primary",
            "bg-secondary",
            "bg-success",
            "bg-danger",
            "bg-warning text-dark",
            "bg-info text-white",
            "bg-light text-dark",
            "bg-dark"
        ];

        if ($rounded) $class .= "rounded-pill ";

        $class .= $badges[array_rand($badges)];

        return $class;
    }

    /**
     * Rename laravel log filename to more human readable format
     *
     * @param string $filename
     * @return array|string|string[]|null
     */
    public static function formatLogFilename(string $filename)
    {
        return preg_replace('/laravel\-([\d]{4})-([\d]{2})-([\d]{2})\.log/', '$3/$2/$1', $filename);
    }


    /**
     * Convert Route Name Human Readable Style
     *
     * @param string $permission
     * @return string
     */
    public static function permissionDisplay(string $permission): string
    {
        return ucwords(str_replace(['.', '-', '_'], [' ', ' ', ' '], $permission));
    }

    /**
     * @param Model $model
     * @param string $group
     * @return array
     */
    public static function modelAudits(Model $model, string $group = 'date'): array
    {
        $auditCollection = [];

        $audits = $model->audits()->with('user')->latest()->get();

        foreach ($audits as $audit) {
            $auditCollection[Carbon::parse($audit->created_at)->format('Y-m-d')][] = $audit;
        }

        return $auditCollection;
    }

    /**
     * @param string $method
     * @return array
     */
    public static function routeMethodNameArray(string $method = 'GET'): array
    {
        $routeCollection = Route::getRoutes()->getRoutesByMethod();

        $routes[$method] = [];

        if (isset($routeCollection[$method])) {
            foreach ($routeCollection[$method] as $route) {
                $routeName = $route->getName();
                if ($routeName === null)
                    continue;

                $routes[$method][$routeName] = self::permissionDisplay($routeName);
            }
        }

        return $routes;
    }

    /**
     * @param Address $addressBook
     * @return string
     */
    public static function getAddressBlock(Address $addressBook): string
    {
        $address = ($addressBook->street_1 ?? null) . ', ';

        if (!empty($addressBook->street_2)):
            $address .= ($addressBook->street_2 . ', ');
        endif;

        if (!empty($addressBook->post_code)):
            $address .= ($addressBook->post_code . ', ');
        endif;

        if (!empty($addressBook->city_id)):
            $address .= ($addressBook->city->name . ', ');
        endif;

        if (!empty($addressBook->state_id)):
            $address .= ($addressBook->state->name . ', ');
        endif;

        if (!empty($addressBook->country_id)):
            $address .= ($addressBook->country->name . /*', ' . $addressBook->country->iso3 .*/ '.');
        endif;

        return $address;
    }

    /**
     * Return Currency Formatted string from number
     *
     * @param null $amount
     * @param string $currency
     * @param bool $onlyCurrency
     * @return string|null
     */
    public static function money($amount = null, string $currency = 'USD', bool $onlyCurrency = false)
    {
        $currencyConfig = config('money.' . $currency);

        if (empty($currencyConfig)) {
            $currencyConfig = config('money.USD');
        }

        if(is_numeric($amount)) {
            $formattedAmount = number_format($amount, $currencyConfig['precision'],
                $currencyConfig['decimal_mark'], $currencyConfig['thousands_separator']);

            $amount =  ($onlyCurrency == true)
                ? $currency . ' ' . $formattedAmount
                : (($currencyConfig['symbol_first'] == true)
                    ? $currencyConfig['symbol'] . ' ' . $formattedAmount
                    : $formattedAmount . ' ' . $currencyConfig['symbol']);
        }

        return $amount;
    }

    /**
     * @param string $code
     * @return mixed
     */
    public static function getExamLevelByCode(string $code)
    {
        return ExamLevel::where('code', '=', $code)->first();
    }

    /**
     *
     * @param int $exam_level_id
     * @return array
     */
    public static function getExamTitleById(int $exam_level_id)
    {
        $examTitleCollection = ExamTitle::where('exam_level_id', '=', $exam_level_id)->get();

        $examTitleArray = [];
        foreach ($examTitleCollection as $item):
            $examTitleArray[$item->id] = $item->name;
        endforeach;

        return $examTitleArray;
    }
}
