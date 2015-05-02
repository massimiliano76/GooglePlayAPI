<?php namespace RachidLaasri\GooglePlayAPI;

class GooglePlay implements Market {

    use Parser;

    const TITLE_SELECTOR = '.document-title';
    const PUBLISH_DATE_SELECTOR = 'div.document-subtitle';
    const APP_PRICE_SELECTOR = 'button[class="price buy id-track-click"]';
    const ANDROID_VERSION_SELECTOR = 'div[itemprop=operatingSystems]';
    const APP_BANNER_SELECTOR = 'img[class=cover-image]';
    const APP_SECREENSHOTS_SELECTOR = '';
    const APP_LAST_UPDATED_SELECTOR = 'div[itemprop=datePublished]';
    const INSTALLATION_COUNT_SELECTOR = 'div[itemprop=numDownloads]';
    const AUTHOR_NAME_SELECTOR = 'div[itemprop=name]';
    const AUTHOR_STORE_SELECTOR = 'a[class="document-subtitle primary"]';
    const AUTHOR_WEBSITE_SELECTOR = 'a.dev-link';
    const AUTHOR_EMAIL_SELECTOR = 'a.dev-link';
    const HTML_DESCRIPTION_SELECTOR = 'div.id-app-orig-desc';
    const HTML_UPDATES_SELECTOR = 'div.recent-change';

    /**
     * Set the application url.
     *
     * @param $appURL
     * @return $this
     */
    public function app($appURL)
    {
        $this->appURL = $this->setURL($appURL);

        $this->parse();

        return $this;
    }

    /**
     * Get application URL.
     *
     * @return string
     */
    public function getAppURL()
    {
        return $this->appURL;
    }

    /**
     * Get application Title.
     *
     * @return string
     */
    public function getAppTitle()
    {
        return $this->html->find(self::TITLE_SELECTOR, 0)->plaintext;
    }

    /**
     * Get application publish date.
     *
     * @return string
     */
    public function getAppPublishDate()
    {
        $date = $this->html->find(self::PUBLISH_DATE_SELECTOR, 0)->plaintext;

        return str_replace('- ', '', $date);
    }

    /**
     * Get application price.
     *
     * @return string
     */
    public function getAppPrice()
    {
        $tag = $this->html->find(self::APP_PRICE_SELECTOR, 0)->children(2)->plaintext;

        return $tag == 'Install ' ? 'FREE' : $tag;

    }

    /**
     * Get application version.
     *
     * @return string
     */
    public function getAndroidVersion()
    {
        return $this->html->find(self::ANDROID_VERSION_SELECTOR, 0)->plaintext;
    }

    /**
     * Get application banner.
     *
     * @return string
     */
    public function getAppBanner()
    {
        return $this->html->find(self::APP_BANNER_SELECTOR, 0)->src;
    }

    /**
     * Get application screenshots.
     *
     * @return array
     */
    public function getAppScreenshots()
    {
        $images = [];

        foreach($this->html->find('img[itemprop="screenshot"]') as $image)
        {
            $images[] = $this->saveImage($image->src);
        }

        return $images;
    }

    private function saveImage($image)
    {
        if( $this->isSaveImagesEnabled() ){

            $filename = $this->randomFileName();
            $image = $this->filter($image);
            $this->save($image, $filename);

            return $filename;
        }

        return $image;

    }

    /**
     * Get application last updated.
     *
     * @return string
     */
    public function getAppLastUpdated()
    {
        return $this->html->find(self::APP_LAST_UPDATED_SELECTOR, 0)->plaintext;
    }

    /**
     * Get application installation count.
     *
     * @return string
     */
    public function getInstallationCount()
    {
        return $this->html->find(self::INSTALLATION_COUNT_SELECTOR, 0)->plaintext;
    }

    /**
     * Get author name.
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->html->find(self::AUTHOR_NAME_SELECTOR, 0)->plaintext;
    }

    /**
     * Get author store URL.
     *
     * @return string
     */
    public function getAuthorStoreURL()
    {
        $URI = $this->html->find(self::AUTHOR_STORE_SELECTOR, 0)->href;

        return "http://play.google.com/{$URI}";
    }

    /**
     * Get author URL.
     *
     * @return string
     */
    public function getAuthorWebsite()
    {
        return $this->html->find(self::AUTHOR_WEBSITE_SELECTOR, 0)->href;
    }

    /**
     * Get author email.
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        $URL = $this->html->find(self::AUTHOR_EMAIL_SELECTOR, 1)->href;

        return str_replace('mailto:', '', $URL);
    }

    /**
     * Get HTML description.
     *
     * @return mixed
     */
    public function getHTMLDescription()
    {
        return $this->html->find(self::HTML_DESCRIPTION_SELECTOR, 0)->outertext;
    }

    /**
     * Get plain text description.
     *
     * @return string
     */
    public function getPlainTextDescription()
    {
        return $this->html->find(self::HTML_DESCRIPTION_SELECTOR, 0)->plaintext;
    }

    /**
     * Get HTML what's new.
     *
     * @return mixed
     */
    public function getHTMLUpdates()
    {
        $lines = [];

        foreach($this->html->find(self::HTML_UPDATES_SELECTOR) as $line)
        {
            $lines[] = $line->plaintext;
        }

        return implode(" <br />", $lines);
    }

    /**
     * Get plain text what's new.
     *
     * @return string
     */
    public function getPlainTextUpdates()
    {
        return strip_tags($this->getHTMLUpdates());
    }

    /**
     * Get property if not exist.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!method_exists($this, $name) && !property_exists($this, $name)) {

            $properties = $this->getProperty();

            return $this->$properties[$name]();
        }

    }

    /**
     * Assign method to property.
     *
     * @return array
     */
    private function getProperty()
    {
        $this->appInfo = [
            'URL' => 'getAppURL',
            'title' => 'getAppTitle',
            'published_at' => 'getAppPublishDate',
            'price' => 'getAppPrice',
            'required_version' => 'getAndroidVersion',
            'icon' => 'getAppBanner',
            'screenshots' => 'getAppScreenshots',
            'last_updated' => 'getAppLastUpdated',
            'installation_count' => 'getInstallationCount',
            'author_name' => 'getAuthorName',
            'author_store_URL' => 'getAuthorStoreURL',
            'author_website' => 'getAuthorWebsite',
            'author_email' => 'getAuthorEmail',
            'HTML_description' => 'getHTMLDescription',
            'plain_text_description' => 'getPlainTextDescription',
            'HTML_updates' => 'getHTMLUpdates',
            'plain_text_updates' => 'getPlainTextUpdates'
        ];

        return $this->appInfo;
    }

    /**
     * Generate random file name.
     *
     * @return string
     */
    private function randomFileName()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10) . '.jpg';
    }

    /**
     * Get better quality images.
     *
     * @param $image
     * @return mixed
     */
    private function filter($image)
    {
        $replace = ['=h310', '//i.ytimg.com/'];
        $with = ['', 'http://i.ytimg.com/'];

        return str_replace($replace, $with, $image);
    }

    /**
     * Save single image.
     *
     * @param $image
     * @param $filename
     */
    private function save($image, $filename)
    {
        $imageString = file_get_contents($image);

        file_put_contents($this->imagesDir . $filename, $imageString);
    }
}