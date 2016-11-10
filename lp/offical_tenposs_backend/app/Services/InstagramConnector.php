<?php

namespace App\Services;

use MetzWeb\Instagram\Instagram;

class InstagramConnector extends Instagram
{
    public function getRecentUserMedia($id = 'self', $limit = 0) {
	    return $this->_makeCall('users/' . $id . '/media/recent', true, array('count' => $limit));
	}
}
?>