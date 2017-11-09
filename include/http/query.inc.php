<?php 
namespace http;

class Query{
    public $m_cURLSession;
    public $m_queryResponse;

    public function __construct(String $url = NULL) {

        if(is_null($url)) {
            $this->init();
            return;
        }

        $this->init($url);
        return;
    }

    private function init(String $url = NULL) {
        // Returns a cURL Handle and if an Error occurs FALSE
        if($url != NULL) {
            $this->m_cURLSession = curl_init($url);
            return;
        }

        $this->m_cURLSession = curl_init();
        return;
    }

    public function execute() {
        return curl_exec($this->m_cURLSession);
    }

    public function close() {
        curl_close($this->m_cURLSession);
    }

    public function setOption(int $key, $value) {
        curl_setopt($this->m_cURLSession, $key, $value);
    }
}
?>