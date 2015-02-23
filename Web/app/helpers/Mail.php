<?php

namespace MyDropper\Helpers;

use MyDropper\Models\User;

/**
 * Class Mail
 * Simple class for easily seed mail
 * @package Mydropper\HELPERS
 */
class Mail extends BaseHelper
{

    private $smtp;
    private $twig;

    public function __construct()
    {
        parent::__construct();

        $this->twig = $this->f3->get('TWIG');

        $this->smtp = new \SMTP ($this->f3->get('MAIL_HOST'), $this->f3->get('MAIL_PORT'),
            $this->f3->get('MAIL_SCHEME'), $this->f3->get('MAIL_USER'), $this->f3->get('MAIL_PASS'));
    }

    /**
     *  Seed a mail
     *  You must add add data (subject)
     *
     * @param string $template
     * @param string $to
     * @param array  $data
     *
     * @return bool
     */
    public function seed($template = 'default', $to, $data = array())
    {
        $this->smtp->set('Content-type', 'text/html; charset=UTF-8');
        $this->smtp->set('From', '"MyDropper" <' . $this->f3->get('MAIL_USER') . '>');
        $this->smtp->set('To', '<' . $to . '>');
        $this->smtp->set('Subject', $data['subject']);

        if ($this->getFirstname($to) !== false) {
            $firstname = $this->getFirstname($to);
            return $this->smtp->send($this->layoutMail($template, $firstname, $data));
        } else {
            return false;
        }
    }

    /**
     * Get the firstname with the mail
     *
     * @param string $mail
     *
     * @return string firstname
     */
    private function getFirstname($mail)
    {
        $user = User::where('mail', $mail)->first();

        if ($user !== null || !empty($user)) {
            return $user->firstname;
        }

        return false;

    }

    /**
     * Return the HTML of the mail base of the layout
     *
     * @param string $template
     * @param string $firstname
     * @param array  $content
     *
     * @return string
     */
    private function layoutMail($template, $firstname, $content = array())
    {
        $template = $this->twig->loadTemplate('mail/' . $template . '.twig');

        $content['firstname'] = $firstname;

        return $template->render($content);
    }

}