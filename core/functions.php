<?php
    /**
     * Created by User: gurjot
     * @param $location
     */

    function redirect($location) {
        return header("Location: {$location}");
    }

    function validationErrors($errorMessage) {
        $errorMessage = <<<DELIMITER
<div class="alert alert-danger alert-dismissible" role="alert">
   <strong>Warning!</strong> $errorMessage
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
</div>
DELIMITER;
        return $errorMessage;
    }