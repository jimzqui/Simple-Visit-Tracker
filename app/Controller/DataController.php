<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Functions', 'Lib');

/**
 * Data Controller
 *
 * @property Data $Data
 * @property Component $RequestHandler
 */
class DataController extends AppController {

    public $components = array('RequestHandler');
    public $autoRender = false;

    /**
     * Display map
     *
     * @return void
     */
    public function index() {

        // Disable layout
        $this->autoRender = true;
    }

    /**
     * Event stream geting data from a track file
     *
     * @return void
     */
    public function track() {

        // Set headers
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        // Load track model
        $this->loadModel('Track');

        // Get latest tracks
        $tracks = $this->Track->latest();

        // Iterate tracks
        foreach ($tracks as $track) {
            $content = json_encode($track['Track'], true);
            echo "data: {$content}\n";
        }
        
        // Flush data
        echo "\n\n";
        flush();
    }

    /**
     * Pushes data to the track file
     *
     * @return void
     */
    public function push() {

        // Get data from query string
        $action = (isset($this->request->query['action'])) ? $this->request->query['action'] : null;
        $source = (isset($this->request->query['source'])) ? $this->request->query['source'] : null;
        $userip = (isset($this->request->query['userip'])) ? $this->request->query['userip'] : null;

        // Load track model
        $this->loadModel('Track');

        // Get location
        $geoip = $this->geoIp($userip);
        $location = $geoip['GeoIpLocation'];

        // Add new track
        $this->Track->add(array(
            'action' => $action,
            'source' => $source,
            'userip' => $userip,
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude']
        ));

        // Decode base64
        $data = 'R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
        $data = base64_decode($data);

        // Display image
        $im = imagecreatefromstring($data);
        $this->response->type('png');
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * Return info by $ip using maxmind geoip
     *
     * @param string $ip
     * @return array $result
     */
    public function geoIp($ip) {

        // Get location
        App::uses('GeoIpLocation', 'GeoIp.Model');
        $GeoIpLocation = new GeoIpLocation();
        $result = $GeoIpLocation->find($ip);

        // Return result
        return $result;
    }

    /**
     * Return info by $ip
     *
     * @return array $result
     */
    public function ipInfo() {

        // Get IP
        $ip = (isset($this->request->query['ip'])) ? $this->request->query['ip'] : null;

        // Read cache
        $result = Cache::read($ip, 'longterm');

        // Cache not found
        if (!$result) {

            // Curl to ipinfo
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'ipinfo.io/' . $ip);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // Get result
            $result = curl_exec ($ch);
            curl_close($ch);

            // Cache result
            Cache::write($ip, $result, 'longterm');
        }

        // Return result
        return $result;
    }

}