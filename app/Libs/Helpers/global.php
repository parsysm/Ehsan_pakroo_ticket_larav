<?php

if(!function_exists('generateUuid4')){
    function generateUuid4()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
}
