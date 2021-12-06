<?php

class jumbo
{


    function getJumbo($title, $detail)
    {

        return '
            <div class="jumbotron py-5 mt-5">
                <h2 class="display-4">' . $title . '</h2>
                <p class="lead">' . $detail . '</p>
                <hr class="my-4">
            </div>
            ';
    }
}
