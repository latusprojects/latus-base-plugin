<?php

namespace Latus\BasePlugin\Models;

use Latus\Content\Models\Content;

class Page extends Content
{

    public function getMorphClass()
    {
        return Content::class;
    }
}