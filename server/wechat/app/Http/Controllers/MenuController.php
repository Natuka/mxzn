<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
        $app = app('wechat.official_account');
        return $app->menu->list();
    }

    public function create(Request $request)
    {
        $app = app('wechat.official_account');

        $buttons = [
            [
                "name" => "关于明鑫",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "走进明鑫",
                        "url" => "http://mxhj.net/list.asp?typeid=1&sortid=30"
                    ],
                    [
                        "type" => "view",
                        "name" => "企业文化",
                        "url" => "http://mxhj.net/list.asp?typeid=1&sortid=45"
                    ],
                    [
                        "type" => "view",
                        "name" => "历史沿革",
                        "url" => "http://mxhj.net/list.asp?typeid=1&sortid=46"
                    ],
                    [
                        "type" => "view",
                        "name" => "明鑫风采",
                        "url" => "http://mxhj.net/list.asp?typeid=3&sortid=49"
                    ],
                    [
                        "type" => "view",
                        "name" => "资质荣誉",
                        "url" => "http://mxhj.net/list.asp?typeid=3&sortid=88"
                    ],
                    [
                        "type" => "view",
                        "name" => "联系我们",
                        "url" => "http://mxhj.net/list.asp?typeid=3&sortid=88"
                    ],
                ],
            ],
            [
                "name" => "产品方案",
                "type" => "view",
                "url" => "http://mxhj.net/list.asp?typeid=6&sortid=11"
            ],
            [
                "name" => "客户服务",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "我的设备",
                        "url" => "https://mp.mxhj.net/menu/equipment"
                    ],
                    [
                        "type" => "view",
                        "name" => "我的工单",
                        "url" => "https://mp.mxhj.net/menu/service-orders"
                    ],
                    [
                        "type" => "view",
                        "name" => "服务评价",
                        "url" => "https://mp.mxhj.net/menu/evaluate"
                    ],
                    [
                        "type" => "view",
                        "name" => "故障报修",
                        "url" => "https://mp.mxhj.net/menu/service-order-create"
                    ],
                ],
            ],

        ];
        $app->menu->create($buttons);
        return 'create success!';
    }

    /**
     * 我的设备，设备跳转到设备列表
     * @param Request $request
     */
    public function equipment(Request $request)
    {
        return redirect('/?#/equipment/list');
    }

    /**
     * 我的工单
     * @param Request $request
     */
    public function serviceOrders(Request $request)
    {
        return redirect('/?#/repair/list');
    }

    /**
     * 工单评价
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function evalute(Request $request)
    {
        return redirect('/?#/evaluate/last?last=1');
    }
    /**
     * 工单评价
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function evaluteByServiceOrderId(Request $request, $order_id)
    {
        return redirect('/?#/evaluate/last?order_id=' . $order_id);
    }

    /**
     * 工单创建
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function serviceOrderCreate(Request $request)
    {
        return redirect('/?#/repair/create');
    }
}
