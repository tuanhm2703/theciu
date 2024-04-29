<?php

use App\Enums\CategoryType;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Config;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Order;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('isNavActive')) {
    function isNavActive(String $routeName) {
        if (strpos(Route::currentRouteName(), $routeName) === 0) return true;
        return strpos(Request::url(), $routeName) === 0;
    }
}
function customerWishlist() {
    $customer = customer();
    if ($customer) {
        return cache()->remember("customer_wishlist_$customer->id", 300, function () use ($customer) {
            return $customer->product_wishlists()->pluck('wishlistable_id')->toArray();
        });
    }
    return [];
}
function getAssetUrl($path) {
    return asset($path) . "?v=" . env('ASSET_VERSION', 1);
}
function stripVN($string, $slug = '-', $extra = null) {

    if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
        $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|caron|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
    }

    if (preg_match('~[^[:ascii:]]~', $string) > 0) {
        $latin = array(
            'a' => '~[àáảãạăằắẳẵặâầấẩẫậÀÁẢÃẠĂẰẮẲẴẶÂẦẤẨẪẬą]~iu',
            'ae' => '~[ǽǣ]~iu',
            'b' => '~[ɓ]~iu',
            'c' => '~[ćċĉč]~iu',
            'd' => '~[ďḍđɗð]~iu',
            'e' => '~[èéẻẽẹêềếểễệÈÉẺẼẸÊỀẾỂỄỆęǝəɛ]~iu',
            'g' => '~[ġĝǧğģɣ]~iu',
            'h' => '~[ĥḥħ]~iu',
            'i' => '~[ìíỉĩịÌÍỈĨỊıǐĭīįİ]~iu',
            'ij' => '~[ĳ]~iu',
            'j' => '~[ĵ]~iu',
            'k' => '~[ķƙĸ]~iu',
            'l' => '~[ĺļłľŀ]~iu',
            'n' => '~[ŉń̈ňņŋ]~iu',
            'o' => '~[òóỏõọôồốổỗộơờớởỡợÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢǒŏōőǫǿ]~iu',
            'r' => '~[ŕřŗ]~iu',
            's' => '~[ſśŝşșṣ]~iu',
            't' => '~[ťţṭŧ]~iu',
            'u' => '~[ùúủũụưừứửữựÙÚỦŨỤƯỪỨỬỮỰǔŭūűůų]~iu',
            'w' => '~[ẃẁŵẅƿ]~iu',
            'y' => '~[ỳýỷỹỵYỲÝỶỸỴŷȳƴ]~iu',
            'z' => '~[źżžẓ]~iu',
        );

        $string = preg_replace($latin, array_keys($latin), $string);
    }

    return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']++~i', $slug, $string), $slug));
}

function renderCategory($category) {
    $output = '';
    if ($category->hasProducts()) {
        $route = route('client.product_category.index', ['category' => $category->slug]);
        $output .= "<li><a href='$route'>$category->name</a>";
        if ($category->categories->count() > 0) {
            $output .= "<ul>";
            foreach ($category->categories as $c) {
                $output .= renderCategory($c);
            }
            $output .= "</ul>";
        }
        $output .= "</li>";
    }
    return $output;
}
function renderCollectionCategory() {
    $output = '';
    $categories = Category::whereType(CategoryType::COLLECTION)->whereHas('available_products')->get();
    foreach ($categories as $category) {
        $route = route('client.product_category.index', ['category' => $category->slug]);
        $output .= "<li><a href='$route'>$category->name</a></li>";
    }
    return $output;
}

function getLocaleWithCountryCode() {
    return [
        'af' => 'ZA',
        'am' => 'ET',
        'ar' => 'AE',
        'ar' => 'BH',
        'ar' => 'DZ',
        'ar' => 'EG',
        'ar' => 'IQ',
        'ar' => 'JO',
        'ar' => 'KW',
        'ar' => 'LB',
        'ar' => 'LY',
        'ar' => 'MA',
        'arn' => 'CL',
        'ar' => 'OM',
        'ar' => 'QA',
        'ar' => 'SA',
        'ar' => 'SD',
        'ar' => 'SY',
        'ar' => 'TN',
        'ar' => 'YE',
        'as' => 'IN',
        'az' => 'az',
        'az' => 'Cyrl-AZ',
        'az' => 'Latn-AZ',
        'ba' => 'RU',
        'be' => 'BY',
        'bg' => 'BG',
        'bn' => 'BD',
        'bn' => 'IN',
        'bo' => 'CN',
        'br' => 'FR',
        'bs' => 'Cyrl-BA',
        'bs' => 'Latn-BA',
        'ca' => 'ES',
        'co' => 'FR',
        'cs' => 'CZ',
        'cy' => 'GB',
        'da' => 'DK',
        'de' => 'AT',
        'de' => 'CH',
        'de' => 'DE',
        'de' => 'LI',
        'de' => 'LU',
        'dsb' => 'DE',
        'dv' => 'MV',
        'el' => 'CY',
        'el' => 'GR',
        'en' => '029',
        'en' => 'AU',
        'en' => 'BZ',
        'en' => 'CA',
        'en' => 'cb',
        'en' => 'GB',
        'en' => 'IE',
        'en' => 'IN',
        'en' => 'JM',
        'en' => 'MT',
        'en' => 'MY',
        'en' => 'NZ',
        'en' => 'PH',
        'en' => 'SG',
        'en' => 'TT',
        'en' => 'US',
        'en' => 'ZA',
        'en' => 'ZW',
        'es' => 'AR',
        'es' => 'BO',
        'es' => 'CL',
        'es' => 'CO',
        'es' => 'CR',
        'es' => 'DO',
        'es' => 'EC',
        'es' => 'ES',
        'es' => 'GT',
        'es' => 'HN',
        'es' => 'MX',
        'es' => 'NI',
        'es' => 'PA',
        'es' => 'PE',
        'es' => 'PR',
        'es' => 'PY',
        'es' => 'SV',
        'es' => 'US',
        'es' => 'UY',
        'es' => 'VE',
        'et' => 'EE',
        'eu' => 'ES',
        'fa' => 'IR',
        'fi' => 'FI',
        'fil' => 'PH',
        'fo' => 'FO',
        'fr' => 'BE',
        'fr' => 'CA',
        'fr' => 'CH',
        'fr' => 'FR',
        'fr' => 'LU',
        'fr' => 'MC',
        'fy' => 'NL',
        'ga' => 'IE',
        'gd' => 'GB',
        'gd' => 'ie',
        'gl' => 'ES',
        'gsw' => 'FR',
        'gu' => 'IN',
        'ha' => 'Latn-NG',
        'he' => 'IL',
        'hi' => 'IN',
        'hr' => 'BA',
        'hr' => 'HR',
        'hsb' => 'DE',
        'hu' => 'HU',
        'hy' => 'AM',
        'id' => 'ID',
        'ig' => 'NG',
        'ii' => 'CN',
        'in' => 'ID',
        'is' => 'IS',
        'it' => 'CH',
        'it' => 'IT',
        'iu' => 'Cans-CA',
        'iu' => 'Latn-CA',
        'iw' => 'IL',
        'ja' => 'JP',
        'ka' => 'GE',
        'kk' => 'KZ',
        'kl' => 'GL',
        'km' => 'KH',
        'kn' => 'IN',
        'kok' => 'IN',
        'ko' => 'KR',
        'ky' => 'KG',
        'lb' => 'LU',
        'lo' => 'LA',
        'lt' => 'LT',
        'lv' => 'LV',
        'mi' => 'NZ',
        'mk' => 'MK',
        'ml' => 'IN',
        'mn' => 'MN',
        'mn' => 'Mong-CN',
        'moh' => 'CA',
        'mr' => 'IN',
        'ms' => 'BN',
        'ms' => 'MY',
        'mt' => 'MT',
        'nb' => 'NO',
        'ne' => 'NP',
        'nl' => 'BE',
        'nl' => 'NL',
        'nn' => 'NO',
        'no' => 'no',
        'nso' => 'ZA',
        'oc' => 'FR',
        'or' => 'IN',
        'pa' => 'IN',
        'pl' => 'PL',
        'prs' => 'AF',
        'ps' => 'AF',
        'pt' => 'BR',
        'pt' => 'PT',
        'qut' => 'GT',
        'quz' => 'BO',
        'quz' => 'EC',
        'quz' => 'PE',
        'rm' => 'CH',
        'ro' => 'mo',
        'ro' => 'RO',
        'ru' => 'mo',
        'ru' => 'RU',
        'rw' => 'RW',
        'sah' => 'RU',
        'sa' => 'IN',
        'se' => 'FI',
        'se' => 'NO',
        'se' => 'SE',
        'si' => 'LK',
        'sk' => 'SK',
        'sl' => 'SI',
        'sma' => 'NO',
        'sma' => 'SE',
        'smj' => 'NO',
        'smj' => 'SE',
        'smn' => 'FI',
        'sms' => 'FI',
        'sq' => 'AL',
        'sr' => 'BA',
        'sr' => 'CS',
        'sr' => 'Cyrl-BA',
        'sr' => 'Cyrl-CS',
        'sr' => 'Cyrl-ME',
        'sr' => 'Cyrl-RS',
        'sr' => 'Latn-BA',
        'sr' => 'Latn-CS',
        'sr' => 'Latn-ME',
        'sr' => 'Latn-RS',
        'sr' => 'ME',
        'sr' => 'RS',
        'sr' => 'sp',
        'sv' => 'FI',
        'sv' => 'SE',
        'sw' => 'KE',
        'syr' => 'SY',
        'ta' => 'IN',
        'te' => 'IN',
        'tg' => 'Cyrl-TJ',
        'th' => 'TH',
        'tk' => 'TM',
        'tlh' => 'QS',
        'tn' => 'ZA',
        'tr' => 'TR',
        'tt' => 'RU',
        'tzm' => 'Latn-DZ',
        'ug' => 'CN',
        'uk' => 'UA',
        'ur' => 'PK',
        'uz' => 'Cyrl-UZ',
        'uz' => 'Latn-UZ',
        'uz' => 'uz',
        'vi' => 'VN',
        'wo' => 'SN',
        'xh' => 'ZA',
        'yo' => 'NG',
        'zh' => 'CN',
        'zh' => 'HK',
        'zh' => 'MO',
        'zh' => 'SG',
        'zh' => 'TW',
        'zu' => 'ZA',
    ];
}
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPhone($phone) {
    return preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $phone) > 0;
}

function format_currency($value, $decimal = 0) {
    return number_format($value, $decimal, ',', '.');
}

function format_currency_with_label($value, $decimal = 0) {
    return "₫" . format_currency($value, $decimal);
}

function isRomanNumber($roman) {
    $roman_characters = [
        'M',
        'CM',
        'D',
        'CD',
        'C',
        'XC',
        'L',
        'XL',
        'X',
        'IX',
        'V',
        'IV',
        'I',
    ];
    for ($i = 0; $i < strlen($roman); $i++) {
        if (!in_array($roman[$i], $roman_characters)) return false;
    }
    return true;
}

function convertRomanToInteger($roman) {
    if (isRomanNumber($roman) == false) return 0;
    $romans = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    );
    $result = 0;
    foreach ($romans as $key => $value) {
        while (strpos($roman, $key) === 0) {
            $result += $value;
            $roman = substr($roman, strlen($key));
        }
    }
    return $result;
}

function pickUpAddressOptions() {
    $config = Config::select('id')->first();
    return $config->pickup_addresses()->pluck('full_address', 'id')->toArray();
}

function gen_uuid() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function getAppName() {
    return env('APP_NAME');
}
function getLogoUrl() {
    return '/img/logo-dark.png';
}
function checkAuthCustomer() {
    return auth('customer')->check();
}
function customer(): ?Customer {
    return checkAuthCustomer() ? auth('customer')->user() : null;
}
function user() {
    return auth('web')->check() ? auth('web')->user() : null;
}
function get_placeholder_img($size = 'small') {
    $size = config("image.sizes.{$size}");

    if ($size && is_array($size))
        return ('/images/placeholder.png');

    return "/images/placeholders/no_img.png";
}
function get_proxy_image_url($path, $size = 600) {
    $info = pathinfo($path);
    if ($path != '' && $info != null && $info['extension'] == 'gif') {
        $extension = 'gif';
    } else {
        $extension = $info['extension'];
    }
    if (!is_numeric($size)) $size = 600;
    $key = config('services.imgproxy.key');
    $salt = config('services.imgproxy.salt');
    $keyBin = pack("H*", $key);
    if (empty($keyBin)) {
        die('Key expected to be hex-encoded string');
    }

    $saltBin = pack("H*", $salt);
    if (empty($saltBin)) {
        die('Salt expected to be hex-encoded string');
    }

    $resize = 'fill';
    $width = $size;
    $height = 0;
    $gravity = 'sm';
    $enlarge = 1;
    if (!$path)
        return get_placeholder_img($size);

    // return asset("image/{$path}?p={$size}");
    $url = $path;
    $encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

    $path = "/rs:{$resize}:{$width}:{$height}:{$enlarge}/g:{$gravity}/{$encodedUrl}.{$extension}";

    $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin . $path, $keyBin, true)), '+/', '-_'), '=');
    $proxy_domain = config('services.imgproxy.domain');
    return sprintf("$proxy_domain/%s%s", $signature, $path);
}
function random_string($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $rand_str = substr(str_shuffle($chars), 0, $length);
    return $rand_str;
}
function thousandsCurrencyFormat($num) {

    if ($num > 1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
    }

    return $num;
}
function resize_image($path, $size) {
    $content = file_get_contents(get_proxy_image_url(Storage::url($path), $size));
    return Storage::put("$size/$path", $content);
}
function getPathWithSize($size, $path) {
    return StorageService::getPathWithSize($size, $path);
}

function carbon($time) {
    return new Carbon($time);
}
function getSessionAddresses() {
    return session()->has('addresses') ? unserialize(session()->get('addresses')) : new Collection();
}
function getSessionOrders() {
    return session()->has('orders') ? unserialize(session()->get('orders')) : new Collection();
}
function removeSessionCart() {
    return session()->forget('cart');
}
function updateSessionOrder(Order $order) {
    $orders = getSessionOrders();
    $orders = $orders->filter(function($o) use ($order) {
        return $order->id != $o->id;
    });
    $orders->push($order);
    return session()->put('orders', serialize($order));
}
function syncSessionCart() {
    try {
        $customer = customer();
        if (session()->has('cart')) {
            $cart = unserialize(session()->get('cart'));
            foreach ($cart->inventories as $inventory) {
                $customer->cart = Cart::with(['inventories' => function ($q) {
                    return $q->with('image:path,imageable_id', 'product:id,slug,name');
                }])->firstOrCreate([
                    'customer_id' => auth('customer')->user()->id
                ]);
                if ($customer->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
                    $customer->cart->inventories()->sync([$inventory->id => ['quantity' => $inventory->order_item->quantity ? $inventory->order_item->quantity : DB::raw("cart_items.quantity + 1")]], false);
                } else {
                    $customer->cart->inventories()->sync([$inventory->id => ['quantity' => $inventory->order_item->quantity ? $inventory->order_item->quantity : 1, 'customer_id' => $customer->id]], false);
                }
            }
            session()->forget('cart');
        }
    } catch (\Throwable $th) {
        \Log::error($th);
    }
}
function detailShippingAndReturnInfo() {
    return '<p><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/C0iikhhUn9qEknQHJFQ1hQq5v7J5kVkrl4cXN7HA.jpg" style="width: 100%px;" class="fr-fic fr-dib"><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/rcrWntNRvqaZKvbWg7ob3RQUO0dJZbkMh2lftksM.jpg" style="width: 100%px;" class="fr-fic fr-dib"><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/sIynKKTIwc5t0qptZjeWAR5oOrikpPBnqm1GGtiX.jpg" style="width: 100%px;" class="fr-fic fr-dib"></p><p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>';
}
function defaultProductAdditionalInformation() {
    return '<p><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/skQxbHb8RaoX9QeD28S7r4iAUMZOaNLTIBQ79op7.jpg" style="width: 100%px;" class="fr-fic fr-dib"><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/dELsvpo4PUHQc0R4ejdveaujJhpzvZey2hokveYQ.jpg" style="width: 100%px;" class="fr-fic fr-dib"><img src="https://minio-api.theciu.vn/theciu-beta/1000/images/1gRsM6pRUZ7fO4iU7WpDZB6O5Bs5fpQhrOmOZACl.jpg" style="width: 100%px;" class="fr-fic fr-dib"></p><p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>';
}
function convertToHttps($request_url) {
    $url = parse_url($request_url);
    if($url['scheme'] === 'https') {
        return $request_url;
    }
    return str_replace("http", "https", $request_url);
}

function compareArray($wordArray, $correctArray) {
    $result = [];
    foreach($wordArray as $index => $word) {
        $result[] = $word == $correctArray[$index];
    }
    return $result;
}

function getDefaultAvatar() {
    return asset('assets/images/default-avatar.png');
}
