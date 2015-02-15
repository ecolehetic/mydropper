<?php
namespace APP\CONTROLLERS {

    use APP\MODELS\User as User;
    use APP\MODELS\Store as Store;

    class DashboardController extends BaseController{

        /*
        *   GET dashboard
        */
        public function index(){

            $user = $this->loggedRequire();

            $stores = Store::where('user_id','=',$user->id )->with('trackerstores')->get();

            $this->render(true, [
                'user'=>$user,
                'stores'=>$stores
            ]);
        }

    }
}