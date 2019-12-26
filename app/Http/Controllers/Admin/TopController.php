<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller as AdminController;

class TopController extends AdminController
{
    /**
     * Top page
     */
    public function indexAction()
    {
        return $this->view('admin/top/index');
    }
}
