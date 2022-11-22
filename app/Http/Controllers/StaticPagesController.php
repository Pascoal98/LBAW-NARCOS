<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller {

    public function getAboutUs() {
        return view('pages.staticPages.aboutUs');
    }

    public function getFAQ() {
        return view('pages.staticPages.faq');
    }
}