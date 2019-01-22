<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 11:47
 */

http://wx.mxcs.com/#/repair/create


initData: {},

// 数据初始化
created () {
this.initData = {...this.data}
    // console.log('initData4563', this.initData)
  },

  this.data = {...this.initData}


'PDF' => Barryvdh\DomPDF\Facade::class,
        Barryvdh\DomPDF\ServiceProvider::class,
ALTER TABLE  `service_order_parts` ADD  `tax_rate` INT( 11 ) NOT NULL DEFAULT  '6' COMMENT  '16，10% 10，6% 6，不含税 0' AFTER  `amount_dis`
ALTER TABLE  `service_order_parts` ADD  `remark` TEXT NULL COMMENT  '备注' AFTER  `warranty_date`

php artisan make:model Models\ServiceOrderAttendance
php artisan make:model Models\ServiceOrderDocument

php artisan make:model Models\ServiceOrderPart
php artisan make:model Models\ServiceOrderRepair
php artisan make:model Models\ServiceOrderService

php artisan make:model Models\ServiceOrderConfirm
php artisan make:model Models\ServiceOrderFollowup

php artisan make:migration alert_table_service_order_attendances_add_remark --table=service_order_attendances

php artisan make:migration alert_table_service_order_followups_add_followup_time --table=service_order_followups

php artisan make:migration alert_table_service_order_repairs_add_next_step --table=service_order_repairs

php artisan make:migration alert_table_service_order_attendances_add_confirm_staff_id --table=service_order_attendances

php artisan make:migration alert_table_service_orders_add_cancel_cause --table=service_orders

php artisan make:migration alert_table_service_orders_add_dep_id --table=service_orders

php artisan make:migration alert_table_service_order_faults_add_date_remark --table=service_order_faults

php artisan make:migration alert_table_service_order_attendances_add_remark2 --table=service_order_attendances

php artisan make:migration alert_table_service_order_repairs_add_evaluate --table=service_order_repairs

    php artisan make:migration alert_table_base_documents_add_up_from --table=base_documents

11     console.time('serialFn')
12     console.log(await asyncAwaitFn('string 1'));
13     console.log(await asyncAwaitFn('string 2'));
14     console.timeEnd('serialFn')

图片上传实际目录api\storage\app\public\2019\01
<img data-v-f5c47720="" width="100" src="

            <a href=\"\" ><img data-v-f5c47720=\"\" width=\"100\" src=\"https://mp.mxhj.net/file/image/?id=106&amp;time=1548039808.0864&amp;filename=img_1548039808.1024.jpeg&amp;source_name=1000.jpg\" alt=\"img_1548039808.1024.jpeg\"></a>
            
https://mp.mxhj.net/file/image/?id=106&amp;time=1548039808.0864&amp;filename=img_1548039808.1024.jpeg&amp;source_name=1000.jpg" alt="img_1548039808.1024.jpeg">

    https://mp.mxhj.net/fileBack/image/?id=106&amp;time=1548039808.0864&amp;filename=img_1548039808.1024.jpeg&amp;source_name=1000.jpg

ALTER TABLE `service_order_repairs` ADD `is_solve` tinyint(4) DEFAULT NULL COMMENT '是否解决: 1是,0否' AFTER `next_step`,
ADD  `overall_satisfaction` tinyint(4) DEFAULT NULL COMMENT '整体满意度,5星,10分制',
ADD  `timeliness` tinyint(4) DEFAULT NULL COMMENT '服务及时性,5星,10分制',
ADD  `service_staff_atisfaction` tinyint(4) DEFAULT NULL COMMENT '服务人员满意度,5星,10分制',
ADD  `cost_performance` tinyint(4) DEFAULT NULL COMMENT '性价比满意度,5星,10分制',
ADD  `confirm_user_id` int(11) DEFAULT NULL COMMENT '确认用户id',
ADD  `confirm_user_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '确认用户名字',
ADD  `opinions_suggestions` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '意见与建议'