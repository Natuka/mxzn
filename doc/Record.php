<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 11:47
 */

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

11     console.time('serialFn')
12     console.log(await asyncAwaitFn('string 1'));
13     console.log(await asyncAwaitFn('string 2'));
14     console.timeEnd('serialFn')