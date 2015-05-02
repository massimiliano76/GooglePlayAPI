<?php namespace RachidLaasri\GooglePlayAPI;

use Exception;

trait Parser {

    /**
     * @var application URL.
     */
    protected $appURL = null;

    /**
     * @var Save application screenshots.
     */
    protected $saveImages = false;

    /**
     * @var Directory to save screenshots to.
     */
    protected $imagesDir = './images/';

    /**
     * @var Cache directory.
     */
    protected $tempDir = './temp/';

    /**
     * @var Application page source.
     */
    protected $html;

    /**
     * @var Parsed information.
     */
    protected $appInfo = [];

    /**
     * @var Time to clear temp in seconds.
     */
    protected $cacheTime = 120;

    /**
     * @var crawler.
     */
    protected $crawler = 0;

    public function __construct(simple_html_dom $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Set application URL.
     *
     * @param $appURL
     * @return mixed
     * @throws Exception
     */
    private function setURL($appURL)
    {
        if (filter_var($appURL, FILTER_VALIDATE_URL) === FALSE) {
            throw new Exception('Whoops! it looks like you entered an invalid URL.');
        }

        $response = get_headers($appURL)[0];

        if($response === 'HTTP/1.1 404 Not Found') {
            throw new Exception('Whoops! fFailed to open stream, page Not Found.');
        }

        return $appURL;
    }

    /**
     * Override default options.
     *
     * @param array $options
     * @return $this
     */
    public function config($options = [])
    {
        foreach($options as $key => $value)
        {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * Get the temp folder.
     *
     * @return $this
     * @throws exception
     */
    private function getTemp()
    {
        if( !is_dir($this->tempDir) ){
            throw new exception('Whoops! cache folder does not exist.');
        }

        if( !is_writable($this->tempDir) ){
            throw new exception('Whoops! cache folder is not writable.');
        }

        return $this->tempDir;
    }

    /**
     * Get the temp time.
     *
     * @return $this
     */
    private function getCacheTime()
    {
        return (int)$this->cacheTime;
    }

    /**
     * Determine if saving images is enabled.
     *
     * @return Save
     */
    private function isSaveImagesEnabled()
    {
        return $this->saveImages;
    }

    /**
     * Parse URL and get elements;
     *
     * @return $this
     */
    private function parse()
    {
        $this->loadHTMLCode();

        return $this;
    }

    /**
     * Get page source code.
     *
     * @return $this
     */
    private function loadHTMLCode()
    {
        $filename = $this->filename();

        if( file_exists($filename) ){
            $lastUpdate = time() - filemtime($filename);
            if($lastUpdate < $this->getCacheTime()) {
                $this->html = str_get_html(file_get_contents($filename));
                return;
            }
        }

        $this->getHTMLCode();
    }

    /**
     * Get page source code.
     *
     * @return mixed
     */
    private function getHTMLCode()
    {
        $html  = file_get_contents($this->appURL);

        file_put_contents($this->filename(), $html);

        $this->html = str_get_html($html);
    }

    /**
     * Get filename.
     *
     * @return string
     * @throws Exception
     */
    private function filename()
    {
        return $this->getTemp() . md5($this->appURL);
    }

}