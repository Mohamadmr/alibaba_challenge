<?php

namespace App\Models\Enums;

enum ArticlePublishTypeEnum: int
{
    case draft = 0;
    case published = 1;
}
