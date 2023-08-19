<?php

namespace Botble\Dashboard\Repositories\Eloquent;

use Botble\Dashboard\Models\DashboardWidgetSetting;
use Illuminate\Support\Facades\Auth;
use Botble\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class DashboardWidgetSettingRepository extends RepositoriesAbstract implements DashboardWidgetSettingInterface
{
    public function getListWidget()
    {
        /**
         * @var DashboardWidgetSetting $model
         */
        $model = $this->model;

        $data = $model
            ->select([
                'id',
                'order',
                'settings',
                'widget_id',
            ])
            ->with('widget')
            ->orderBy('order')
            ->where('user_id', Auth::id())
            ->get();

        $this->resetModel();

        return $data;
    }
}
