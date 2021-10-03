<?php

namespace Latus\BasePlugin\Database\Seeders;

use Illuminate\Database\Seeder;
use Latus\Content\Services\ContentService;

class PageSeeder extends Seeder
{
    public function __construct(
        protected ContentService $contentService
    )
    {
    }

    protected array $pages = [
        ['name' => 'page--home', 'type' => 'page', 'title' => 'Home', 'text' => 'This is a landing page.'],
        ['name' => 'page--about', 'type' => 'page', 'title' => 'About', 'text' => 'Something about this website.'],
        ['name' => 'page--contact', 'type' => 'page', 'title' => 'Contact Us', 'text' => 'Contact form.'],
    ];

    public function run()
    {
        foreach ($this->pages as $page) {
            if (!$this->contentService->findByName($page['name'])) {
                $this->contentService->createContent($page);
            }
        }
    }
}