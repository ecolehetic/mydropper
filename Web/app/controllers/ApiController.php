<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Category;
use APP\MODELS\Store;
use APP\MODELS\TrackerStore;
use APP\MODELS\TrackerUrl;
use APP\MODELS\Url;
use APP\MODELS\User;
use Carbon\Carbon;

class ApiController extends BaseController
{
    /**
     * Connect USER and return token with informations about the account
     * POST /api/connect
     */
    public function connect()
    {
        $validForm = User::checkForm($this->f3->get('POST'), array(
            'username' => 'required',
            'password' => 'required'
        ));

        if ($validForm === true) {
            $user = User::where('username', $this->f3->get('POST.username'))->where('password', $this->crypt($this->f3->get('POST.password')))->first();

            if ($user !== null || !empty($user)) {

                $token = uniqid("API_");

                // Generate Token and save it
                $user = User::find($user->id);
                $user->token_api = $token;
                $user->save();

                $data = [
                    'success' => true,
                    'message' => "User connected.",
                    'user'    => [
                        'id'        => $user->id,
                        'username'  => $user->username,
                        'firstname' => $user->firstname,
                        'lastname'  => $user->name,
                        'avatar'    => $user->avatar_url,
                        'token_api' => $token
                    ]
                ];

                $this->render(false, $data);
                return;
            } else {
                $data = [
                    'success' => false,
                    'message' => "Error, the account is not in the database."
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => "Error, you need insert an username(POST.username) and password(POST.password)."
            ];
        }

        $this->renderError($data);
    }

    /**
     * Return all categories with stores
     * POST /api/stores
     */
    public function getStores()
    {
        $validForm = User::checkForm($this->f3->get('POST'), array(
            'user_id'  => 'required',
            'token_id' => 'required'
        ));

        if ($validForm === true) {
            $user = User::where('id', $this->f3->get('POST.user_id'))->where('token_api', $this->f3->get('POST.token_id'))->first();

            if ($user !== null || !empty($user)) {

                $userId     = $this->f3->get('POST.user_id');
                $categories = User::find($userId)->categories()->get();
                $data       = [];

                for($i = 0; $i < count($categories); $i++){
                    array_push($data, [
                        'category_id'    => $categories[$i]->id,
                        'category_label' => $categories[$i]->label,
                        'stores'         => []
                    ]);

                    $stores = Store::where('category_id', $categories[$i]->id)->get();

                    for ($j = 0; $j < count($stores); $j++) {
                        $data[$i]['stores'][] = [
                            'store_id'          => $stores[$j]->id,
                            'store_label'       => $stores[$j]->label,
                            'store_description' => $stores[$j]->descript,
                            'store_active'      => $stores[$j]->is_active
                        ];
                    }
                }

                $this->render(false, $data);
                return;
            } else {
                $data = [
                    'success' => false,
                    'message' => "Error, can't find an account with user_id(".$this->f3->get('POST.user_id').") and token_id(".$this->f3->get('POST.token_id').")."
                ];
            }

        } else {
            $data = [
                'success' => false,
                'message' => "Error, you need insert an userId(POST.user_id) and tokenId(POST.token_id)."
            ];
        }

        $this->renderError($data);
    }

    /**
     * Add a tracker when user drag an store on a website
     * POST /api/trackstore
     */
    public function trackStore()
    {
        $validForm = User::checkForm($this->f3->get('POST'), array(
            'token_id' => 'required',
            'user_id'  => 'required',
            'store_id' => 'required',
            'on_url'   => 'required',
            'full_url' => 'required'
        ));

        if ($validForm === true) {
            $user = User::where('id', $this->f3->get('POST.user_id'))->where('token_api', $this->f3->get('POST.token_id'))->first();

            if ($user !== null || !empty($user)) {

                TrackerStore::create(array(
                    'user_id'  => $this->f3->get('POST.user_id'),
                    'store_id' => $this->f3->get('POST.store_id'),
                    'on_url'   => $this->f3->get('POST.on_url'),
                    'full_url' => $this->f3->get('POST.full_url')
                ));

                return;
            } else {
                $data = [
                    'success' => false,
                    'message' => "Error, can't find an account with user_id(".$this->f3->get('POST.user_id').") and token_id(".$this->f3->get('POST.token_id').")."
                ];
            }

        } else {
            $data = [
                'success' => false,
                'message' => "Error, you need insert an tokenId(POST.token_id) and userId(POST.user_id) and storeId(POST.store_id) and onUrl(POST.on_url) and fullUrl(POST.full_url)."
            ];
        }

        $this->renderError($data);
    }

    /**
     * Tracking PAGE
     * GET /api/categories/@user_id
     */
    public function getCategoryList()
    {
        $userId = $this->f3->get('PARAMS.user_id');

        if(!empty($userId)){
            $categories                         = Category::where('user_id','=', $userId)->get();
            $categoriesJson["categoryList"]     = [];

            for($i = 0; $i < count($categories); $i++){
                $categoriesJson["categoryList"][] = [
                    "id" => $categories[$i]->id,
                    "text" => $categories[$i]->label
                ];
            }

            $this->render(false, $categoriesJson);
        }

    }

    /**
     * Tracking PAGE
     * POST /api/trackedlink
     */
    public function getTrackedLink()
    {
        $userId = $this->f3->get('POST.user_id');
        $catId  = $this->f3->get('POST.cat_id');
        $from   = Carbon::parse($this->f3->get('POST.from'));
        $to     = Carbon::parse($this->f3->get('POST.to'));
        $json['data'] = [];

        if (!empty($userId) && !empty($catId)) {
            $stores = Store::where('user_id', '=', $userId)->where('category_id', '=', $catId)->where('is_shorter', '=', 1)->get();
            for ($i = 0; $i < count($stores); $i++) {
                $store_id           = $stores[$i]->id;
                $store_name         = $stores[$i]->label;
                $store_created_at   = $stores[$i]->created_at;

                $url    = Url::where('store_id', '=', $store_id)->first();
                $url_id = $url->id;

                $trackerUrlCount    = TrackerUrl::where('url_id', '=', $url_id)->count();
                $trackerUrl         = TrackerUrl::where('url_id', '=', $url_id)->orderBy('created_at', 'ASC')->get();

                $graphData = [];

                for ($j = 0; $j < count($trackerUrl); $j++) {
                    if(Carbon::parse($trackerUrl[$j]->created_at)->between($from, $to)){

                        $day    = Carbon::parse($trackerUrl[$j]->created_at)->day;
                        $month  = Carbon::parse($trackerUrl[$j]->created_at)->month;
                        if (!isset($graphData['0'.$month.'-'.$day])) {
                            $graphData['0'.$month.'-'.$day] = 0;
                        }
                        if (isset($graphData['0'.$month.'-'.$day])) {
                            $graphData['0'.$month.'-'.$day] += 1;
                        }

                    }
                }

                $json['data'][] = [
                    'snippetName' => $store_name,
                    'nbClick'     => $trackerUrlCount,
                    'createdAt'   => Carbon::parse($store_created_at)->toDateString(),
                    'graphData'   => $graphData
                ];

            }
            $this->render(false, $json);
        }
    }

    /**
     * Tracking PAGE
     * GET /api/categoryglobal/@user_id/@cat_id
     */
    public function getCategoryGlobal()
    {

    }

    /**
     * Render the Json with custom Header
     *
     * @param array $data
     */
    private function renderError($data)
    {
        header("HTTP/1.0 404 Not Found");
        $this->render(false, $data);
    }
}