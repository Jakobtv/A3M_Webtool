<?php

namespace App\controller;

class BaseController {
    public $viewsPath = __DIR__ . '/../view/';

    public function loadView($viewName, $subDir = '', $data = []) {
        $path = $this->viewsPath . ($subDir ? '/' . $subDir . '/' : '') . $viewName . '.php';
        
        if (file_exists($path)) {
            
            extract($data);
            require($path);
        } else {
            echo "Die Seite >> $viewName << konnte nicht aufgerufen werden";
            echo $path;
            
        }
    }
    
} 