<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends BaseController
{
    //
    public function index(Request $request, Organization $organization)
    {
        $organization = $this->search($request, $organization);

        return $this->paginate($organization);
    }

    public function search(Request $request, Organization $organization)
    {
        if ($name = $request->get('name', '')) {
            $organization = $organization->where('name', 'like', like($name));
        }

        if ($id = $request->get('id', 0)) {
            $organization = $organization->where('id', $id);
        }

        return $organization;
    }
}
