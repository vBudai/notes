<?php

namespace base;



abstract class BaseController
{

    protected function view(string $templateName, array $data = []): bool|string
    {
        $template = file_get_contents("templates/$templateName");
        extract($data, EXTR_SKIP);

        ob_start();
        eval("?>$template");
        $templateContent = ob_get_contents();
        ob_clean();

        return $templateContent;
    }

}