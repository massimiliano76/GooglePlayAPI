<?php namespace RachidLaasri\GooglePlayAPI;

interface Market {

    /**
     * Set the application url.
     *
     * @param $appURL
     * @return mixed
     */
    public function app($appURL);

    /**
     * Get application URL.
     *
     * @return string
     */
    public function getAppURL();

    /**
     * Get application Title.
     *
     * @return string
     */
    public function getAppTitle();

    /**
     * Get application publish date.
     *
     * @return string
     */
    public function getAppPublishDate();

    /**
     * Get application price.
     *
     * @return string
     */
    public function getAppPrice();

    /**
     * Get application version.
     *
     * @return string
     */
    public function getAndroidVersion();

    /**
     * Get application banner.
     *
     * @return string
     */
    public function getAppBanner();

    /**
     * Get application screenshots.
     *
     * @return array
     */
    public function getAppScreenshots();

    /**
     * Get application last updated.
     *
     * @return string
     */
    public function getAppLastUpdated();

    /**
     * Get application installation count.
     *
     * @return string
     */
    public function getInstallationCount();

    /**
     * Get author name.
     *
     * @return string
     */
    public function getAuthorName();

    /**
     * Get author store URL.
     *
     * @return string
     */
    public function getAuthorStoreURL();

    /**
     * Get author URL.
     *
     * @return string
     */
    public function getAuthorWebsite();

    /**
     * Get author email.
     *
     * @return string
     */
    public function getAuthorEmail();

    /**
     * Get HTML description.
     *
     * @return mixed
     */
    public function getHTMLDescription();

    /**
     * Get plain text description.
     *
     * @return string
     */
    public function getPlainTextDescription();

    /**
     * Get HTML what's new.
     *
     * @return mixed
     */
    public function getHTMLUpdates();

    /**
     * Get plain text what's new.
     *
     * @return string
     */
    public function getPlainTextUpdates();
}