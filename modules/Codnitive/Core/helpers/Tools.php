<?php

namespace app\modules\Codnitive\Core\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
// use yii\web\ServerErrorHttpException;
// use app\modules\Codnitive\Template\assets\Main;

class Tools /*extends Html*/
{
    /*public function __construct()
    {
        parent::__construct();

    }*/

    // public static function t()
    // {
    //     Yii::t();
    // }

    // public static function assetsRegister($view)
    // {
    //     Main::register($view);
    // }

    public static function hasModule($moduleName)
    {
        return app()->hasModule($moduleName);
    }

    public static function csrfMetaTags()
    {
        return Html::csrfMetaTags();
    }

    public static function getCsrfInput()
    {
        $token = self::getCsrfToken();
        $name  = self::getCsrfName();
        return '<input type="hidden" name="'.$name.'" value="'.$token.'"/>';
    }

    public static function getCsrfToken()
    {
        return app()->request->csrfToken;
    }

    public static function getCsrfName()
    {
        return app()->request->csrfParam;
    }

    public static function encode($content, $doubleEncode = true)
    {
        return Html::encode($content, $doubleEncode);
    }

    public static function getFlash($status)
    {
        return app()->session->getFlash($status);
    }

    public static function getBaseUrl()
    {
        return Url::base(true);
    }

    public static function getPreviousUrl()
    {
        $homeUrl     = app()->homeUrl;
        $previousUrl = app()->request->referrer ?: $homeUrl;
        $currentUrl  = static::getRequestUrl();
        // $currentUrl  = static::getUrl(static::getRequestUrl());
        return $currentUrl != $previousUrl ? $previousUrl : $homeUrl;
    }

    public static function getCurrentUrl(string $lang = '', bool $justPath = false)
    {
        $currentUrl = $justPath
            ? static::getRequestPath()
            : static::getRequestUrl();
        if (!empty($lang)) {
            // var_dump($currentUrl);
            $currentUrl = preg_replace('/^\/\w{2}/', "/$lang", $currentUrl);
        }
        return $currentUrl;
    }

    public static function getUrl($route = '', $params = [], $withSuffix = false, $absolute = false)
    {
        $lang  = self::getLang();
        // $base  = $lang != 'def' ? "@web/$lang/" : '@web/';

        // var_dump($route);
        if (preg_match('/^\/\w{2}$/', $route)) {
            // var_dump($route);
            $base = '@web/';
        }
        $base  = preg_match('/^\/\w{2}\//', $route) ? '@web/' : "@web/$lang/";
        $route = [$base . trim($route, '/')];
        $url   = array_merge($route, $params);
        $url   = Url::to($url, $absolute);
        if (substr_count($url, "/$lang") > 1) {
            $pattern = '/'.str_replace('/', '\/', $url).'/';
            $url = preg_replace($pattern, "/$lang", $url);
        }
        return $withSuffix ? $url : str_replace('.html', '', $url);
    }

    public static function getRequestUrl()
    {
        return app()->request->url;
    }

    public static function getRequestPath()
    {
        return app()->request->pathInfo;
    }

    public static function isHomePage()
    {
        $url = preg_replace('/\w{2}/', "", self::getRequestPath());
        return empty($url);
    }

    public static function getMediaUrl(string $path = ''): string
    {
        return rtrim(self::getBaseUrl().'/media/'.$path, '/');
    }
    
    public static function getImageUrl(string $imagePath = ''): string
    {
        return self::getMediaUrl("images/$imagePath");
    }

    public static function getUser()
    {
        return app()->user;
    }

    public static function isGuest()
    {
        return self::getUser()->isGuest;
    }

    public static function getUserNameParts()
    {
        $name = explode(' ', self::getUser()->identity->fullname);
        return [
            'firstname' => $name[0],
            'lastname'  => trim(str_replace($name['0'], '', self::getUser()->identity->fullname))
        ];
    }

    public static function getLang()
    {
        return app()->request->get('lang', 'en');
    }

    public static function getLanguage()
    {
        return self::getOptionValue(
            'Language', 
            'Langi18n', 
            self::getLang()
        );
    }

    public static function genderOptions()
    {
        return self::getOptionsArray('Core', 'Gender');
        // return \app\modules\Codnitive\Account\models\System\Source\Gender::optionsArray();
    }

    public static function getOptionsArray($module, $source)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return (new $className)->optionsArray();
    }

    public static function getOptionIdByValue($module, $source, $value)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return is_array($value)
            ? (new $className)->getArrayOptionIdByValue($value)
            : (new $className)->getOptionIdByValue($value);
    }

    public static function getOptionValue($module, $source, $id)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return (new $className)->getOptionValue($id);
    }

    public static function getOptionArrayClassName($module, $source)
    {
        return '\app\modules\Codnitive\\'.ucfirst($module).'\models\System\Source\\'.ucfirst($source);
    }

    /**
     * PARA: Date Should In YYYY-MM-DD Format
     * RESULT FORMAT:
     * '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
     * '%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
     * '%m Month %d Day'                                        =>  3 Month 14 Day
     * '%d Day %h Hours'                                        =>  14 Day 11 Hours
     * '%d Day'                                                 =>  14 Days
     * '%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
     * '%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
     * '%h Hours                                                =>  11 Hours
     * '%a Days                                                 =>  468 Days
     */
    public static function dateDiff($firstDate, $secondDate, $differenceFormat = '%a')
    {
        $firstDateObj  = date_create($firstDate);
        $secondDateObj = date_create($secondDate);
        $interval      = date_diff($firstDateObj, $secondDateObj);
        return $interval->format($differenceFormat);
    }

    public static function dateExpired($dateToCheck, $baseDate = 'Today')
    {
        if (!self::isValidDate($baseDate)) {
            $baseDate = self::getWhenDates($baseDate)['end_date'];
        }
        return ((int) self::dateDiff($baseDate, $dateToCheck, '%R%a') <= 0);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     * 
     * @source:
     * https://stackoverflow.com/questions/3108591/calculate-number-of-hours-between-2-dates-in-php
     */
    public static function timeDiff($oldDate, $newDate, $duration)
    {
        $oldDate = new \DateTime($oldDate);
        $newDate = new \DateTime($newDate);

        //determine what interval should be used - can change to weeks, months, etc
        $interval = new \DateInterval($duration);

        //create periods every hour between the two dates
        $periods = new \DatePeriod($oldDate, $interval, $newDate);

        //count the number of objects within the periods
        return iterator_count($periods);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     */
    public static function hoursDiff($oldDate, $newDate)
    {
        return self::timeDiff($oldDate, $newDate, 'PT1H'/*$duration*/);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     */
    public static function minutesDiff($oldDate, $newDate)
    {
        return self::timeDiff($oldDate, $newDate, 'PT1M'/*$duration*/);
    }

    /*public static function timeExpired($timeToCheck, $baseTime = '')
    {
        // if (empty($baseTime)) {
        //     $date = new \DateTime();
        //     $baseTime = $date->format('H:i');
        // }

        $dateTime = new \DateTime($timeToCheck);
        return time() >= strtotime($timeToCheck);
        // var_dump((int) self::dateDiff($timeToCheck, $baseTime, '%R%h'));
        // // exit;
        // return ((int) self::dateDiff($timeToCheck, $baseTime, '%R%h') <= 0);
    }*/

    /**
     * Check if the value is a valid date
     *
     * @param mixed $date
     *
     * @return boolean
     */
    public static function isValidDate($date) 
    {
        if (!$date) {
            return false;
        }

        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // public static function getWeeKEndDate()
    // {
    //     $date = new \DateTime('this week +6 days');
    //     // $date->modify('this week +6 days');
    //     return $date->format('Y-m-d');
    // }

    // public static function getMonthEndDate()
    // {
    //     $date = new \DateTime('this month');
    //     return $date->format('Y-m-t');
    // }

    // public static function getNextMonthDates()
    // {
    //     $date = new \DateTime('next month');
    //     $month = [
    //         $date->format('Y-m-01'),
    //         $date->format('Y-m-t'),
    //     ];
    //     return $month;
    // }

    // public static function getYearEndDate()
    // {
    //     $date = new \DateTime('last day of December');
    //     return $date->format('Y-m-t');
    // }

    public static function getWhenDates($when = null)
    {
        $date = new \DateTime();
        $startDate = $date->format('Y-m-d');
        switch ($when) {
            case 'Today':
                $endDate = $startDate;
                break;
            
            case 'Tomorrow':
                $endDate = $date->modify('tomorrow')->format('Y-m-d');
                break;

            case 'This Week':
                $endDate = $date->modify('this week +6 days')->format('Y-m-d');
                break;

            case 'This Month':
                $endDate = $date->modify('this month')->format('Y-m-t');
                break;

            case 'Next Month':
                $nextMonth = $date->modify('next month');
                $startDate = $nextMonth->format('Y-m-01');
                $endDate   = $nextMonth->format('Y-m-t');
                break;

            case 'Expired':
                $endDate = $startDate;
                $startDate = $date->modify('today -3650 days')->format('Y-m-01');
                break;

            default:
                // $endDate = $date->modify('last day of December')->format('Y-m-t');
                $endDate = $date->modify('today +3650 days')->format('Y-m-t');
        }

        return [
            'start_date' => $startDate,
            'end_date'   => $endDate
        ];
    }

    public static function getTimestamp($format = 'c')
    {
        $date = new \DateTime();
        return $date->format($format);
    }

    public static function getFormatedDate($date, $format = 'j F Y')
    {
        return date($format, strtotime($date));
    }

    public static function getFormatedTime($time, $format = 'g:i A')
    {
        return date($format, strtotime($time));
    }

    public static function formatPrice($number, $decimals = 2, $decimalsPoint = '.', $decimalsSeparator = ',')
    {
        return number_format($number, $decimals, $decimalsPoint, $decimalsSeparator);
    }

    public static function formatMoney(
        $number, 
        $format = '${{price}}',
        $options = ['decimals' => 2, 'decimals_point' => '.', 'decimals_separator' => ',']
    ) {
        $price = self::formatPrice(
            $number, 
            $options['decimals'], 
            $options['decimals_point'], 
            $options['decimals_separator']
        );
        return str_replace('{{price}}', $price, $format);
        // $price = self::formatPrice($number);
        // setlocale(LC_MONETARY, 'en_US');
        // return money_format('%i', $price);
    }

    public static function formatRial(float $price): string
    {
        return self::formatMoney($price, __('language', '${{price}}'), [
            'decimals' => 0,
            'decimals_point' => '.',
            'decimals_separator' => ','
        ]);
    }

    public static function isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }
        return (strpos($string, '{') !== false) || (strpos($string, '[') !== false);
    }

    /**
     * $strip can be string or array
     * 
     * @param $strip string|array
     * @return string|array
     */
    public static function stripOutInvisibles($value)
    {
        return preg_replace('/\p{C}+/u', '', $value);
    }

    public static function showProcessCheckout()
    {
        return isset(app()->session->get('__virtual_cart')['step']) 
            && app()->request->pathInfo != ltrim(tools()->getUrl(app()->session->get('__virtual_cart')['step']), '/');
    }

    public static function getImagePath($model, $userId = 0, $index = 0)
    {
        if (!$userId) {
            $userId = $model->user_id;
        }
        if (is_array($model)) {
            $imageName = $index === false
                ? $model['name']
                : $model[$index]['name'];
        }
        else {
            $imageName = $index === false
                ? $model->images['name']
                : $model->images[$index]['name'];
        }
        return "/$userId/$imageName";
    }

    public static function registerError($sessionKey, $errorKey, $errorMessage)
    {
        $session = app()->session;
        $errors = $session->get($sessionKey);
        $errors[$errorKey][] = $errorMessage;
        $session->set($sessionKey, $errors);
    }

    public static function getPerPageSize()
    {
        return app()->request->get(
            'per-page', 
            \app\modules\Codnitive\Core\models\Grid\GridAbstract::PAGE_SIZE
        );
    }

    /*public static function getField($form, $model, $filed, $icon = '')
    {
        $template = '<div class="row">
                {label}
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa '.$icon.'"></i>
                        </div>
                        {input}
                    </div>
                    <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                </div>
            </div>';
        return $form->field($model, $filed, [
                'template' => $template,
                'labelOptions' => [ 'class' => 'col-lg-2 control-label' ]
            ]);
    }*/

    /*public static function getConfigParams($param)
    {
        echo '<pre>';
        print_r(Yii::$app->params);
        exit;
        if (isset(Yii::$app->params[$param])) {
            return Yii::$app->params[$param];
        } else {
            $msg = "Can not find param in configuration file. have been search by param = " . VarDumper::export($param);
            Yii::error($msg, __METHOD__);
            throw new ServerErrorHttpException();
        }
    }*/

    public static function convertFormArrayToModelArray($dataArray)
    {
        $data = [];
        foreach ($dataArray as $field => $values) {
            if (is_array($values)) {
                // $values = array_values($values);
                foreach ($values as $key => $value) {
                    $data[$key][$field] = $value;
                }
            }
        }
        return $data;
    }

}
