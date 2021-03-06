<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Vidlis\CoreBundle\GoogleApi\Client;


/**
 * Class AuthController
 *
 * Manage Youtube Connexion
 */
class AuthController extends Controller
{
    
    protected $client;

    /**
     * GET youtube connextion token
     * @Route("/authconfirmation", name="_youtubeauthentication")
     */
    public function authAction()
    {
        $this->initialize();
        
        $data = array();
        $auth = 'false';
        $session = $this->getRequest()->getSession();
        
        if ($this->getRequest()->query->get('code')) {
            if (strval($session->get('stateYoutube')) !== strval($this->getRequest()->query->get('state'))) {
                die('The session state did not match.');
            }

            $this->client->authenticate();
            $session->set('token', $this->client->getAccessToken());
            $auth = 'true';
        }

        if ($session->get('token')) {
          $this->client->setAccessToken($session->get('token'));
        }
        
        $data['auth'] = $auth;
        return $this->render('VidlisCoreBundle:Auth:auth.html.twig', $data);
    }

    /**
     * Init YoutubeAuthentication Token
     */
    public function initialize() {
        $OAUTH2_CLIENT_ID = $this->container->getParameter('OAUTH2_CLIENT_ID');
        $OAUTH2_CLIENT_SECRET = $this->container->getParameter('OAUTH2_CLIENT_SECRET');
        $this->client = new Client();
        $this->client->setClientId($OAUTH2_CLIENT_ID);
        $this->client->setClientSecret($OAUTH2_CLIENT_SECRET);
        $this->client->setScopes('https://gdata.youtube.com');
        $redirect = filter_var($this->generateUrl('_youtubeauthentication', array(), UrlGeneratorInterface::ABSOLUTE_URL),
          FILTER_SANITIZE_URL);
        $this->client->setRedirectUri($redirect);
    }
}
