<?php

namespace APP\HELPERS;

use APP\MODELS\User;

/**
 * Class Mail
 * Simple class for easily seed mail
 * @package APP\HELPERS
 */
class Mail extends BaseHelper
{

    const LAYOUT_MAIL = "layout/mail.twig";

    private $smtp;
    private $twig;

    public function __construct()
    {
        parent::__construct();

        $this->twig = $this->f3->get('TWIG');

        $this->smtp = new \SMTP (
            $this->f3->get('MAIL_HOST'),
            $this->f3->get('MAIL_PORT'),
            $this->f3->get('MAIL_SCHEME'),
            $this->f3->get('MAIL_USER'),
            $this->f3->get('MAIL_PASS')
        );
    }

    /**
     *  Seed a mail
     *
     * @param string $to
     * @param $subjet
     * @param string $message
     *
     * @return bool
     */
    public function seed($to, $subjet, $message)
    {
        $this->smtp->set('Content-type', 'text/html; charset=UTF-8');
        $this->smtp->set('From', '"MyDropper" <' . $this->f3->get('MAIL_USER') . '>');
        $this->smtp->set('To', '<' . $to . '>');
        $this->smtp->set('Subject', $subjet);

        return $this->smtp->send($this->layoutMail($subjet, $this->getFirstname($to), $message));
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

        return $user->firstname;
    }

    /**
     * Return the HTML of the mail base of the layout
     *
     * @param string $title
     * @param string $firstname
     * @param string $content
     *
     * @return string
     */
    private function layoutMail($title, $firstname, $content)
    {
        $template = $this->twig->loadTemplate(self::LAYOUT_MAIL);

        $parameters = array(
            'title'     => $title,
            'firstname' => $firstname,
            'content'   => $content
        );

        return $template->renderBlock('body', $parameters);
    }

}